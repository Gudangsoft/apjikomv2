<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert default payment mode settings
        $timestamp = now();
        
        // Use updateOrInsert to avoid duplicate key errors
        DB::table('settings')->updateOrInsert(
            ['key' => 'registration_mode'],
            [
                'value' => 'paid',
                'group' => 'payment',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        );
        
        DB::table('settings')->updateOrInsert(
            ['key' => 'require_payment_proof'],
            [
                'value' => '1',
                'group' => 'payment',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['registration_mode', 'require_payment_proof'])->delete();
    }
};
