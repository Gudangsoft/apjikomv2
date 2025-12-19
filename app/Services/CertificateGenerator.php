<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\CertificateTemplate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CertificateGenerator
{
    /**
     * Generate certificate for event participant
     */
    public function generate(EventRegistration $registration)
    {
        // Get active template
        $template = CertificateTemplate::getActive();
        
        if (!$template) {
            throw new \Exception('No active certificate template found. Please upload a template first.');
        }

        // Load event details
        $event = $registration->event;
        $participant = $registration->user;

        // Load template image
        $templatePath = storage_path('app/public/' . $template->template_image);
        
        if (!file_exists($templatePath)) {
            throw new \Exception('Template image not found.');
        }

        // Create image manager
        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        // Get dimensions (template should be around 1064x662 like the screenshot)
        $cardWidth = $img->width();
        $cardHeight = $img->height();

        // === POSITIONS BASED ON THE CERTIFICATE TEMPLATE ===
        $centerX = $cardWidth / 2;
        
        // Participant name position (center, below "diberikan kepada :")
        $participantNameY = 390; // Adjust based on template
        
        // Event name position (center, below "Sebagai Peserta Dalam")
        $eventNameY = 495; // Adjust based on template

        // Font paths
        $fontPathBold = storage_path('fonts/arialbd.ttf');
        $fontPathRegular = storage_path('fonts/arial.ttf');

        // === NAMA PESERTA (Center, Red Color) ===
        $participantName = strtoupper($participant->name ?? 'N/A');
        
        if (file_exists($fontPathBold)) {
            $img->text($participantName, $centerX, $participantNameY, function($font) use ($fontPathBold) {
                $font->file($fontPathBold);
                $font->size(32);
                $font->color('#FF0000'); // Red color
                $font->align('center');
            });
        } else {
            $img->text($participantName, $centerX, $participantNameY, function($font) {
                $font->size(32);
                $font->color('#FF0000');
                $font->align('center');
            });
        }

        // === NAMA KEGIATAN / EVENT (Center, Red Color) ===
        $eventName = strtoupper($event->title ?? 'N/A');
        
        // Wrap event name if too long (max 60 characters per line, max 2 lines)
        $eventNameLines = $this->wrapText($eventName, 60, 2);
        
        $currentY = $eventNameY;
        $lineHeight = 38;
        
        foreach ($eventNameLines as $line) {
            if (file_exists($fontPathBold)) {
                $img->text($line, $centerX, $currentY, function($font) use ($fontPathBold) {
                    $font->file($fontPathBold);
                    $font->size(28);
                    $font->color('#FF0000'); // Red color
                    $font->align('center');
                });
            } else {
                $img->text($line, $centerX, $currentY, function($font) {
                    $font->size(28);
                    $font->color('#FF0000');
                    $font->align('center');
                });
            }
            $currentY += $lineHeight;
        }

        // Save generated certificate
        $filename = 'certificate_' . $registration->id . '_' . time() . '.png';
        $savePath = 'certificates/' . $filename;
        $fullPath = storage_path('app/public/' . $savePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save image
        $img->toPng()->save($fullPath);

        // Delete old certificate if exists
        if ($registration->certificate_path && Storage::disk('public')->exists($registration->certificate_path)) {
            Storage::disk('public')->delete($registration->certificate_path);
        }

        // Update registration record
        $registration->update([
            'certificate_path' => $savePath,
            'certificate_generated_at' => now(),
        ]);

        return $savePath;
    }

    /**
     * Wrap text into multiple lines
     */
    private function wrapText($text, $maxCharsPerLine, $maxLines = 2)
    {
        // Check if text contains manual line breaks
        $hasLineBreaks = (strpos($text, "\n") !== false || strpos($text, "\r\n") !== false);
        
        if ($hasLineBreaks) {
            // User has manual line breaks, use them
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\r", "\n", $text);
            
            $manualLines = explode("\n", $text);
            $lines = [];
            
            foreach ($manualLines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
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
                
                if (count($lines) >= $maxLines) {
                    break;
                }
            }
            
            return $lines;
        }
        
        // No manual breaks, use word wrap
        return $this->wrapLongLine($text, $maxCharsPerLine, $maxLines);
    }
    
    /**
     * Wrap a long line into multiple lines by word boundaries
     */
    private function wrapLongLine($text, $maxCharsPerLine, $maxLines = 2)
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
                
                if (count($lines) >= $maxLines) {
                    break;
                }
            }
        }
        
        if ($currentLine && count($lines) < $maxLines) {
            $lines[] = $currentLine;
        }
        
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
}
