<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'content' => "VISI\nMenjadi wadah profesional yang kredibel dalam pengembangan dan pengelolaan jurnal ilmiah di bidang informatika dan komputer di Indonesia.\n\nMISI\n1. Meningkatkan kualitas pengelolaan jurnal ilmiah informatika dan komputer\n2. Memfasilitasi kolaborasi antar pengelola jurnal\n3. Memberikan pelatihan dan konsultasi pengelolaan jurnal\n4. Mendorong publikasi ilmiah berkualitas tinggi\n5. Membantu proses akreditasi jurnal",
                'excerpt' => 'Visi dan Misi APJIKOM dalam mengembangkan jurnal ilmiah berkualitas',
                'meta_title' => 'Visi & Misi APJIKOM',
                'meta_description' => 'Visi dan Misi Asosiasi Pengelola Jurnal Informatika dan Komputer Indonesia',
                'is_published' => true,
                'order' => 1,
            ],
            [
                'title' => 'Sejarah',
                'slug' => 'sejarah',
                'content' => "APJIKOM didirikan pada tahun 2020 oleh sekelompok pengelola jurnal ilmiah di bidang informatika dan komputer.\n\nBerawal dari keprihatinan akan rendahnya kualitas pengelolaan jurnal ilmiah di Indonesia, para pendiri berkumpul dan sepakat untuk membentuk sebuah wadah yang dapat membantu meningkatkan kualitas pengelolaan jurnal.\n\nSejak berdiri, APJIKOM telah membantu ratusan jurnal dalam proses akreditasi dan peningkatan kualitas.",
                'excerpt' => 'Sejarah berdirinya APJIKOM',
                'meta_title' => 'Sejarah APJIKOM',
                'meta_description' => 'Sejarah pendirian dan perkembangan APJIKOM',
                'is_published' => true,
                'order' => 2,
            ],
            [
                'title' => 'Tujuan',
                'slug' => 'tujuan',
                'content' => "TUJUAN APJIKOM:\n\n1. Meningkatkan kualitas jurnal ilmiah di bidang informatika dan komputer\n2. Memfasilitasi networking antar pengelola jurnal\n3. Memberikan pelatihan dan pendampingan\n4. Membantu proses akreditasi jurnal\n5. Mempromosikan publikasi ilmiah berkualitas\n6. Mengembangkan standar pengelolaan jurnal\n7. Mendorong inovasi dalam pengelolaan jurnal digital",
                'excerpt' => 'Tujuan APJIKOM dalam pengembangan jurnal ilmiah',
                'meta_title' => 'Tujuan APJIKOM',
                'is_published' => true,
                'order' => 3,
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' => "STRUKTUR ORGANISASI APJIKOM\n\nKetua Umum\nProf. Dr. [Nama]\n\nWakil Ketua\nDr. [Nama]\n\nSekretaris Jenderal\n[Nama], M.Kom\n\nBendahara\n[Nama], M.T\n\nDivisi:\n- Pendidikan dan Pelatihan\n- Akreditasi dan Standarisasi\n- Kerjasama dan Networking\n- Publikasi dan Dokumentasi",
                'excerpt' => 'Struktur organisasi dan kepengurusan APJIKOM',
                'meta_title' => 'Struktur Organisasi APJIKOM',
                'is_published' => true,
                'order' => 4,
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => "HUBUNGI KAMI\n\nSekretariat APJIKOM\nJl. [Alamat Lengkap]\n\nTelepon: [Nomor Telepon]\nEmail: info@apjikom.or.id\nWebsite: www.apjikom.or.id\n\nJam Operasional:\nSenin - Jumat: 09:00 - 17:00 WIB\nSabtu: 09:00 - 13:00 WIB\nMinggu & Libur: Tutup",
                'excerpt' => 'Informasi kontak dan alamat sekretariat APJIKOM',
                'meta_title' => 'Kontak APJIKOM',
                'is_published' => true,
                'order' => 5,
            ],
            [
                'title' => 'Konsultasi Jurnal',
                'slug' => 'konsultasi-jurnal',
                'content' => "LAYANAN KONSULTASI JURNAL\n\nAPJIKOM menyediakan layanan konsultasi untuk:\n\n1. Pendirian jurnal baru\n2. Pengelolaan jurnal\n3. Sistem OJS (Open Journal Systems)\n4. Peningkatan kualitas artikel\n5. Proses peer review\n6. Indexing dan akreditasi\n\nHubungi kami untuk jadwal konsultasi.",
                'excerpt' => 'Layanan konsultasi pengelolaan jurnal ilmiah',
                'meta_title' => 'Konsultasi Jurnal - APJIKOM',
                'is_published' => true,
                'order' => 6,
            ],
            [
                'title' => 'Akreditasi',
                'slug' => 'akreditasi',
                'content' => "LAYANAN AKREDITASI JURNAL\n\nAPJIKOM membantu jurnal dalam proses akreditasi:\n\n1. Persiapan dokumen akreditasi\n2. Review kelayakan jurnal\n3. Perbaikan sistem pengelolaan\n4. Pendampingan submission\n5. Monitoring dan evaluasi\n\nProses akreditasi memerlukan persiapan matang dan konsisten.",
                'excerpt' => 'Layanan pendampingan akreditasi jurnal',
                'meta_title' => 'Akreditasi Jurnal - APJIKOM',
                'is_published' => true,
                'order' => 7,
            ],
            [
                'title' => 'Pelatihan',
                'slug' => 'pelatihan',
                'content' => "PROGRAM PELATIHAN\n\nAPJIKOM menyelenggarakan berbagai pelatihan:\n\n1. Pengelolaan Jurnal dengan OJS\n2. Peer Review dan Editing\n3. Penulisan Artikel Ilmiah\n4. Manajemen Jurnal Digital\n5. Indexing Internasional\n6. Etika Publikasi\n\nPelatihan diadakan secara reguler dengan instruktur berpengalaman.",
                'excerpt' => 'Program pelatihan pengelolaan jurnal ilmiah',
                'meta_title' => 'Pelatihan - APJIKOM',
                'is_published' => true,
                'order' => 8,
            ],
            [
                'title' => 'Publikasi',
                'slug' => 'publikasi',
                'content' => "LAYANAN PUBLIKASI\n\nAPJIKOM membantu meningkatkan visibilitas publikasi:\n\n1. Registrasi ISSN\n2. DOI untuk artikel\n3. Submission ke indexing database\n4. Promosi jurnal\n5. Networking dengan jurnal internasional\n\nTingkatkan impact factor jurnal Anda bersama APJIKOM.",
                'excerpt' => 'Layanan publikasi dan promosi jurnal',
                'meta_title' => 'Publikasi - APJIKOM',
                'is_published' => true,
                'order' => 9,
            ],
            [
                'title' => 'Syarat & Ketentuan Keanggotaan',
                'slug' => 'syarat-ketentuan',
                'content' => "SYARAT KEANGGOTAAN\n\n1. Pengelola jurnal ilmiah aktif\n2. Jurnal terbit minimal 2 kali setahun\n3. Memiliki sistem pengelolaan yang jelas\n4. Mengikuti kode etik publikasi\n\nKETENTUAN:\n- Iuran anggota tahunan\n- Mengikuti kegiatan APJIKOM\n- Mematuhi AD/ART\n- Aktif dalam komunitas",
                'excerpt' => 'Syarat dan ketentuan menjadi anggota APJIKOM',
                'meta_title' => 'Syarat & Ketentuan - APJIKOM',
                'is_published' => true,
                'order' => 10,
            ],
            [
                'title' => 'Manfaat Keanggotaan',
                'slug' => 'manfaat-keanggotaan',
                'content' => "MANFAAT MENJADI ANGGOTA APJIKOM:\n\n1. Konsultasi gratis pengelolaan jurnal\n2. Diskon pelatihan dan workshop\n3. Networking dengan pengelola jurnal lain\n4. Akses ke resources dan tools\n5. Pendampingan akreditasi\n6. Promosi jurnal di platform APJIKOM\n7. Sertifikat keanggotaan\n8. Update informasi terkini\n\nBergabunglah dan tingkatkan kualitas jurnal Anda!",
                'excerpt' => 'Manfaat dan keuntungan menjadi anggota APJIKOM',
                'meta_title' => 'Manfaat Keanggotaan - APJIKOM',
                'is_published' => true,
                'order' => 11,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        $this->command->info('Page seeder completed successfully!');
    }
}
