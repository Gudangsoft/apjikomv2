<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SectionLabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionLabels = [
            // Home Page Sections
            [
                'key' => 'section_label_about',
                'value' => 'Tentang APJIKOM',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Tentang'
            ],
            [
                'key' => 'section_label_benefits',
                'value' => 'Keuntungan Menjadi Anggota APJIKOM',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Keuntungan'
            ],
            [
                'key' => 'section_label_partners',
                'value' => 'Partner Kami',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Partner'
            ],
            [
                'key' => 'section_label_partners_subtitle',
                'value' => 'Dipercaya oleh berbagai institusi terkemuka',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Subtitle untuk section Partner'
            ],
            [
                'key' => 'section_label_cta',
                'value' => 'Mari Bergabung dengan APJIKOM',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Call to Action'
            ],
            
            // News & Events
            [
                'key' => 'section_label_latest_news',
                'value' => 'Berita Terbaru',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Berita Terbaru'
            ],
            [
                'key' => 'section_label_upcoming_events',
                'value' => 'Ikuti terus Kegiatan Kami',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Event'
            ],
            
            // Member Section
            [
                'key' => 'section_label_members',
                'value' => 'Daftar Anggota',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Anggota'
            ],
            
            // Category Section
            [
                'key' => 'section_label_categories',
                'value' => 'Kategori',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Kategori'
            ],
            
            // Registration Section
            [
                'key' => 'section_label_registration',
                'value' => 'Pendaftaran Anggota',
                'type' => 'text',
                'group' => 'section_labels',
                'description' => 'Label untuk section Pendaftaran'
            ],
        ];

        foreach ($sectionLabels as $label) {
            Setting::updateOrCreate(
                ['key' => $label['key']],
                [
                    'value' => $label['value'],
                    'type' => $label['type'],
                    'group' => $label['group']
                ]
            );
        }

        $this->command->info('Section labels seeded successfully!');
    }
}
