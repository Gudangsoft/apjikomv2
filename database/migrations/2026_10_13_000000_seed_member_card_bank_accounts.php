<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Seed the default REKENING APJI accounts used on the member "Kartu Anggota"
     * page (bank transfer info for the card-printing fee). Only seeds when the
     * admin hasn't already configured this setting — never overwrites real data.
     */
    public function up(): void
    {
        $existing = DB::table('settings')->where('key', 'member_card_bank_accounts')->first();
        $hasData = $existing && !in_array(trim((string) $existing->value), ['', '[]'], true);

        if ($hasData) {
            return;
        }

        DB::table('settings')->updateOrInsert(
            ['key' => 'member_card_bank_accounts'],
            [
                'value' => json_encode([
                    ['bank' => 'BRI', 'number' => '224201000618304', 'holder' => 'ASOSIASI PENGELOLA JURNAL INDONESIA'],
                    ['bank' => 'BNI', 'number' => '2285852706', 'holder' => 'ASOSIASI PENGELOLA JURNAL INDONESIA'],
                ]),
                'type' => 'json',
                'group' => 'member_contact',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: don't delete admin-managed settings data on rollback.
    }
};
