<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The DB-level unique constraint on registrations.email used to block
     * someone from ever registering again after a PREVIOUS registration
     * attempt with that email was rejected (or still pending) — even though
     * no actual member account exists for them. "No duplicate ACTIVE
     * registration" is now enforced at the application level instead
     * (RegistrationController), which can exclude rejected rows.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
