<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('notes');
            $table->string('payment_status')->default('pending')->after('payment_proof'); // pending, paid, verified, rejected
            $table->timestamp('payment_verified_at')->nullable()->after('payment_status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('payment_verified_at');
            $table->text('payment_notes')->nullable()->after('verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'payment_status',
                'payment_verified_at',
                'verified_by',
                'payment_notes'
            ]);
        });
    }
};
