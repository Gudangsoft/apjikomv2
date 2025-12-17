<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberCardTemplate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MemberCardGenerator
{
    /**
     * Generate member card
     */
    public function generate(Member $member)
    {
        // Get active template
        $template = MemberCardTemplate::getActive();
        
        if (!$template) {
            throw new \Exception('No active card template found. Please upload a template first.');
        }

        // Generate member number if not exists
        if (!$member->member_number) {
            $member->generateMemberNumber();
            $member->refresh();
        }

        // Load template image
        $templatePath = storage_path('app/public/' . $template->template_image);
        
        if (!file_exists($templatePath)) {
            throw new \Exception('Template image not found.');
        }

        // Create image manager
        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        // Get dimensions (template should be around 850x535 like ISET card)
        $cardWidth = $img->width();
        $cardHeight = $img->height();

        // === PREPARE DATA UNTUK HITUNG TINGGI TOTAL ===
        $lineSpacing = 32;  // Spacing konsisten
        
        // Hitung jumlah baris alamat untuk menentukan tinggi total data
        $address = $member->address ?: '-';
        $addressLines = $this->wrapText($address, 50, 3); // Max 50 karakter per baris, 3 baris (diperpanjang dari 35)
        $addressLinesCount = count($addressLines);
        
        // Hitung total tinggi data
        // 6 field: No.Anggota, Nama, Institusi, Kontak, Alamat (multi-line), Berlaku
        $totalDataLines = 5 + $addressLinesCount; // 5 field single line + alamat multi-line
        $totalDataHeight = $totalDataLines * $lineSpacing;
        
        // === TEXT SECTION ===
        $centerX = $cardWidth / 2;
        $dataStartX = 380;  // Data di kanan foto
        $dataStartY = 310;  // Start position untuk data
        
        // === PHOTO SECTION (Left side) - DYNAMIC CENTER ===
        $photoX = 140;
        $photoWidth = 200;
        $photoHeight = 240;
        
        // Hitung posisi Y foto agar center dengan data
        // Center foto di tengah-tengah area data
        $dataEndY = $dataStartY + $totalDataHeight;
        $dataCenterY = $dataStartY + ($totalDataHeight / 2);
        $photoY = $dataCenterY - ($photoHeight / 2);
        
        // Pastikan foto tidak terlalu atas atau bawah (min/max boundaries)
        $minPhotoY = 220;
        $maxPhotoY = 280;
        $photoY = max($minPhotoY, min($maxPhotoY, $photoY));

        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            $photoPath = storage_path('app/public/' . $member->photo);
            $photo = $manager->read($photoPath);
            
            // Resize and crop photo to fit
            $photo->cover($photoWidth, $photoHeight);
            
            // Place photo on card
            $img->place($photo, 'top-left', $photoX, $photoY);
        } else {
            // Draw placeholder for photo
            $img->drawRectangle($photoX, $photoY, function ($rectangle) use ($photoWidth, $photoHeight) {
                $rectangle->size($photoWidth, $photoHeight);
                $rectangle->background('#e8e8e8');
            });
            
            // Add "NO PHOTO" text
            $img->text('NO PHOTO', $photoX + ($photoWidth / 2), $photoY + ($photoHeight / 2) - 10, function($font) {
                $font->size(16);
                $font->color('#999999');
                $font->align('center');
                $font->valign('middle');
            });
        }
        
        // === HEADER: "KARTU TANDA ANGGOTA" (BESAR DI TENGAH) ===
        $headerY = 265;  // Turun dari 250 ke 265 (lebih bawah, tidak mepet)
        
        // Font path untuk bold
        $fontPathBold = storage_path('fonts/arialbd.ttf');
        
        if (file_exists($fontPathBold)) {
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, function($font) use ($fontPathBold) {
                $font->file($fontPathBold);
                $font->size(25);  // Font 25px
                $font->color('#000000');
                $font->align('center');
            });
        } else {
            // Fallback tanpa font file
            $img->text('KARTU TANDA ANGGOTA', $centerX, $headerY, function($font) {
                $font->size(25);
                $font->color('#000000');
                $font->align('center');
            });
        }
        
        // === DATA MEMBER (Kanan foto) ===
        $currentY = $dataStartY;

        // No. Anggota
        $this->addLabelValueClean($img, 'No.Anggota', $member->member_number ?? 'N/A', $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Nama
        $name = $this->truncateText($member->user->name ?? 'N/A', 28);
        $this->addLabelValueClean($img, 'Nama', $name, $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Institusi (diperpanjang dari 28 ke 45 karakter untuk nama institusi yang lebih panjang)
        $institution = $this->truncateText($member->institution_name ?: '-', 45);
        $this->addLabelValueClean($img, 'Institusi', $institution, $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Kontak
        $this->addLabelValueClean($img, 'Kontak', $member->phone ?: '-', $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Alamat (multi-line, max 3 baris) - addressLines sudah dihitung di atas
        $this->addLabelValueMultiline($img, 'Alamat', $addressLines, $dataStartX, $currentY);
        $currentY += $lineSpacing * $addressLinesCount; // Sesuaikan spacing dengan jumlah baris

        // Berlaku
        // Selalu tampilkan "Seumur Hidup" untuk masa berlaku
        $validityText = "Seumur Hidup";
        $this->addLabelValueClean($img, 'Berlaku', $validityText, $dataStartX, $currentY);
        
        // === DISAHKAN (Kanan bawah, dekat tanda tangan) ===
        // Menggunakan fungsi yang sama untuk konsistensi font
        $disahkanX = $cardWidth - 280;  // Geser ke kiri dari 220 ke 280
        $disahkanY = $cardHeight - 150; // Naik dari 130 ke 150
        
        $approvalDate = $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('d M Y') : date('d M Y');
        
        // Gunakan addLabelValueClean untuk konsistensi
        $this->addLabelValueClean($img, 'Disahkan', $approvalDate, $disahkanX, $disahkanY);

        // === QR CODE - DIHAPUS ===
        // Tidak perlu QR code untuk sekarang
        
        // === FOOTER TEXT - DIHAPUS ===
        // Footer bullets dihapus karena menumpuk dengan footer template

        // Save generated card
        $filename = 'member_card_' . $member->id . '_' . time() . '.png';
        $savePath = 'member-cards/' . $filename;
        $fullPath = storage_path('app/public/' . $savePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save image
        $img->toPng()->save($fullPath);

        // Delete old card if exists
        if ($member->member_card && Storage::disk('public')->exists($member->member_card)) {
            Storage::disk('public')->delete($member->member_card);
        }

        // Update member record
        $member->update([
            'member_card' => $savePath,
            'card_generated_at' => now(),
        ]);

        return $savePath;
    }

    /**
     * Truncate long text
     */
    private function truncateText($text, $length)
    {
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }

    /**
     * Wrap text into multiple lines with support for manual line breaks
     */
    private function wrapText($text, $maxCharsPerLine, $maxLines = 3)
    {
        // Check if text contains manual line breaks (enter)
        $hasLineBreaks = (strpos($text, "\n") !== false || strpos($text, "\r\n") !== false);
        
        if ($hasLineBreaks) {
            // User sudah membuat line break manual, gunakan itu
            // Normalize line breaks
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\r", "\n", $text);
            
            // Split by line breaks
            $manualLines = explode("\n", $text);
            $lines = [];
            
            foreach ($manualLines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                // Jika baris masih terlalu panjang, wrap otomatis
                if (strlen($line) > $maxCharsPerLine) {
                    $wrappedLines = $this->wrapLongLine($line, $maxCharsPerLine);
                    foreach ($wrappedLines as $wrappedLine) {
                        if (count($lines) < $maxLines) {
                            $lines[] = $wrappedLine;
                        }
                    }
                } else {
                    if (count($lines) < $maxLines) {
                        $lines[] = $line;
                    }
                }
                
                // Stop if we reached max lines
                if (count($lines) >= $maxLines) {
                    break;
                }
            }
            
            // Add ... if there are more lines
            if (count($manualLines) > count($lines)) {
                $lastIndex = count($lines) - 1;
                if ($lastIndex >= 0) {
                    $lines[$lastIndex] = rtrim($lines[$lastIndex], '.') . '...';
                }
            }
            
            return $lines;
        }
        
        // Tidak ada line break manual, gunakan word wrap otomatis
        return $this->wrapLongLine($text, $maxCharsPerLine, $maxLines);
    }
    
    /**
     * Wrap a long line into multiple lines by word boundaries
     */
    private function wrapLongLine($text, $maxCharsPerLine, $maxLines = 3)
    {
        // Split text by spaces
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';
        
        foreach ($words as $word) {
            // Check if adding this word exceeds max chars
            $testLine = $currentLine . ($currentLine ? ' ' : '') . $word;
            
            if (strlen($testLine) <= $maxCharsPerLine) {
                $currentLine = $testLine;
            } else {
                // Save current line and start new line
                if ($currentLine) {
                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    // Word itself is too long, truncate it
                    $lines[] = substr($word, 0, $maxCharsPerLine - 3) . '...';
                    $currentLine = '';
                }
                
                // Stop if we reached max lines
                if (count($lines) >= $maxLines) {
                    break;
                }
            }
        }
        
        // Add remaining text
        if ($currentLine && count($lines) < $maxLines) {
            $lines[] = $currentLine;
        }
        
        // If we have more text but reached max lines, add ... to last line
        if (count($words) > 0 && count($lines) >= $maxLines) {
            $lastLine = $lines[$maxLines - 1];
            if (strlen($lastLine) > $maxCharsPerLine - 3) {
                $lines[$maxLines - 1] = substr($lastLine, 0, $maxCharsPerLine - 3) . '...';
            } else {
                $lines[$maxLines - 1] = $lastLine . '...';
            }
        }
        
        return $lines;
    }

    /**
     * Add label with multiline value
     */
    private function addLabelValueMultiline($img, $label, $lines, $x, $y)
    {
        $labelWidth = 95;
        $fontSize = 15;
        $labelColor = '#000000';
        $valueColor = '#000000';
        $lineHeight = 22; // Tinggi per baris
        
        // Check if Arial fonts exist
        $fontPath = storage_path('fonts/arialbd.ttf'); // Arial Bold
        $fontPathRegular = storage_path('fonts/arial.ttf'); // Arial Regular
        
        // If custom font exists, use it
        if (file_exists($fontPath)) {
            // Draw label with Arial Bold (only on first line)
            $img->text($label, $x, $y, function($font) use ($fontSize, $labelColor, $fontPath) {
                $font->file($fontPath);
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw colon
            $img->text(':', $x + $labelWidth, $y, function($font) use ($fontSize, $labelColor, $fontPath) {
                $font->file($fontPath);
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw each line of value
            $currentY = $y;
            foreach ($lines as $line) {
                $img->text($line, $x + $labelWidth + 15, $currentY, function($font) use ($fontSize, $valueColor, $fontPathRegular, $fontPath) {
                    $font->file(file_exists($fontPathRegular) ? $fontPathRegular : $fontPath);
                    $font->size($fontSize);
                    $font->color($valueColor);
                    $font->align('left');
                });
                $currentY += $lineHeight;
            }
        } else {
            // Fallback: use default font
            // Draw label
            $img->text($label, $x, $y, function($font) use ($fontSize, $labelColor) {
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw colon
            $img->text(':', $x + $labelWidth, $y, function($font) use ($fontSize, $labelColor) {
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw each line of value
            $currentY = $y;
            foreach ($lines as $line) {
                $img->text($line, $x + $labelWidth + 15, $currentY, function($font) use ($fontSize, $valueColor) {
                    $font->size($fontSize);
                    $font->color($valueColor);
                    $font->align('left');
                });
                $currentY += $lineHeight;
            }
        }
    }

    /**
     * Add label: value pair with clean, professional font
     */
    private function addLabelValueClean($img, $label, $value, $x, $y)
    {
        $labelWidth = 95;
        $fontSize = 15;
        $labelColor = '#000000';
        $valueColor = '#000000';
        
        // Check if Arial Bold font exists
        $fontPath = storage_path('fonts/arialbd.ttf'); // Arial Bold
        $fontPathRegular = storage_path('fonts/arial.ttf'); // Arial Regular
        
        // If custom font exists, use it
        if (file_exists($fontPath)) {
            // Draw label with Arial Bold
            $img->text($label, $x, $y, function($font) use ($fontSize, $labelColor, $fontPath) {
                $font->file($fontPath);
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw colon
            $img->text(':', $x + $labelWidth, $y, function($font) use ($fontSize, $labelColor, $fontPath) {
                $font->file($fontPath);
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw value
            $img->text($value, $x + $labelWidth + 15, $y, function($font) use ($fontSize, $valueColor, $fontPathRegular, $fontPath) {
                // Use regular font for value if exists, else use bold
                $font->file(file_exists($fontPathRegular) ? $fontPathRegular : $fontPath);
                $font->size($fontSize);
                $font->color($valueColor);
                $font->align('left');
            });
        } else {
            // Fallback: use default GD font with slight bold effect (single overlay)
            // Draw label
            $img->text($label, $x, $y, function($font) use ($fontSize, $labelColor) {
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            $img->text($label, $x + 0.5, $y, function($font) use ($fontSize, $labelColor) {
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw colon
            $img->text(':', $x + $labelWidth, $y, function($font) use ($fontSize, $labelColor) {
                $font->size($fontSize);
                $font->color($labelColor);
                $font->align('left');
            });
            
            // Draw value (single draw, normal weight)
            $img->text($value, $x + $labelWidth + 15, $y, function($font) use ($fontSize, $valueColor) {
                $font->size($fontSize);
                $font->color($valueColor);
                $font->align('left');
            });
        }
    }

    /**
     * Generate QR Code
     */
    private function generateQRCode($text)
    {
        try {
            // Using simple QR code generation
            // You can install simplesoftwareio/simple-qrcode package for better QR codes
            // For now, return null if package not available
            
            if (class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode')) {
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(200)
                    ->generate($text);
                    
                $tempPath = storage_path('app/temp_qr_' . time() . '.png');
                file_put_contents($tempPath, $qrCode);
                
                return $tempPath;
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
