<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get active members
        $members = Member::where('status', 'active')->take(10)->get();

        if ($members->isEmpty()) {
            $this->command->warn('No active members found. Please create members first.');
            return;
        }

        $testimonialTexts = [
            'APJIKOM telah menjadi wadah yang sangat berharga bagi perkembangan karir saya di bidang ilmu komunikasi. Melalui berbagai kegiatan dan networking yang disediakan, saya dapat memperluas wawasan dan membangun relasi profesional dengan para akademisi komunikasi dari seluruh Indonesia.',
            'Bergabung dengan APJIKOM adalah keputusan terbaik dalam perjalanan akademis saya. Organisasi ini memberikan platform yang sangat baik untuk berbagi pengetahuan, pengalaman, dan kolaborasi riset dengan sesama dosen komunikasi di Indonesia.',
            'APJIKOM tidak hanya sekadar organisasi profesi, tetapi lebih dari itu - sebuah komunitas yang solid dan supportif. Program-program pelatihan dan pengembangan yang ditawarkan sangat membantu meningkatkan kompetensi saya sebagai pendidik.',
            'Saya sangat terkesan dengan komitmen APJIKOM dalam memajukan pendidikan ilmu komunikasi di Indonesia. Setiap kegiatan yang diselenggarakan selalu berkualitas dan memberikan manfaat nyata bagi para anggotanya.',
            'APJIKOM telah memfasilitasi banyak peluang kolaborasi riset dan publikasi ilmiah. Melalui jaringan yang luas, saya dapat terhubung dengan peneliti-peneliti komunikasi terbaik dan menghasilkan karya ilmiah yang berkualitas.',
            'Sebagai dosen muda, saya sangat terbantu dengan mentoring dan guidance yang diberikan oleh senior-senior di APJIKOM. Organisasi ini benar-benar peduli dengan pengembangan generasi muda akademisi komunikasi.',
            'APJIKOM memberikan kontribusi signifikan dalam pengembangan kurikulum dan standar pendidikan komunikasi di Indonesia. Sebagai anggota, saya merasa menjadi bagian dari gerakan besar untuk meningkatkan kualitas pendidikan komunikasi nasional.',
            'Program conference dan seminar yang diselenggarakan APJIKOM selalu berkualitas tinggi dengan pembicara-pembicara kompeten. Ini menjadi ajang pembelajaran dan update pengetahuan terkini di bidang komunikasi.',
            'APJIKOM memiliki peran strategis dalam membangun sinergi antar program studi komunikasi di Indonesia. Melalui forum-forum diskusi, kami dapat saling berbagi best practices dan mengatasi tantangan bersama.',
            'Keanggotaan di APJIKOM membuka banyak pintu kesempatan, mulai dari kolaborasi penelitian, publikasi internasional, hingga program exchange dengan universitas luar negeri. Sangat valuable untuk pengembangan karir akademis.',
        ];

        foreach ($members as $index => $member) {
            if ($index >= count($testimonialTexts)) break;

            Testimonial::create([
                'member_id' => $member->id,
                'content' => $testimonialTexts[$index],
                'rating' => rand(4, 5), // Rating 4-5 stars
                'is_featured' => $index < 3, // First 3 are featured
                'is_active' => true,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Testimonials seeded successfully with ' . min(count($members), count($testimonialTexts)) . ' testimonials!');
    }
}
