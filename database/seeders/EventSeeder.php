<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate existing data
        Event::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $events = [
            [
                'category_id' => 1,
                'title' => 'Seminar Nasional Pengelolaan Jurnal 2025',
                'slug' => 'seminar-nasional-pengelolaan-jurnal-2025',
                'description' => '<p>Seminar nasional tentang best practices dalam pengelolaan jurnal ilmiah dengan pembicara dari berbagai universitas terkemuka.</p><p>Topik yang akan dibahas meliputi: sistem peer review yang efektif, strategi indeksasi internasional, dan penerapan etika publikasi ilmiah.</p>',
                'event_type' => 'offline',
                'location' => 'Hotel Grand Sahid Jakarta',
                'online_platform' => null,
                'event_date' => now()->addDays(30)->format('Y-m-d'),
                'event_time' => '08:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/semnasjo2025',
                'has_registration' => true,
                'has_certificate' => true,
                'participant_quota' => 200,
                'registration_fee' => 500000,
                'registration_requirements' => 'Fotocopy KTP, Bukti pembayaran, Surat tugas (jika ada)',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'title' => 'Workshop Akreditasi Jurnal',
                'slug' => 'workshop-akreditasi-jurnal',
                'description' => '<p>Workshop intensif tentang proses akreditasi jurnal nasional dan internasional.</p><p>Peserta akan mendapatkan panduan lengkap dari persiapan dokumen hingga strategi meningkatkan peringkat akreditasi.</p>',
                'event_type' => 'hybrid',
                'location' => 'Universitas Indonesia, Depok',
                'online_platform' => 'Zoom Meeting',
                'event_date' => now()->addDays(45)->format('Y-m-d'),
                'event_time' => '09:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/workshop-akreditasi',
                'has_registration' => true,
                'has_certificate' => true,
                'participant_quota' => 100,
                'registration_fee' => 350000,
                'registration_requirements' => 'CV pengelola jurnal, Profil jurnal yang akan diakreditasi',
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => 1,
                'title' => 'Rapat Koordinasi Nasional APJIKOM',
                'slug' => 'rakornas-apjikom',
                'description' => '<p>Rapat koordinasi nasional untuk membahas program kerja dan strategi pengembangan APJIKOM.</p><p>Acara ini khusus untuk pengurus dan anggota APJIKOM dari seluruh Indonesia.</p>',
                'event_type' => 'offline',
                'location' => 'Grand Inna Kuta Hotel, Bali',
                'online_platform' => null,
                'event_date' => now()->addDays(60)->format('Y-m-d'),
                'event_time' => '08:30:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/rakornas',
                'has_registration' => true,
                'has_certificate' => false,
                'participant_quota' => 150,
                'registration_fee' => 0,
                'registration_requirements' => 'Kartu anggota APJIKOM, Surat penugasan dari institusi',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'title' => 'Webinar: Etika Publikasi Ilmiah',
                'slug' => 'webinar-etika-publikasi-ilmiah',
                'description' => '<p>Webinar tentang etika publikasi ilmiah dan pencegahan plagiarisme.</p><p>Narasumber: Prof. Dr. Ahmad Budi (Pakar Etika Publikasi) dan Dr. Siti Nurhaliza (Editor Jurnal Internasional).</p>',
                'event_type' => 'online',
                'location' => null,
                'online_platform' => 'Zoom Webinar',
                'event_date' => now()->addDays(15)->format('Y-m-d'),
                'event_time' => '13:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/webinar-etika',
                'has_registration' => true,
                'has_certificate' => true,
                'participant_quota' => 500,
                'registration_fee' => 0,
                'registration_requirements' => 'Email aktif untuk menerima link zoom',
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => 2,
                'title' => 'Pelatihan Open Journal System (OJS)',
                'slug' => 'pelatihan-open-journal-system-ojs',
                'description' => '<p>Pelatihan intensif penggunaan Open Journal System (OJS) untuk pengelolaan jurnal elektronik.</p><p>Cocok untuk editor dan pengelola jurnal yang ingin mengoptimalkan penggunaan platform OJS.</p>',
                'event_type' => 'online',
                'location' => null,
                'online_platform' => 'Google Meet',
                'event_date' => now()->addDays(20)->format('Y-m-d'),
                'event_time' => '10:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/pelatihan-ojs',
                'has_registration' => true,
                'has_certificate' => true,
                'participant_quota' => 300,
                'registration_fee' => 150000,
                'registration_requirements' => 'Laptop/PC dengan koneksi internet stabil',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'title' => 'Konferensi Internasional Informatika 2025',
                'slug' => 'konferensi-internasional-informatika-2025',
                'description' => '<p>International Conference on Informatics and Computer Science (ICICS 2025) yang diselenggarakan oleh APJIKOM.</p><p>Menghadirkan keynote speaker dari berbagai negara dan kesempatan publikasi di jurnal terindeks Scopus.</p>',
                'event_type' => 'hybrid',
                'location' => 'Shangri-La Hotel, Surabaya',
                'online_platform' => 'Zoom + YouTube Live',
                'event_date' => now()->addDays(90)->format('Y-m-d'),
                'event_time' => '08:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/icics2025',
                'has_registration' => true,
                'has_certificate' => true,
                'participant_quota' => 400,
                'registration_fee' => 1500000,
                'registration_requirements' => 'Abstract/full paper, Proof of payment, Passport copy (for international participants)',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'title' => 'Diskusi Panel: Masa Depan Jurnal Open Access',
                'slug' => 'diskusi-panel-masa-depan-jurnal-open-access',
                'description' => '<p>Diskusi panel membahas trend dan tantangan jurnal open access di Indonesia.</p><p>Panel terdiri dari pengelola jurnal, peneliti senior, dan stakeholder publikasi ilmiah.</p>',
                'event_type' => 'offline',
                'location' => 'Gedung APJIKOM, Jakarta',
                'online_platform' => null,
                'event_date' => now()->addDays(35)->format('Y-m-d'),
                'event_time' => '14:00:00',
                'registration_link' => null,
                'has_registration' => false,
                'has_certificate' => false,
                'participant_quota' => null,
                'registration_fee' => null,
                'registration_requirements' => null,
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => 1,
                'title' => 'Sosialisasi Program Kemitraan APJIKOM',
                'slug' => 'sosialisasi-program-kemitraan-apjikom',
                'description' => '<p>Sosialisasi berbagai program kemitraan dan kolaborasi yang ditawarkan APJIKOM kepada institusi pendidikan dan jurnal ilmiah.</p>',
                'event_type' => 'online',
                'location' => null,
                'online_platform' => 'Microsoft Teams',
                'event_date' => now()->addDays(25)->format('Y-m-d'),
                'event_time' => '15:00:00',
                'registration_link' => 'https://apjikom.or.id/daftar-anggota/sosialisasi-kemitraan',
                'has_registration' => true,
                'has_certificate' => false,
                'participant_quota' => 200,
                'registration_fee' => 0,
                'registration_requirements' => null,
                'is_published' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
