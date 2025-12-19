<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialMedia = [
            [
                'name' => 'Facebook',
                'url' => 'https://facebook.com/apjikom',
                'icon_class' => 'fab fa-facebook',
                'note' => 'Halaman resmi Facebook APJIKOM',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/apjikom',
                'icon_class' => 'fab fa-instagram',
                'note' => 'Akun resmi Instagram APJIKOM',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/apjikom',
                'icon_class' => 'fab fa-twitter',
                'note' => 'Akun resmi Twitter APJIKOM',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://youtube.com/@apjikom',
                'icon_class' => 'fab fa-youtube',
                'note' => 'Channel YouTube APJIKOM',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://linkedin.com/company/apjikom',
                'icon_class' => 'fab fa-linkedin',
                'note' => 'LinkedIn Company Page APJIKOM',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'TikTok',
                'url' => 'https://tiktok.com/@apjikom',
                'icon_class' => 'fab fa-tiktok',
                'note' => 'Akun TikTok APJIKOM',
                'order' => 6,
                'is_active' => false,
            ],
        ];

        foreach ($socialMedia as $item) {
            SocialMedia::create($item);
        }
    }
}

