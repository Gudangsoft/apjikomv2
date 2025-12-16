<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class FooterSettingsSeeder extends Seeder
{
    public function run()
    {
        $footerSettings = [
            // Menu Column 1
            'footer_menu1_title' => 'Menu',
            'footer_menu1_item1_label' => 'Beranda',
            'footer_menu1_item1_url' => '/',
            'footer_menu1_item2_label' => 'Berita',
            'footer_menu1_item2_url' => '/news',
            'footer_menu1_item3_label' => 'Kegiatan',
            'footer_menu1_item3_url' => '/events',
            'footer_menu1_item4_label' => 'Direktori Anggota',
            'footer_menu1_item4_url' => '/directory',
            'footer_menu1_item5_label' => 'Tentang Kami',
            'footer_menu1_item5_url' => '/about',
            
            // Menu Column 2
            'footer_menu2_title' => 'Layanan',
            'footer_menu2_item1_label' => 'Konsultasi Jurnal',
            'footer_menu2_item1_url' => '#',
            'footer_menu2_item2_label' => 'Akreditasi',
            'footer_menu2_item2_url' => '#',
            'footer_menu2_item3_label' => 'Pelatihan',
            'footer_menu2_item3_url' => '#',
            'footer_menu2_item4_label' => 'Publikasi',
            'footer_menu2_item4_url' => '/journals',
            'footer_menu2_item5_label' => '',
            'footer_menu2_item5_url' => '',
            
            // Copyright
            'footer_copyright_text' => '© ' . date('Y') . ' APJIKOM. All Rights Reserved.',
        ];

        foreach ($footerSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'footer']
            );
        }
    }
}
