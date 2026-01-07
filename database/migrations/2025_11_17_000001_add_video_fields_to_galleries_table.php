<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('type')->default('image')->after('id'); // image or video
            $table->string('youtube_url')->nullable()->after('image');
            $table->string('youtube_id')->nullable()->after('youtube_url');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['type', 'youtube_url', 'youtube_id']);
        });
    }
};
