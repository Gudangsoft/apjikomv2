<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Get pages for linking
        $visiMisiPage = \App\Models\Page::where('slug', 'visi-misi')->first();
        $sejarahPage = \App\Models\Page::where('slug', 'sejarah')->first();
        $tujuanPage = \App\Models\Page::where('slug', 'tujuan')->first();
        $strukturPage = \App\Models\Page::where('slug', 'struktur-organisasi')->first();
        $kontakPage = \App\Models\Page::where('slug', 'kontak')->first();
        $konsultasiPage = \App\Models\Page::where('slug', 'konsultasi-jurnal')->first();
        $akreditasiPage = \App\Models\Page::where('slug', 'akreditasi')->first();
        $pelatihanPage = \App\Models\Page::where('slug', 'pelatihan')->first();
        $publikasiPage = \App\Models\Page::where('slug', 'publikasi')->first();
        $syaratPage = \App\Models\Page::where('slug', 'syarat-ketentuan')->first();
        $manfaatPage = \App\Models\Page::where('slug', 'manfaat-keanggotaan')->first();

        // Level 1: Tentang Menu (Dropdown)
        $tentangMenu = Menu::create([
            'title' => 'Tentang',
            'url' => null,
            'type' => 'dropdown',
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        // Level 2: Sub-menus under Tentang
        $profilMenu = Menu::create([
            'title' => 'Profil',
            'url' => null,
            'type' => 'dropdown',
            'parent_id' => $tentangMenu->id,
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Struktur Organisasi',
            'page_id' => $strukturPage?->id,
            'type' => 'page',
            'parent_id' => $tentangMenu->id,
            'target' => '_self',
            'order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Kontak',
            'page_id' => $kontakPage?->id,
            'type' => 'page',
            'parent_id' => $tentangMenu->id,
            'target' => '_self',
            'order' => 3,
            'is_active' => true,
        ]);

        // Level 3: Sub-menus under Profil
        Menu::create([
            'title' => 'Visi & Misi',
            'page_id' => $visiMisiPage?->id,
            'type' => 'page',
            'parent_id' => $profilMenu->id,
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Sejarah',
            'page_id' => $sejarahPage?->id,
            'type' => 'page',
            'parent_id' => $profilMenu->id,
            'target' => '_self',
            'order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Tujuan',
            'page_id' => $tujuanPage?->id,
            'type' => 'page',
            'parent_id' => $profilMenu->id,
            'target' => '_self',
            'order' => 3,
            'is_active' => true,
        ]);

        // Level 1: Layanan Menu (Dropdown)
        $layananMenu = Menu::create([
            'title' => 'Layanan',
            'url' => null,
            'type' => 'dropdown',
            'target' => '_self',
            'order' => 2,
            'is_active' => true,
        ]);

        // Level 2: Sub-menus under Layanan
        Menu::create([
            'title' => 'Konsultasi Jurnal',
            'page_id' => $konsultasiPage?->id,
            'type' => 'page',
            'parent_id' => $layananMenu->id,
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Akreditasi',
            'page_id' => $akreditasiPage?->id,
            'type' => 'page',
            'parent_id' => $layananMenu->id,
            'target' => '_self',
            'order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Pelatihan',
            'page_id' => $pelatihanPage?->id,
            'type' => 'page',
            'parent_id' => $layananMenu->id,
            'target' => '_self',
            'order' => 3,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Publikasi',
            'page_id' => $publikasiPage?->id,
            'type' => 'page',
            'parent_id' => $layananMenu->id,
            'target' => '_self',
            'order' => 4,
            'is_active' => true,
        ]);

        // Level 1: Keanggotaan Menu (Dropdown)
        $keanggotaanMenu = Menu::create([
            'title' => 'Keanggotaan',
            'url' => null,
            'type' => 'dropdown',
            'target' => '_self',
            'order' => 3,
            'is_active' => true,
        ]);

        // Level 2: Sub-menus under Keanggotaan
        Menu::create([
            'title' => 'Syarat & Ketentuan',
            'page_id' => $syaratPage?->id,
            'type' => 'page',
            'parent_id' => $keanggotaanMenu->id,
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Daftar Anggota',
            'url' => '/daftar-anggota',
            'type' => 'link',
            'parent_id' => $keanggotaanMenu->id,
            'target' => '_self',
            'order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Manfaat Keanggotaan',
            'page_id' => $manfaatPage?->id,
            'type' => 'page',
            'parent_id' => $keanggotaanMenu->id,
            'target' => '_self',
            'order' => 3,
            'is_active' => true,
        ]);

        $this->command->info('Menu seeder completed successfully!');
    }
}
