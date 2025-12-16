<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $paymentSettings = [
            [
                'key' => 'biaya_individu',
                'value' => '250000',
                'type' => 'number',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'biaya_prodi',
                'value' => '750000',
                'type' => 'number',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'bank_name',
                'value' => 'BNI 46 Cabang Perintis Kemerdekaan',
                'type' => 'text',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'account_number',
                'value' => '1119995552',
                'type' => 'text',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'account_name',
                'value' => 'APTIKOM',
                'type' => 'text',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => '081234567890',
                'type' => 'text',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@apjikom.or.id',
                'type' => 'email',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '081234567890',
                'type' => 'text',
                'group' => 'payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($paymentSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'biaya_individu',
            'biaya_prodi',
            'bank_name',
            'account_number',
            'account_name',
            'contact_phone',
            'contact_email',
            'contact_whatsapp',
        ])->delete();
    }
};
