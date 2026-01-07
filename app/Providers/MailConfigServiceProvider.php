<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Load mail configuration from database
        try {
            if (\Schema::hasTable('settings')) {
                $settings = Setting::where('group', 'email')->pluck('value', 'key');
                
                if ($settings->isNotEmpty()) {
                    Config::set([
                        'mail.default' => $settings['mail_mailer'] ?? config('mail.default'),
                        'mail.mailers.smtp.host' => $settings['mail_host'] ?? config('mail.mailers.smtp.host'),
                        'mail.mailers.smtp.port' => $settings['mail_port'] ?? config('mail.mailers.smtp.port'),
                        'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? config('mail.mailers.smtp.encryption'),
                        'mail.mailers.smtp.username' => $settings['mail_username'] ?? config('mail.mailers.smtp.username'),
                        'mail.mailers.smtp.password' => $settings['mail_password'] ?? config('mail.mailers.smtp.password'),
                        'mail.from.address' => $settings['mail_from_address'] ?? config('mail.from.address'),
                        'mail.from.name' => $settings['mail_from_name'] ?? config('mail.from.name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail during migration or when database is not ready
            \Log::warning('Could not load mail config from database: ' . $e->getMessage());
        }
    }
}
