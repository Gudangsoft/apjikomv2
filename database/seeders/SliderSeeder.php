<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Asosiasi Pengelola Jurnal Informatika dan Komputer',
                'description' => 'Meningkatkan kualitas publikasi ilmiah di bidang informatika dan komputer di Indonesia',
                'image' => 'sliders/default-1.jpg', // You need to add actual images
                'button_text' => 'Bergabung Sekarang',
                'button_link' => url('/daftar-anggota'),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Publikasi Jurnal Berkualitas',
                'description' => 'Mendukung peningkatan kualitas jurnal ilmiah Indonesia di tingkat internasional',
                'image' => 'sliders/default-2.jpg',
                'button_text' => 'Lihat Berita',
                'button_link' => route('news.index'),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Bergabung Bersama Kami',
                'description' => 'Jadilah bagian dari komunitas jurnal informatika dan komputer terbaik di Indonesia',
                'image' => 'sliders/default-3.jpg',
                'button_text' => 'Daftar Member',
                'button_link' => url('/daftar-anggota'),
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
