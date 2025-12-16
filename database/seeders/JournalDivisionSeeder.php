<?php

namespace Database\Seeders;

use App\Models\JournalDivision;
use Illuminate\Database\Seeder;

class JournalDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'division' => 'Sistem Informasi',
                'main_focus' => 'Enterprise Systems & Database',
                'journal_potential' => 'Journal of Information Systems and Digital Transformation',
                'order' => 1,
            ],
            [
                'division' => 'Teknologi Informasi',
                'main_focus' => 'IT Management & Cloud Systems',
                'journal_potential' => 'Journal of Information Technology and System Engineering',
                'order' => 2,
            ],
            [
                'division' => 'Ilmu Komputer',
                'main_focus' => 'Algorithms & Computing',
                'journal_potential' => 'Journal of Computer Science and Computational Intelligence',
                'order' => 3,
            ],
            [
                'division' => 'Kecerdasan Buatan',
                'main_focus' => 'AI & Machine Learning',
                'journal_potential' => 'Journal of Artificial Intelligence and Smart Systems',
                'order' => 4,
            ],
            [
                'division' => 'Keamanan Siber',
                'main_focus' => 'Security & Cryptography',
                'journal_potential' => 'Journal of Cybersecurity and Digital Forensics',
                'order' => 5,
            ],
            [
                'division' => 'Rekayasa Perangkat Lunak',
                'main_focus' => 'Software Development & Engineering',
                'journal_potential' => 'Journal of Software Engineering and Application Development',
                'order' => 6,
            ],
            [
                'division' => 'Data Science',
                'main_focus' => 'Big Data & Analytics',
                'journal_potential' => 'Journal of Data Science and Business Intelligence',
                'order' => 7,
            ],
            [
                'division' => 'Jaringan Komputer',
                'main_focus' => 'Networks & IoT',
                'journal_potential' => 'Journal of Computer Networks and Internet of Things',
                'order' => 8,
            ],
            [
                'division' => 'Multimedia & Game',
                'main_focus' => 'Graphics & Interactive Media',
                'journal_potential' => 'Journal of Digital Media and Game Technology',
                'order' => 9,
            ],
            [
                'division' => 'Komputasi Awan',
                'main_focus' => 'Cloud Computing & Virtualization',
                'journal_potential' => 'Journal of Cloud Computing and Distributed Systems',
                'order' => 10,
            ],
        ];

        foreach ($divisions as $division) {
            JournalDivision::create($division);
        }
    }
}
