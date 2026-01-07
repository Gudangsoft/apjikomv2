<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class VideoGallerySeeder extends Seeder
{
    public function run()
    {
        $videos = [
            [
                'title' => 'Webinar Nasional APJIKOM 2024',
                'description' => 'Webinar nasional tentang perkembangan teknologi informasi dan komunikasi di Indonesia',
                'type' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'category' => 'event',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Tutorial Publikasi Jurnal Ilmiah',
                'description' => 'Panduan lengkap untuk mempublikasikan jurnal ilmiah berkualitas',
                'type' => 'video',
                'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
                'category' => 'activity',
                'order' => 2,
                'is_featured' => false,
            ],
            [
                'title' => 'Profil APJIKOM',
                'description' => 'Video profil Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia',
                'type' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'category' => 'other',
                'order' => 3,
                'is_featured' => true,
            ],
        ];

        foreach ($videos as $video) {
            $youtubeId = Gallery::extractYoutubeId($video['youtube_url']);
            if ($youtubeId) {
                Gallery::create([
                    'title' => $video['title'],
                    'description' => $video['description'],
                    'type' => $video['type'],
                    'youtube_url' => $video['youtube_url'],
                    'youtube_id' => $youtubeId,
                    'image' => "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg",
                    'category' => $video['category'],
                    'order' => $video['order'],
                    'is_featured' => $video['is_featured'],
                ]);
            }
        }
    }
}
