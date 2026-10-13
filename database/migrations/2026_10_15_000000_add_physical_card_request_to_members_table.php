<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kartu file (digital, via card_requested/card_update_requested) dan kartu
     * fisik (cetak, berbayar) adalah dua layanan terpisah. Kolom ini khusus
     * menandai permintaan CETAK FISIK, independen dari status kartu file.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'physical_card_requested')) {
                $table->boolean('physical_card_requested')->default(false)->after('card_payment_proof_uploaded_at');
                $table->timestamp('physical_card_requested_at')->nullable()->after('physical_card_requested');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'physical_card_requested')) {
                $table->dropColumn(['physical_card_requested', 'physical_card_requested_at']);
            }
        });
    }
};
