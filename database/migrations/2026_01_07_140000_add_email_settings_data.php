<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Insert default email settings
        DB::table('settings')->insert([
            [
                'key' => 'mail_mailer',
                'value' => 'smtp',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.titan.email',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_port',
                'value' => '465',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_username',
                'value' => 'info@scirepid.com',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_password',
                'value' => 'LpkdApjiJaya100%',
                'type' => 'password',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'ssl',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'info@scirepid.com',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'APJIKOM',
                'type' => 'text',
                'group' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ])->delete();
    }
};
