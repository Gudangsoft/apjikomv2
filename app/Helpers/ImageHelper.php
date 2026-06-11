<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHelper
{
    /**
     * Store an uploaded image with compression applied.
     * Falls back to plain store() if Intervention\Image fails.
     *
     * @param  UploadedFile  $file
     * @param  string  $folder      Storage folder under storage/app/public/
     * @param  int     $maxWidth    Max width in pixels (default 1200)
     * @param  int     $quality     JPEG quality 1-100 (default 75)
     * @return string  Relative path stored in DB (e.g. "news/image.jpg")
     */
    public static function store(UploadedFile $file, string $folder, int $maxWidth = 1200, int $quality = 75): string
    {
        $filename = Str::uuid() . '.jpg';
        $relativePath = $folder . '/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);

        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Only scale down, never up
            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            $image->toJpeg($quality)->save($fullPath);

            return $relativePath;
        } catch (\Throwable $e) {
            // Fallback: store original without optimization
            \Log::warning('ImageHelper fallback (optimization failed): ' . $e->getMessage());
            return $file->store($folder, 'public');
        }
    }
}
