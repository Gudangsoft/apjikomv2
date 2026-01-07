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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['individu', 'prodi']); // Tipe pendaftaran
            
            // Data Umum (kedua tipe)
            $table->string('email')->unique();
            $table->string('phone', 13);
            $table->string('full_name');
            $table->string('payment_proof'); // Path file bukti pembayaran
            
            // Data khusus Prodi
            $table->string('institution')->nullable();
            $table->string('study_program')->nullable();
            $table->string('accreditation')->nullable();
            $table->date('accreditation_valid_until')->nullable();
            $table->string('province')->nullable();
            $table->string('authorization_letter')->nullable(); // Path file surat kuasa
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable(); // Catatan admin
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
