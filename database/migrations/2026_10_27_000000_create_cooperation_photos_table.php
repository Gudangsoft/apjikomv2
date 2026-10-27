<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Galeri foto per kerjasama (mis. dokumentasi penandatanganan MoU/MoA),
     * terpisah dari kolom "logo" tunggal di tabel cooperations.
     */
    public function up(): void
    {
        Schema::create('cooperation_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperation_id')->constrained()->onDelete('cascade');
            $table->string('photo');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperation_photos');
    }
};
