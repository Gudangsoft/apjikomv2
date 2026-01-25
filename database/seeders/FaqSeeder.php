<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // General
            [
                'question' => 'Apa itu APJIKOM?',
                'answer' => 'APJIKOM (Asosiasi Pengelola Jurnal Informatika dan Komputer) adalah organisasi yang menghimpun pengelola jurnal ilmiah di bidang informatika, komputer, dan teknologi informasi di Indonesia.',
                'category' => 'general',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Kapan APJIKOM didirikan?',
                'answer' => 'APJIKOM didirikan untuk menjadi wadah koordinasi dan pengembangan pendidikan komunikasi di Indonesia, dengan fokus pada peningkatan kualitas pendidikan dan penelitian di bidang komunikasi.',
                'category' => 'general',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apa visi dan misi APJIKOM?',
                'answer' => 'Visi APJIKOM adalah menjadi organisasi terdepan dalam pengembangan pendidikan komunikasi di Indonesia. Misi kami meliputi peningkatan kualitas pendidikan, penelitian, dan pengabdian masyarakat di bidang komunikasi.',
                'category' => 'general',
                'order' => 3,
                'is_active' => true,
            ],

            // Membership
            [
                'question' => 'Siapa yang bisa menjadi anggota APJIKOM?',
                'answer' => 'Anggota APJIKOM adalah institusi pendidikan tinggi yang menyelenggarakan program studi Ilmu Komunikasi, Jurnalistik, atau bidang sejenis yang telah terakreditasi.',
                'category' => 'membership',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara mendaftar menjadi anggota?',
                'answer' => 'Untuk mendaftar sebagai anggota APJIKOM, silakan klik menu "Daftar" di website, lengkapi formulir pendaftaran, dan upload dokumen yang diperlukan. Tim kami akan memverifikasi dan menghubungi Anda untuk proses selanjutnya.',
                'category' => 'membership',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apa saja persyaratan untuk menjadi anggota?',
                'answer' => 'Persyaratan menjadi anggota meliputi: (1) Institusi pendidikan tinggi terakreditasi, (2) Menyelenggarakan program studi komunikasi/jurnalistik, (3) Mengisi formulir pendaftaran lengkap, (4) Membayar iuran keanggotaan sesuai ketentuan.',
                'category' => 'membership',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Apa manfaat menjadi anggota APJIKOM?',
                'answer' => 'Manfaat keanggotaan meliputi: akses ke jaringan institusi pendidikan komunikasi nasional, kesempatan berpartisipasi dalam konferensi dan seminar, peluang kolaborasi penelitian, informasi terkini tentang perkembangan pendidikan komunikasi, dan sertifikasi program.',
                'category' => 'membership',
                'order' => 4,
                'is_active' => true,
            ],

            // Payment
            [
                'question' => 'Berapa biaya keanggotaan APJIKOM?',
                'answer' => 'Biaya keanggotaan APJIKOM bervariasi tergantung jenis institusi. Untuk informasi detail mengenai biaya, silakan hubungi sekretariat APJIKOM atau lihat di halaman Keanggotaan.',
                'category' => 'payment',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara melakukan pembayaran?',
                'answer' => 'Pembayaran dapat dilakukan melalui transfer bank ke rekening APJIKOM. Detail rekening akan diberikan setelah pendaftaran disetujui. Bukti transfer mohon dikirimkan melalui email atau upload di sistem.',
                'category' => 'payment',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada iuran tahunan?',
                'answer' => 'Ya, anggota APJIKOM dikenakan iuran tahunan untuk mendukung kegiatan operasional organisasi. Besaran iuran akan dikomunikasikan kepada anggota setiap tahunnya.',
                'category' => 'payment',
                'order' => 3,
                'is_active' => true,
            ],

            // Event
            [
                'question' => 'Apa saja kegiatan yang diselenggarakan APJIKOM?',
                'answer' => 'APJIKOM menyelenggarakan berbagai kegiatan seperti konferensi nasional, seminar, workshop, pelatihan dosen, program sertifikasi, dan kegiatan ilmiah lainnya yang mendukung pengembangan pendidikan komunikasi.',
                'category' => 'event',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara mendaftar event APJIKOM?',
                'answer' => 'Informasi dan pendaftaran event dapat diakses melalui menu "Event" di website. Setiap event memiliki formulir pendaftaran online dan petunjuk teknis yang lengkap.',
                'category' => 'event',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah non-anggota bisa mengikuti event APJIKOM?',
                'answer' => 'Beberapa event APJIKOM terbuka untuk umum, namun anggota mendapatkan prioritas dan tarif khusus. Silakan cek detail setiap event untuk informasi lebih lanjut.',
                'category' => 'event',
                'order' => 3,
                'is_active' => true,
            ],

            // Technical
            [
                'question' => 'Bagaimana cara mengakses sistem member APJIKOM?',
                'answer' => 'Setelah pendaftaran disetujui, Anda akan menerima email berisi username dan password untuk mengakses dashboard member. Login melalui menu "Login" di website.',
                'category' => 'technical',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Lupa password, bagaimana cara reset?',
                'answer' => 'Klik "Lupa Password" di halaman login, masukkan email yang terdaftar, dan ikuti petunjuk reset password yang dikirimkan ke email Anda.',
                'category' => 'technical',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara update data profil institusi?',
                'answer' => 'Login ke dashboard member, pilih menu "Profil", kemudian edit informasi yang ingin diubah. Jangan lupa klik "Simpan" untuk menyimpan perubahan.',
                'category' => 'technical',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
