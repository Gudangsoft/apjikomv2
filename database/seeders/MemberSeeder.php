<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Member 1 - Akademisi Senior
        $user1 = User::create([
            'name' => 'Dr. Budi Santoso, S.Kom., M.T.',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user1->id,
            'member_type' => 'individual',
            'institution_name' => 'Universitas Bina Nusantara',
            'position' => 'Dosen & Peneliti Senior',
            'phone' => '081234567890',
            'website' => 'https://budisantoso.ac.id',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'expertise' => 'Artificial Intelligence, Machine Learning, Data Science',
            'bio' => 'Saya adalah akademisi dan peneliti dengan pengalaman lebih dari 15 tahun di bidang teknologi informasi dan komunikasi. Fokus penelitian saya meliputi kecerdasan buatan, pembelajaran mesin, dan analisis data besar. Sebagai dosen tetap di Fakultas Ilmu Komputer, saya telah membimbing lebih dari 100 mahasiswa dalam penelitian mereka dan menghasilkan berbagai publikasi ilmiah di jurnal internasional bereputasi. Saya juga aktif sebagai konsultan untuk berbagai perusahaan teknologi dalam implementasi solusi AI dan big data. Bergabung dengan APJIKOM adalah langkah strategis untuk terus berkontribusi dalam pengembangan industri komunikasi digital Indonesia melalui riset, kolaborasi, dan transfer pengetahuan kepada generasi muda profesional. Saya berkomitmen untuk terus berinovasi dan berbagi pengalaman dalam menghadapi tantangan transformasi digital yang terus berkembang.',
            'linkedin' => 'https://linkedin.com/in/budisantoso',
            'google_scholar_link' => 'https://scholar.google.com/citations?user=budisantoso',
            'is_verified' => true,
            'verified_at' => now(),
            'show_in_directory' => true,
        ]);

        // Member 2 - Praktisi Industri
        $user2 = User::create([
            'name' => 'Sarah Wijaya, S.I.Kom., MBA',
            'email' => 'sarah.wijaya@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user2->id,
            'member_type' => 'individual',
            'institution_name' => 'Digital Creative Agency Jakarta',
            'position' => 'Digital Marketing Director',
            'phone' => '081234567891',
            'website' => 'https://sarahwijaya.com',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'expertise' => 'Digital Marketing, Social Media Strategy, Brand Communication',
            'bio' => 'Profesional komunikasi digital dengan track record solid dalam membangun dan mengelola strategi pemasaran digital untuk berbagai brand ternama di Indonesia dan Asia Tenggara. Selama 12 tahun berkarir di industri kreatif dan teknologi, saya telah memimpin tim kreatif dalam mengeksekusi kampanye digital yang menghasilkan peningkatan engagement hingga 300% dan ROI yang signifikan. Keahlian saya mencakup social media management, content marketing, influencer collaboration, dan data-driven marketing strategy. Saya percaya bahwa komunikasi digital yang efektif harus menggabungkan kreativitas, data analytics, dan pemahaman mendalam tentang perilaku konsumen. Menjadi bagian dari APJIKOM memberikan saya kesempatan untuk berbagi best practices dengan sesama profesional, terus belajar tentang tren terkini, dan berkontribusi dalam meningkatkan standar industri komunikasi Indonesia. Passion saya adalah memberdayakan brand untuk berkomunikasi autentik di era digital yang dinamis.',
            'linkedin' => 'https://linkedin.com/in/sarahwijaya',
            'instagram' => '@sarahwijaya',
            'is_verified' => true,
            'verified_at' => now(),
            'show_in_directory' => true,
        ]);

        // Member 3 - Content Creator & Educator
        $user3 = User::create([
            'name' => 'Andi Prasetyo, S.Sos., M.I.Kom.',
            'email' => 'andi.prasetyo@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user3->id,
            'member_type' => 'individual',
            'institution_name' => 'ContentLab Indonesia',
            'position' => 'Content Strategist & Educator',
            'phone' => '081234567892',
            'website' => 'https://andiprasetyo.id',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'expertise' => 'Content Creation, Multimedia Production, Digital Storytelling',
            'bio' => 'Content creator dan educator yang passionate dalam mengembangkan konten digital berkualitas dan mendidik generasi muda tentang literasi media. Dengan background pendidikan ilmu komunikasi dan pengalaman praktis di industri media digital selama 10 tahun, saya memiliki perspektif unik yang menggabungkan teori dan praktik. Saya telah memproduksi ratusan konten multimedia untuk platform digital, mulai dari video edukatif, podcast, hingga kampanye social media. Sebagai educator, saya juga mengajar workshop dan pelatihan tentang content creation, digital storytelling, dan media literacy untuk berbagai institusi pendidikan dan korporat. Saya yakin bahwa konten yang powerful dapat mengubah perspektif, menginspirasi aksi, dan membangun komunitas. Bergabung dengan APJIKOM memungkinkan saya untuk terus mengembangkan kompetensi, berkolaborasi dengan profesional lain, dan turut serta dalam memajukan ekosistem komunikasi digital Indonesia yang lebih berkualitas dan bertanggung jawab.',
            'linkedin' => 'https://linkedin.com/in/andiprasetyo',
            'twitter' => '@andiprasetyo',
            'instagram' => '@andiprasetyo',
            'is_verified' => true,
            'verified_at' => now(),
            'show_in_directory' => true,
        ]);

        // Member 4 - Tech Entrepreneur
        $user4 = User::create([
            'name' => 'Rudi Hartono, S.T., M.M.',
            'email' => 'rudi.hartono@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user4->id,
            'member_type' => 'individual',
            'institution_name' => 'TechComm Solutions',
            'position' => 'Founder & CEO',
            'phone' => '081234567893',
            'website' => 'https://techcomm.id',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'expertise' => 'Digital Transformation, Startup Development, Technology Innovation',
            'bio' => 'Entrepreneur teknologi dengan fokus pada solusi komunikasi digital untuk transformasi bisnis. Sebagai founder dan CEO dari startup teknologi yang telah berkembang pesat, saya memimpin tim dalam mengembangkan platform dan tools inovatif yang membantu perusahaan mengoptimalkan strategi komunikasi digital mereka. Journey saya dimulai dari engineer hingga membangun perusahaan sendiri yang kini melayani lebih dari 200 klien korporat di Indonesia. Saya memiliki passion dalam mengidentifikasi peluang teknologi baru dan mentransformasikannya menjadi solusi bisnis yang scalable. Selain menjalankan perusahaan, saya juga aktif sebagai mentor untuk startup pemula dan sering menjadi pembicara di berbagai konferensi teknologi dan bisnis. APJIKOM menjadi platform yang tepat bagi saya untuk networking dengan profesional komunikasi, memahami kebutuhan industri lebih dalam, dan berkontribusi dalam ekosistem digital Indonesia melalui inovasi teknologi yang berdampak nyata.',
            'linkedin' => 'https://linkedin.com/in/rudihartono',
            'twitter' => '@rudihartono',
            'is_verified' => true,
            'verified_at' => now(),
            'show_in_directory' => true,
        ]);

        // Member 5 - Public Relations Specialist
        $user5 = User::create([
            'name' => 'Maya Kusuma, S.I.Kom.',
            'email' => 'maya.kusuma@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user5->id,
            'member_type' => 'individual',
            'institution_name' => 'PR Excellence Indonesia',
            'position' => 'Senior Public Relations Manager',
            'phone' => '081234567894',
            'website' => 'https://mayakusuma.com',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'expertise' => 'Public Relations, Crisis Communication, Media Relations',
            'bio' => 'PR professional dengan keahlian khusus dalam membangun dan mempertahankan reputasi brand di era digital. Selama 8 tahun berkecimpung di dunia public relations, saya telah menangani berbagai kasus komunikasi korporat, mulai dari product launching, crisis management, hingga corporate social responsibility programs. Saya memahami bahwa PR modern harus menguasai komunikasi terintegrasi yang menggabungkan media tradisional, digital, dan social media untuk mencapai hasil maksimal. Pengalaman saya mencakup mengelola hubungan dengan media massa, influencer, dan stakeholder kunci, serta merancang strategi komunikasi yang proaktif untuk mengantisipasi dan mengelola isu-isu sensitif. Saya percaya pada kekuatan storytelling autentik dan transparansi dalam membangun trust dengan publik. Melalui APJIKOM, saya berharap dapat terus mengasah kemampuan, berbagi pengalaman dengan sesama praktisi, dan berkontribusi dalam mengangkat profesionalisme industri komunikasi Indonesia ke level yang lebih tinggi.',
            'linkedin' => 'https://linkedin.com/in/mayakusuma',
            'facebook' => 'maya.kusuma',
            'instagram' => '@mayakusuma',
            'is_verified' => true,
            'verified_at' => now(),
            'show_in_directory' => true,
        ]);

        $this->command->info('5 member dengan bio lengkap berhasil dibuat!');
    }
}
