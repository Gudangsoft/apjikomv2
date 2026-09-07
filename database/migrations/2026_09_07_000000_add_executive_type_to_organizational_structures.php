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
        DB::statement("ALTER TABLE organizational_structures MODIFY COLUMN type ENUM('executive', 'leadership', 'division') NOT NULL DEFAULT 'leadership'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE organizational_structures SET type = 'leadership' WHERE type = 'executive'");
        DB::statement("ALTER TABLE organizational_structures MODIFY COLUMN type ENUM('leadership', 'division') NOT NULL DEFAULT 'leadership'");
    }
};
