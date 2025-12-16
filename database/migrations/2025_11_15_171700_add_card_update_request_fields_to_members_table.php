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
            $table->boolean('card_update_requested')->default(false)->after('card_requested_at');
            $table->timestamp('card_update_requested_at')->nullable()->after('card_update_requested');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['card_update_requested', 'card_update_requested_at']);
        });
    }
};
