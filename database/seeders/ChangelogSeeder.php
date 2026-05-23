<?php

namespace Database\Seeders;

use App\Models\Changelog;
use Illuminate\Database\Seeder;

class ChangelogSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'version'      => '1.5.0',
                'release_date' => '2026-05-23',
                'type'         => 'feature',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Panduan Admin (Tutorial)\n- Tambah halaman Panduan Admin di menu sidebar\n- Berisi panduan lengkap penggunaan semua fitur: Dashboard, Konten, Keanggotaan, Tampilan, Media Sosial, Manajemen User, Pengaturan, dan Changelog\n- Setiap panduan dapat di-expand/collapse\n\nMenu Navigasi Admin\n- Tambah link Panduan Admin di sidebar\n- Tambah link Changelog & Updates di sidebar",
            ],
            [
                'version'      => '1.4.0',
                'release_date' => '2026-05-23',
                'type'         => 'feature',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Media Sosial\n- Redesign form tambah/edit media sosial dengan tile picker visual\n- Mendukung 8 platform bawaan: Facebook, Instagram, Twitter/X, YouTube, LinkedIn, TikTok, WhatsApp, Telegram\n- Preview real-time tampilan footer\n- Mendukung platform custom dengan upload icon (SVG/PNG) dan pilihan warna\n- Hapus duplikasi field media sosial di halaman Pengaturan Umum\n- Footer website sekarang otomatis mengambil data dari menu Media Sosial",
            ],
            [
                'version'      => '1.3.0',
                'release_date' => '2026-05-23',
                'type'         => 'feature',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Responsif Mobile\n- Navbar: tombol dark mode dan hamburger tersedia di mobile\n- Slider beranda: tinggi dinamis (60vw) dengan min/max untuk semua ukuran layar\n- Halaman Beranda: ukuran teks hero responsif, tombol CTA full-width di mobile\n- Halaman Tentang: padding dan teks responsif\n- Halaman Berita: grid dan header responsif\n- Halaman Detail Berita: gambar dan sidebar responsif\n- Halaman Kegiatan: card dan heading responsif\n- Halaman Detail Kegiatan: harga dan related events responsif\n- Footer: grid 2 kolom di mobile, 4 kolom di desktop",
            ],
            [
                'version'      => '1.2.0',
                'release_date' => '2026-05-22',
                'type'         => 'feature',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Pengaturan Tampilan Nama Website\n- Tambah checkbox \"Tampilkan nama di samping logo (navigasi)\" di Pengaturan Umum\n- Tambah checkbox \"Tampilkan nama di footer\" di Pengaturan Umum\n- Perubahan tersimpan di database dan langsung berlaku di seluruh website",
            ],
            [
                'version'      => '1.1.0',
                'release_date' => '2026-05-22',
                'type'         => 'update',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Slider / Banner\n- Ubah dimensi rekomendasi slider dari 1920×600 menjadi 1920×800 px\n- Ubah rasio dari 16:5 menjadi 12:5 untuk tampilan lebih proporsional\n- Tambah tips agar konten utama diletakkan di tengah gambar\n\nChangelog\n- Perbaiki halaman Changelog yang error 500 akibat tabel update_requests belum ada di server\n- Tambah fallback aman jika tabel belum dibuat",
            ],
            [
                'version'      => '1.0.0',
                'release_date' => '2025-12-16',
                'type'         => 'feature',
                'updated_by'   => 'Developer',
                'is_published' => true,
                'changes'      => "Rilis Pertama Sistem APJIKOM\n- Dashboard admin dengan statistik real-time\n- Manajemen Berita (CRUD, kategori, publikasi)\n- Manajemen Kegiatan / Event (pendaftaran, kapasitas, harga)\n- Manajemen Anggota & Keanggotaan (approval, kartu anggota, sertifikat)\n- Manajemen Slider / Banner beranda\n- Manajemen Menu Navigasi dinamis\n- Manajemen Halaman Statis\n- Manajemen Galeri foto\n- Manajemen FAQ & Testimoni\n- Manajemen Media Sosial\n- Manajemen User & Role (Admin, Editor, Member)\n- Pengaturan Umum (nama, logo, kontak, SEO)\n- Pengaturan Email & Notifikasi SMTP\n- Tampilan publik responsif dengan dark mode\n- Sistem autentikasi & registrasi member",
            ],
        ];

        foreach ($entries as $entry) {
            Changelog::updateOrCreate(
                ['version' => $entry['version'], 'release_date' => $entry['release_date']],
                $entry
            );
        }
    }
}
