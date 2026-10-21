<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kerjasama (MOU/MOA) dengan institusi/mitra lain — terpisah dari
     * "partners" (logo sponsor di beranda) dan "institutions" (institusi
     * asal member), karena ini punya dokumen MoU/MoA & deskripsi lingkup
     * kerjasama sendiri.
     */
    public function up(): void
    {
        Schema::create('cooperations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama institusi/mitra
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('category')->nullable(); // Program Studi / Bidang Kerjasama
            $table->string('website')->nullable();
            $table->string('mou_file')->nullable();
            $table->date('mou_date')->nullable();
            $table->string('moa_file')->nullable();
            $table->date('moa_date')->nullable();
            $table->text('description')->nullable(); // lingkup/ruang kerjasama
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperations');
    }
};
