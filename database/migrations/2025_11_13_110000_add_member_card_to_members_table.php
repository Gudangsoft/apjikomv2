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
        if (Schema::hasTable('members') && !Schema::hasColumn('members', 'member_card')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('member_card')->nullable()->after('expiry_date');
                $table->string('member_number')->nullable()->after('member_card');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('members', 'member_card')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn(['member_card', 'member_number']);
            });
        }
    }
};
