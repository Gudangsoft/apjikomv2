<?php
/**
 * Script untuk menambahkan setting registration_mode dan require_payment_proof
 * Jalankan dengan: php insert_settings.php
 * Atau via tinker: php artisan tinker, lalu paste kode di dalamnya
 */

use App\Models\Setting;

// Insert registration_mode
Setting::updateOrCreate(
    ['key' => 'registration_mode', 'group' => 'payment'],
    [
        'value' => 'paid',
        'type' => 'text',
    ]
);

// Insert require_payment_proof
Setting::updateOrCreate(
    ['key' => 'require_payment_proof', 'group' => 'payment'],
    [
        'value' => '1',
        'type' => 'boolean',
    ]
);

echo "✅ Settings berhasil ditambahkan!\n";
echo "- registration_mode: paid\n";
echo "- require_payment_proof: 1\n";
