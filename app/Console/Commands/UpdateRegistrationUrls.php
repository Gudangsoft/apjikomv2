<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Slider;
use App\Models\Setting;

class UpdateRegistrationUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apjikom:update-registration-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all registration URLs from /register to /daftar-anggota';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating registration URLs...');

        // Update sliders
        $slidersUpdated = Slider::where('button_link', 'LIKE', '%/register%')
            ->orWhere('button_link', 'LIKE', '%register')
            ->get();

        foreach ($slidersUpdated as $slider) {
            $oldLink = $slider->button_link;
            $newLink = str_replace('/register', '/daftar-anggota', $oldLink);
            $newLink = str_replace('register', 'daftar-anggota', $newLink);
            
            $slider->update(['button_link' => $newLink]);
            $this->line("Updated slider: {$oldLink} → {$newLink}");
        }

        // Update settings if any
        $settings = Setting::where('value', 'LIKE', '%/register%')
            ->orWhere('value', 'LIKE', '%register')
            ->get();

        foreach ($settings as $setting) {
            $oldValue = $setting->value;
            $newValue = str_replace('/register', '/daftar-anggota', $oldValue);
            $newValue = str_replace('register', 'daftar-anggota', $newValue);
            
            if ($oldValue !== $newValue) {
                $setting->update(['value' => $newValue]);
                $this->line("Updated setting '{$setting->key}': {$oldValue} → {$newValue}");
            }
        }

        $this->info('Registration URLs updated successfully!');
        $this->info("Updated {$slidersUpdated->count()} slider(s) and {$settings->count()} setting(s)");

        return 0;
    }
}