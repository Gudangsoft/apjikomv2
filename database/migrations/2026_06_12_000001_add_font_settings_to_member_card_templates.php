<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member_card_templates', function (Blueprint $table) {
            $table->json('font_settings')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('member_card_templates', function (Blueprint $table) {
            $table->dropColumn('font_settings');
        });
    }
};
