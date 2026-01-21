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
        // Fix payment_contact to be nullable
        DB::statement('ALTER TABLE events MODIFY payment_contact VARCHAR(255) NULL');
        
        // Also ensure other payment fields are nullable if they aren't already
        Schema::table('events', function (Blueprint $table) {
            // These should already be nullable, but let's make sure
            if (Schema::hasColumn('events', 'bank_name')) {
                $table->string('bank_name', 100)->nullable()->change();
            }
            if (Schema::hasColumn('events', 'bank_account')) {
                $table->string('bank_account', 50)->nullable()->change();
            }
            if (Schema::hasColumn('events', 'bank_account_name')) {
                $table->string('bank_account_name', 100)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this fix
    }
};
