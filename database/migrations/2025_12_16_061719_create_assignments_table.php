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
        if (!Schema::hasTable('assignments')) {
            Schema::create('assignments', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('file_path')->nullable();
                $table->string('google_drive_link')->nullable();
                $table->unsignedBigInteger('assigned_to_user_id');
                $table->unsignedBigInteger('assigned_by_user_id');
                $table->date('due_date')->nullable();
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
                $table->timestamps();
                
                $table->foreign('assigned_to_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('assigned_by_user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
