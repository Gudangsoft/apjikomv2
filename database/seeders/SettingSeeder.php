<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'APJIKOM', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Asosiasi Pengelola Jurnal Ilmu Komunikasi', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'APJIKOM adalah asosiasi yang menghimpun pengelola jurnal ilmu komunikasi di Indonesia untuk meningkatkan kualitas publikasi ilmiah.', 'type' => 'textarea', 'group' => 'general'],
            
            // Contact Settings
            ['key' => 'contact_email', 'value' => 'info@apjikom.or.id', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'type' => 'textarea', 'group' => 'contact'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/apjikom', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/apjikom', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/apjikom', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/apjikom', 'type' => 'text', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@apjikom', 'type' => 'text', 'group' => 'social'],
            
            // SEO Settings
            ['key' => 'meta_keywords', 'value' => 'apjikom, jurnal ilmiah, komunikasi, publikasi, indonesia', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'APJIKOM - Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia. Platform untuk meningkatkan kualitas publikasi ilmiah komunikasi.', 'type' => 'textarea', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
