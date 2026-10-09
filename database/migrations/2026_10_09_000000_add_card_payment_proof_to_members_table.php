<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'card_payment_proof')) {
                $table->string('card_payment_proof')->nullable()->after('card_update_requested_at');
                $table->timestamp('card_payment_proof_uploaded_at')->nullable()->after('card_payment_proof');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'card_payment_proof')) {
                $table->dropColumn(['card_payment_proof', 'card_payment_proof_uploaded_at']);
            }
        });
    }
};
