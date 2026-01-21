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
        if (!Schema::hasTable('social_media')) {
            Schema::create('social_media', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Nama platform (Facebook, Instagram, etc)
                $table->string('url'); // Link URL
                $table->string('icon')->nullable(); // Path icon/logo yang diupload
                $table->string('icon_class')->nullable(); // CSS class untuk icon (misal: fab fa-facebook)
                $table->text('note')->nullable(); // Catatan/keterangan
                $table->integer('order')->default(0); // Urutan tampil
                $table->boolean('is_active')->default(true); // Aktif atau tidak
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
