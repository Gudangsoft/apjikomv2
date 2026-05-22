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
            ['key' => 'site_name', 'value' => 'Website Asosiasi', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Website Asosiasi', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Website Asosiasi', 'type' => 'textarea', 'group' => 'general'],

            // Contact Settings
            ['key' => 'contact_email', 'value' => 'info@example.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '', 'type' => 'textarea', 'group' => 'contact'],

            // Social Media
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'text', 'group' => 'social'],

            // SEO Settings
            ['key' => 'meta_keywords', 'value' => 'website asosiasi', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Website Asosiasi', 'type' => 'textarea', 'group' => 'seo'],

            // Copyright
            ['key' => 'footer_copyright_text', 'value' => '&copy; ' . date('Y') . ' Website Asosiasi. All Rights Reserved.', 'type' => 'text', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
