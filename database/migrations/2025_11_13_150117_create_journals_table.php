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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('authors');
            $table->text('abstract');
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->year('year');
            $table->string('pages')->nullable();
            $table->string('doi')->nullable();
            $table->text('keywords')->nullable();
            $table->string('file_path')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('published_date')->nullable();
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->boolean('is_published')->default(false);
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
