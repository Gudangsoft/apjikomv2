<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class AddPaymentModeSettings extends Command
{
    protected $signature = 'settings:add-payment-mode';
    protected $description = 'Add registration_mode and require_payment_proof settings';

    public function handle()
    {
        $this->info('Adding payment mode settings...');

        Setting::updateOrCreate(
            ['key' => 'registration_mode', 'group' => 'payment'],
            [
                'value' => 'paid',
                'type' => 'text',
            ]
        );
        $this->line('✅ registration_mode: paid');

        Setting::updateOrCreate(
            ['key' => 'require_payment_proof', 'group' => 'payment'],
            [
                'value' => '1',
                'type' => 'boolean',
            ]
        );
        $this->line('✅ require_payment_proof: 1');

        $this->info('Payment mode settings successfully added!');
        return 0;
    }
}
