<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Status verifikasi pembayaran untuk permintaan cetak kartu FISIK, dikelola
     * dari halaman admin khusus (admin.physical-card-requests). Nilai:
     * null/'pending' = menunggu diverifikasi, 'verified' = pembayaran valid
     * (kartu sedang dicetak), 'rejected' = bukti bayar ditolak.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'physical_card_payment_status')) {
                $table->string('physical_card_payment_status')->nullable()->after('physical_card_requested_at');
                $table->timestamp('physical_card_payment_verified_at')->nullable()->after('physical_card_payment_status');
                $table->unsignedBigInteger('physical_card_payment_verified_by')->nullable()->after('physical_card_payment_verified_at');
                $table->text('physical_card_payment_notes')->nullable()->after('physical_card_payment_verified_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'physical_card_payment_status')) {
                $table->dropColumn([
                    'physical_card_payment_status',
                    'physical_card_payment_verified_at',
                    'physical_card_payment_verified_by',
                    'physical_card_payment_notes',
                ]);
            }
        });
    }
};
