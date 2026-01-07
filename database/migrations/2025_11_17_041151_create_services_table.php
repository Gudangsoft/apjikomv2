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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // icon class or image path
            $table->string('color')->default('blue'); // blue, purple, green, orange
            $table->text('description');
            $table->json('features')->nullable(); // array of features/benefits
            $table->string('cta_text')->nullable(); // Call to action text
            $table->string('cta_link')->nullable(); // Call to action link
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
        Schema::dropIfExists('services');
    }
};
