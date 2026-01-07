<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate existing data
        News::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $newsData = [
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'APJIKOM Resmi Diluncurkan',
                'slug' => 'apjikom-resmi-diluncurkan',
                'excerpt' => 'Asosiasi Pengelola Jurnal Informatika dan Komputer (APJIKOM) resmi diluncurkan untuk meningkatkan kualitas publikasi ilmiah.',
                'content' => '<p>Asosiasi Pengelola Jurnal Informatika dan Komputer (APJIKOM) resmi diluncurkan pada tanggal 12 November 2025. APJIKOM bertujuan untuk meningkatkan kualitas publikasi ilmiah di bidang informatika dan komputer di Indonesia.</p><p>Sebagai organisasi profesional, APJIKOM akan memberikan berbagai layanan kepada anggota, termasuk pelatihan pengelolaan jurnal, konsultasi akreditasi, dan fasilitasi kerjasama penelitian.</p><p>Ketua Umum APJIKOM, Prof. Dr. Ahmad Surya, menyatakan bahwa keberadaan asosiasi ini sangat penting untuk meningkatkan daya saing publikasi ilmiah Indonesia di tingkat internasional.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Workshop Pengelolaan Jurnal Ilmiah Sukses Diselenggarakan',
                'slug' => 'workshop-pengelolaan-jurnal-ilmiah',
                'excerpt' => 'APJIKOM menyelenggarakan workshop pengelolaan jurnal ilmiah untuk meningkatkan kompetensi pengelola jurnal.',
                'content' => '<p>APJIKOM mengadakan workshop pengelolaan jurnal ilmiah yang akan membahas berbagai topik penting seperti etika publikasi, peer review process, dan strategi indeksasi jurnal.</p><p>Workshop ini terbuka untuk semua pengelola jurnal dan editor yang ingin meningkatkan kualitas jurnal mereka. Peserta mendapatkan materi lengkap dan sertifikat keikutsertaan.</p><p>Sebanyak 150 peserta dari berbagai universitas di Indonesia mengikuti acara yang berlangsung selama 2 hari ini.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Kerjasama dengan IEEE Indonesia',
                'slug' => 'kerjasama-dengan-ieee-indonesia',
                'excerpt' => 'APJIKOM menjalin kerjasama strategis dengan IEEE Indonesia untuk pengembangan publikasi ilmiah.',
                'content' => '<p>APJIKOM menandatangani MoU dengan IEEE Indonesia untuk kerjasama dalam pengembangan publikasi ilmiah dan peningkatan kapasitas pengelola jurnal.</p><p>Kerjasama ini akan membuka peluang bagi jurnal-jurnal anggota APJIKOM untuk berkolaborasi dengan komunitas IEEE global.</p><p>Penandatanganan dilakukan oleh Ketua Umum APJIKOM dan Chairman IEEE Indonesia Section di Jakarta Convention Center.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Panduan Akreditasi Jurnal Nasional',
                'slug' => 'panduan-akreditasi-jurnal-nasional',
                'excerpt' => 'APJIKOM menerbitkan panduan lengkap untuk akreditasi jurnal nasional.',
                'content' => '<p>APJIKOM telah menerbitkan panduan lengkap untuk membantu pengelola jurnal dalam proses akreditasi jurnal nasional. Panduan ini mencakup persyaratan, prosedur, dan tips untuk meningkatkan kualitas jurnal.</p><p>Panduan dapat diunduh gratis oleh seluruh anggota APJIKOM melalui portal member.</p><p>Dokumen setebal 120 halaman ini disusun oleh tim ahli yang berpengalaman dalam proses akreditasi jurnal.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Pendaftaran Member APJIKOM Dibuka',
                'slug' => 'pendaftaran-member-apjikom-dibuka',
                'excerpt' => 'Pendaftaran keanggotaan APJIKOM untuk individu dan institusi resmi dibuka.',
                'content' => '<p>APJIKOM membuka pendaftaran keanggotaan untuk individu dan institusi. Member akan mendapatkan berbagai keuntungan termasuk akses ke resource, training, dan networking opportunities.</p><p>Daftarkan jurnal dan institusi Anda sekarang untuk menjadi bagian dari komunitas pengelola jurnal terbesar di Indonesia!</p><p>Biaya keanggotaan sangat terjangkau dengan berbagai paket yang dapat disesuaikan dengan kebutuhan.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Pelatihan Open Journal System (OJS) 3.3',
                'slug' => 'pelatihan-open-journal-system-ojs',
                'excerpt' => 'APJIKOM mengadakan pelatihan penggunaan OJS versi terbaru untuk pengelola jurnal.',
                'content' => '<p>Pelatihan intensif penggunaan Open Journal System (OJS) versi 3.3 akan diselenggarakan secara online pada bulan Desember 2025.</p><p>Materi mencakup instalasi, konfigurasi, customization, dan troubleshooting OJS.</p><p>Peserta akan mendapatkan akses trial OJS hosting gratis selama 3 bulan untuk praktik.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'APJIKOM Raih Penghargaan dari Kemenristekdikti',
                'slug' => 'apjikom-raih-penghargaan-kemenristekdikti',
                'excerpt' => 'APJIKOM menerima penghargaan sebagai Asosiasi Terbaik dalam Pengembangan Publikasi Ilmiah.',
                'content' => '<p>Asosiasi Pengelola Jurnal Informatika dan Komputer (APJIKOM) menerima penghargaan dari Kementerian Riset, Teknologi, dan Pendidikan Tinggi sebagai Asosiasi Terbaik dalam Pengembangan Publikasi Ilmiah tahun 2025.</p><p>Penghargaan ini diberikan atas kontribusi APJIKOM dalam meningkatkan kualitas dan kuantitas publikasi ilmiah di bidang informatika dan komputer.</p><p>Direktur Jenderal Penguatan Riset dan Pengembangan menyerahkan langsung penghargaan tersebut kepada pengurus APJIKOM.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Program Mentoring Jurnal Baru',
                'slug' => 'program-mentoring-jurnal-baru',
                'excerpt' => 'APJIKOM meluncurkan program mentoring untuk jurnal-jurnal baru yang baru terbit.',
                'content' => '<p>APJIKOM meluncurkan program mentoring khusus untuk jurnal-jurnal baru yang baru terbit atau dalam tahap pengembangan.</p><p>Program ini menghubungkan jurnal baru dengan pengelola jurnal berpengalaman untuk berbagi best practices dan strategi pengembangan.</p><p>Pendaftaran program mentoring gelombang pertama dibuka hingga akhir bulan ini dengan kuota 50 jurnal.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Seminar Internasional ICICS 2025 Segera Hadir',
                'slug' => 'seminar-internasional-icics-2025',
                'excerpt' => 'International Conference on Informatics and Computer Science (ICICS 2025) akan diselenggarakan di Surabaya.',
                'content' => '<p>APJIKOM akan menyelenggarakan International Conference on Informatics and Computer Science (ICICS 2025) di Surabaya pada Februari 2026.</p><p>Konferensi ini menghadirkan keynote speaker dari berbagai negara dan menawarkan kesempatan publikasi di jurnal terindeks Scopus.</p><p>Call for papers telah dibuka dengan berbagai tema menarik di bidang informatika dan komputer.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Webinar Gratis: Strategi Indeksasi Scopus',
                'slug' => 'webinar-gratis-strategi-indeksasi-scopus',
                'excerpt' => 'APJIKOM mengadakan webinar gratis tentang strategi memasukkan jurnal ke indeksasi Scopus.',
                'content' => '<p>Webinar gratis dengan tema "Strategi Indeksasi Scopus untuk Jurnal Indonesia" akan diselenggarakan minggu depan.</p><p>Narasumber adalah mantan editor Scopus dan pengelola jurnal yang berhasil terindeks Scopus.</p><p>Webinar ini terbuka untuk umum dan gratis, peserta akan mendapatkan e-certificate.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Anggota APJIKOM Tembus 500 Jurnal',
                'slug' => 'anggota-apjikom-tembus-500-jurnal',
                'excerpt' => 'Jumlah anggota APJIKOM telah mencapai 500 jurnal dari seluruh Indonesia.',
                'content' => '<p>Dalam waktu kurang dari 1 tahun sejak peluncuran, APJIKOM telah memiliki 500 jurnal anggota dari berbagai universitas dan institusi penelitian di Indonesia.</p><p>Capaian ini menunjukkan tingginya antusiasme komunitas pengelola jurnal untuk bergabung dan berkontribusi dalam pengembangan publikasi ilmiah nasional.</p><p>Ketua APJIKOM menyampaikan terima kasih kepada seluruh anggota dan berkomitmen untuk terus memberikan layanan terbaik.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Peluncuran Portal Direktori Jurnal APJIKOM',
                'slug' => 'peluncuran-portal-direktori-jurnal',
                'excerpt' => 'APJIKOM meluncurkan portal direktori jurnal untuk memudahkan pencarian jurnal anggota.',
                'content' => '<p>APJIKOM meluncurkan portal direktori jurnal yang memudahkan peneliti dan penulis mencari jurnal anggota berdasarkan bidang ilmu, akreditasi, dan indeksasi.</p><p>Portal ini juga menyediakan informasi lengkap tentang fokus dan scope masing-masing jurnal serta kontak editor.</p><p>Akses portal dapat dilakukan melalui website resmi APJIKOM.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }
    }
}
