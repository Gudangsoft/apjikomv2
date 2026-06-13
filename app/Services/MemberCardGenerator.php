<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberCardTemplate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MemberCardGenerator
{
    private array $fs; // font settings
    private ?string $fontBoldPath;
    private ?string $fontRegularPath;

    public function generate(Member $member)
    {
        ini_set('memory_limit', '512M');

        $template = MemberCardTemplate::getActive();
        if (!$template) {
            throw new \Exception('No active card template found. Please upload a template first.');
        }

        if (!$member->member_number) {
            $member->generateMemberNumber();
            $member->refresh();
        }

        $templatePath = storage_path('app/public/' . $template->template_image);
        if (!file_exists($templatePath)) {
            throw new \Exception('Template image not found.');
        }

        // Resolve font settings (merge DB values over defaults)
        $this->fs = $template->mergedFontSettings();
        $this->resolveFontPaths();

        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        if ($img->width() > 1200) {
            $img->scale(width: 1200);
        }

        $cardWidth  = $img->width();
        $cardHeight = $img->height();

        $lineSpacing  = (int) $this->fs['line_spacing'];
        $dataStartX   = (int) $this->fs['data_start_x'];
        $dataStartY   = (int) $this->fs['data_start_y'];

        // Address wrapping
        $address      = $member->address ?: '-';
        $addressLines = $this->wrapText($address, 50, 3);
        $addressCount = count($addressLines);

        $totalDataLines  = 5 + $addressCount;
        $totalDataHeight = $totalDataLines * $lineSpacing;

        // Photo placement
        $centerX    = $cardWidth / 2;
        $photoX     = 140;
        $photoWidth = 200;
        $photoHeight = 240;

        $dataCenterY = $dataStartY + ($totalDataHeight / 2);
        $photoY = max(220, min(280, $dataCenterY - ($photoHeight / 2)));

        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            $photoPath = storage_path('app/public/' . $member->photo);
            $photo = $manager->read($photoPath);
            if ($photo->width() > 600 || $photo->height() > 600) {
                $photo->scale(width: 600);
            }
            $photo->cover($photoWidth, $photoHeight);
            $img->place($photo, 'top-left', $photoX, $photoY);
        } else {
            $img->drawRectangle($photoX, $photoY, function ($r) use ($photoWidth, $photoHeight) {
                $r->size($photoWidth, $photoHeight);
                $r->background('#e8e8e8');
            });
            $img->text('NO PHOTO', $photoX + ($photoWidth / 2), $photoY + ($photoHeight / 2) - 10, function ($font) {
                $font->size(16);
                $font->color('#999999');
                $font->align('center');
                $font->valign('middle');
            });
        }

        // === HEADER ===
        $headerY        = (int) $this->fs['header_y'];
        $headerFontSize = (int) $this->fs['header_font_size'];
        $headerBold     = (bool) $this->fs['header_bold'];
        $headerFont     = $headerBold ? $this->fontBoldPath : $this->fontRegularPath;
        $fontColor      = $this->fs['font_color'];

        if ($headerFont) {
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, function ($font) use ($headerFont, $headerFontSize, $fontColor) {
                $font->file($headerFont);
                $font->size($headerFontSize);
                $font->color($fontColor);
                $font->align('center');
            });
        } else {
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, function ($font) use ($headerFontSize, $fontColor) {
                $font->size($headerFontSize);
                $font->color($fontColor);
                $font->align('center');
            });
        }

        // === DATA FIELDS ===
        $opts = $this->buildRenderOpts();

        $currentY = $dataStartY;

        $this->addLabelValue($img, 'No.Anggota', $member->member_number ?? 'N/A', $dataStartX, $currentY, $opts);
        $currentY += $lineSpacing;

        $name = $this->truncateText($member->user->name ?? 'N/A', 100);
        $this->addLabelValue($img, 'Nama', $name, $dataStartX, $currentY, $opts);
        $currentY += $lineSpacing;

        $institution = $this->truncateText($member->institution_name ?: '-', 45);
        $this->addLabelValue($img, 'Institusi', $institution, $dataStartX, $currentY, $opts);
        $currentY += $lineSpacing;

        $this->addLabelValue($img, 'Kontak', $member->phone ?: '-', $dataStartX, $currentY, $opts);
        $currentY += $lineSpacing;

        $this->addLabelValueMultiline($img, 'Alamat', $addressLines, $dataStartX, $currentY, $opts);
        $currentY += $lineSpacing * $addressCount;

        $this->addLabelValue($img, 'Berlaku', 'Seumur Hidup', $dataStartX, $currentY, $opts);

        // === DISAHKAN ===
        $disahkanX    = $cardWidth - 280;
        $disahkanY    = $cardHeight - 150;
        $approvalDate = $member->join_date
            ? \Carbon\Carbon::parse($member->join_date)->format('d M Y')
            : date('d M Y');
        $this->addLabelValue($img, 'Disahkan', $approvalDate, $disahkanX, $disahkanY, $opts);

        // === SAVE ===
        $filename = 'member_card_' . $member->id . '_' . time() . '.png';
        $savePath = 'member-cards/' . $filename;
        $fullPath = storage_path('app/public/' . $savePath);

        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $img->toPng()->save($fullPath);

        if ($member->member_card && Storage::disk('public')->exists($member->member_card)) {
            Storage::disk('public')->delete($member->member_card);
        }

        $member->update(['member_card' => $savePath, 'card_generated_at' => now()]);

        return $savePath;
    }

    /**
     * Generate a preview card image with sample data, returning base64 PNG.
     */
    public function generatePreview(MemberCardTemplate $template, array $fontSettingsOverride = []): string
    {
        ini_set('memory_limit', '512M');

        $templatePath = storage_path('app/public/' . $template->template_image);
        if (!file_exists($templatePath)) {
            throw new \Exception('Template image not found.');
        }

        $this->fs = array_merge(
            MemberCardTemplate::defaultFontSettings(),
            $template->font_settings ?? [],
            $fontSettingsOverride
        );
        $this->resolveFontPaths();

        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        if ($img->width() > 1200) {
            $img->scale(width: 1200);
        }

        $cardWidth  = $img->width();
        $cardHeight = $img->height();

        $lineSpacing = (int) $this->fs['line_spacing'];
        $dataStartX  = (int) $this->fs['data_start_x'];
        $dataStartY  = (int) $this->fs['data_start_y'];
        $centerX     = $cardWidth / 2;

        // Sample address
        $address      = 'Jln. Tanjung Duren Barat II No. 1 Grogol, Jakarta Barat 11470';
        $addressLines = $this->wrapText($address, 50, 3);
        $addressCount = count($addressLines);

        // Photo placeholder
        $photoX      = 140;
        $photoWidth  = 200;
        $photoHeight = 240;
        $totalHeight = (5 + $addressCount) * $lineSpacing;
        $photoY = max(220, min(280, $dataStartY + ($totalHeight / 2) - ($photoHeight / 2)));

        $img->drawRectangle($photoX, $photoY, function ($r) use ($photoWidth, $photoHeight) {
            $r->size($photoWidth, $photoHeight);
            $r->background('#d1d5db');
        });
        $img->text('FOTO', $photoX + ($photoWidth / 2), $photoY + ($photoHeight / 2) - 10, function ($f) {
            $f->size(20);
            $f->color('#6b7280');
            $f->align('center');
            $f->valign('middle');
        });

        // Header
        $headerY        = (int) $this->fs['header_y'];
        $headerFontSize = (int) $this->fs['header_font_size'];
        $headerFont     = (bool) $this->fs['header_bold'] ? $this->fontBoldPath : $this->fontRegularPath;
        $fontColor      = $this->fs['font_color'];

        if ($headerFont) {
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, fn($f) => $this->applyFont($f, $headerFont, $headerFontSize, $fontColor, 'center'));
        } else {
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, fn($f) => $this->applyFontFallback($f, $headerFontSize, $fontColor, 'center'));
        }

        // Data fields with sample data
        $opts     = $this->buildRenderOpts();
        $currentY = $dataStartY;

        $prefix = strtoupper(trim(\App\Models\Setting::getValue('member_number_prefix', 'APJIKOM')));
        $this->addLabelValue($img, 'No.Anggota', "{$prefix}.12062026.001",                  $dataStartX, $currentY, $opts); $currentY += $lineSpacing;
        $this->addLabelValue($img, 'Nama',        'Dr. Ahmad Maulidizen, SE.Sy, M.Sh, MM',  $dataStartX, $currentY, $opts); $currentY += $lineSpacing;
        $this->addLabelValue($img, 'Institusi',   'Universitas Dian Nusantara',              $dataStartX, $currentY, $opts); $currentY += $lineSpacing;
        $this->addLabelValue($img, 'Kontak',      '087873170896',                            $dataStartX, $currentY, $opts); $currentY += $lineSpacing;
        $this->addLabelValueMultiline($img, 'Alamat', $addressLines,                         $dataStartX, $currentY, $opts); $currentY += $lineSpacing * $addressCount;
        $this->addLabelValue($img, 'Berlaku',     'Seumur Hidup',                            $dataStartX, $currentY, $opts);

        // Disahkan
        $disahkanX = $cardWidth - 280;
        $disahkanY = $cardHeight - 150;
        $this->addLabelValue($img, 'Disahkan', '11 Jun 2026', $disahkanX, $disahkanY, $opts);

        return 'data:image/png;base64,' . base64_encode((string) $img->toPng());
    }

    private function resolveFontPaths(): void
    {
        $dir = storage_path('fonts/');

        $boldFile = $dir . ($this->fs['font_bold'] ?? 'arialbd.ttf');
        $regFile  = $dir . ($this->fs['font_regular'] ?? 'arial.ttf');

        $this->fontBoldPath    = file_exists($boldFile) ? $boldFile : null;
        $this->fontRegularPath = file_exists($regFile)  ? $regFile  : $this->fontBoldPath;
    }

    private function buildRenderOpts(): array
    {
        return [
            'label_font_size'  => (int)  $this->fs['label_font_size'],
            'value_font_size'  => (int)  $this->fs['value_font_size'],
            'label_bold'       => (bool) $this->fs['label_bold'],
            'value_bold'       => (bool) $this->fs['value_bold'],
            'label_width'      => (int)  $this->fs['label_width'],
            'label_gap'        => (int)  $this->fs['label_gap'],
            'font_color'       => $this->fs['font_color'],
            'font_bold_path'   => $this->fontBoldPath,
            'font_regular_path'=> $this->fontRegularPath,
            'line_height'      => 22,
        ];
    }

    private function addLabelValue($img, string $label, string $value, int $x, int $y, array $opts): void
    {
        $labelWidth = $opts['label_width'];
        $labelGap   = $opts['label_gap'];
        $color      = $opts['font_color'];
        $labelSize  = $opts['label_font_size'];
        $valueSize  = $opts['value_font_size'];
        $labelFont  = $opts['label_bold']  ? $opts['font_bold_path']    : $opts['font_regular_path'];
        $valueFont  = $opts['value_bold']  ? $opts['font_bold_path']    : $opts['font_regular_path'];

        $colonX = $x + $labelWidth;
        $valueX = $colonX + $labelGap;

        if ($labelFont) {
            $img->text($label,   $x,       $y, fn($f) => $this->applyFont($f, $labelFont, $labelSize, $color, 'left'));
            $img->text(':',      $colonX,  $y, fn($f) => $this->applyFont($f, $labelFont, $labelSize, $color, 'left'));
            $img->text($value,   $valueX,  $y, fn($f) => $this->applyFont($f, $valueFont ?? $labelFont, $valueSize, $color, 'left'));
        } else {
            $img->text($label,  $x,       $y, fn($f) => $this->applyFontFallback($f, $labelSize, $color, 'left'));
            $img->text(':',     $colonX,  $y, fn($f) => $this->applyFontFallback($f, $labelSize, $color, 'left'));
            $img->text($value,  $valueX,  $y, fn($f) => $this->applyFontFallback($f, $valueSize, $color, 'left'));
        }
    }

    private function addLabelValueMultiline($img, string $label, array $lines, int $x, int $y, array $opts): void
    {
        $labelWidth = $opts['label_width'];
        $labelGap   = $opts['label_gap'];
        $color      = $opts['font_color'];
        $labelSize  = $opts['label_font_size'];
        $valueSize  = $opts['value_font_size'];
        $labelFont  = $opts['label_bold']  ? $opts['font_bold_path']    : $opts['font_regular_path'];
        $valueFont  = $opts['value_bold']  ? $opts['font_bold_path']    : $opts['font_regular_path'];
        $lineHeight = $opts['line_height'];

        $colonX = $x + $labelWidth;
        $valueX = $colonX + $labelGap;

        if ($labelFont) {
            $img->text($label, $x,      $y, fn($f) => $this->applyFont($f, $labelFont, $labelSize, $color, 'left'));
            $img->text(':',    $colonX, $y, fn($f) => $this->applyFont($f, $labelFont, $labelSize, $color, 'left'));
            $curY = $y;
            foreach ($lines as $line) {
                $img->text($line, $valueX, $curY, fn($f) => $this->applyFont($f, $valueFont ?? $labelFont, $valueSize, $color, 'left'));
                $curY += $lineHeight;
            }
        } else {
            $img->text($label, $x,      $y, fn($f) => $this->applyFontFallback($f, $labelSize, $color, 'left'));
            $img->text(':',    $colonX, $y, fn($f) => $this->applyFontFallback($f, $labelSize, $color, 'left'));
            $curY = $y;
            foreach ($lines as $line) {
                $img->text($line, $valueX, $curY, fn($f) => $this->applyFontFallback($f, $valueSize, $color, 'left'));
                $curY += $lineHeight;
            }
        }
    }

    private function applyFont($font, string $file, int $size, string $color, string $align): void
    {
        $font->file($file);
        $font->size($size);
        $font->color($color);
        $font->align($align);
    }

    private function applyFontFallback($font, int $size, string $color, string $align): void
    {
        $font->size($size);
        $font->color($color);
        $font->align($align);
    }

    private function truncateText($text, $length)
    {
        return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
    }

    private function wrapText($text, $maxCharsPerLine, $maxLines = 3)
    {
        $hasLineBreaks = strpos($text, "\n") !== false || strpos($text, "\r\n") !== false;

        if ($hasLineBreaks) {
            $text  = str_replace(["\r\n", "\r"], "\n", $text);
            $manual = explode("\n", $text);
            $lines  = [];
            foreach ($manual as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                if (strlen($line) > $maxCharsPerLine) {
                    foreach ($this->wrapLongLine($line, $maxCharsPerLine) as $wl) {
                        if (count($lines) < $maxLines) $lines[] = $wl;
                    }
                } else {
                    if (count($lines) < $maxLines) $lines[] = $line;
                }
                if (count($lines) >= $maxLines) break;
            }
            if (count($manual) > count($lines) && count($lines) > 0) {
                $lines[count($lines) - 1] = rtrim($lines[count($lines) - 1], '.') . '...';
            }
            return $lines;
        }

        return $this->wrapLongLine($text, $maxCharsPerLine, $maxLines);
    }

    private function wrapLongLine($text, $maxCharsPerLine, $maxLines = 3)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine . ($currentLine ? ' ' : '') . $word;
            if (strlen($testLine) <= $maxCharsPerLine) {
                $currentLine = $testLine;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    $lines[] = substr($word, 0, $maxCharsPerLine - 3) . '...';
                    $currentLine = '';
                }
                if (count($lines) >= $maxLines) break;
            }
        }

        if ($currentLine && count($lines) < $maxLines) {
            $lines[] = $currentLine;
        }

        if (count($lines) >= $maxLines) {
            $last = $lines[$maxLines - 1];
            $lines[$maxLines - 1] = strlen($last) > $maxCharsPerLine - 3
                ? substr($last, 0, $maxCharsPerLine - 3) . '...'
                : $last . '...';
        }

        return $lines;
    }
}
