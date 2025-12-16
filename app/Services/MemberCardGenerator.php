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

        // === PHOTO SECTION (Left side) ===
        // Photo position and size - CENTER VERTICAL
        $photoX = 140;
        $photoY = 240;  // Dinaikkan dari 280 ke 240 agar lebih center
        $photoWidth = 200;
        $photoHeight = 240;

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

        // === TEXT SECTION ===
        // Posisi lebih rapi sesuai screenshot
        $centerX = $cardWidth / 2;
        $dataStartX = 380;  // Data di kanan foto
        $dataStartY = 310;  // Mulai lebih bawah
        $lineSpacing = 32;  // Spacing konsisten
        
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

        // Institusi
        $institution = $this->truncateText($member->institution_name ?: '-', 28);
        $this->addLabelValueClean($img, 'Institusi', $institution, $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Kontak
        $this->addLabelValueClean($img, 'Kontak', $member->phone ?: '-', $dataStartX, $currentY);
        $currentY += $lineSpacing;

        // Alamat (panjang max diperbesar dari 30 ke 50 karakter)
        $address = $this->truncateText($member->address ?: '-', 50);
        $this->addLabelValueClean($img, 'Alamat', $address, $dataStartX, $currentY);
        $currentY += $lineSpacing;

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
