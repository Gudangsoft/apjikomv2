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
        // Create table untuk template kartu anggota
        if (!Schema::hasTable('member_card_templates')) {
            Schema::create('member_card_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Nama template
                $table->string('template_image'); // Background/template kartu
                $table->boolean('is_active')->default(false); // Template aktif yang digunakan
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Update members table - remove old member_card column jika ada
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                // member_number sudah ada dari migration sebelumnya
                // member_card akan berisi generated card path
                if (!Schema::hasColumn('members', 'card_generated_at')) {
                    $table->timestamp('card_generated_at')->nullable()->after('member_card');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_card_templates');
        
        if (Schema::hasColumn('members', 'card_generated_at')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('card_generated_at');
            });
        }
    }
};
