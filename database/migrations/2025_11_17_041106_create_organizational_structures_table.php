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
        Schema::create('organizational_structures', function (Blueprint $table) {
            $table->id();
            $table->string('position'); // Ketua Umum, Sekretaris, Bendahara, etc.
            $table->string('name');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['leadership', 'division'])->default('leadership'); // leadership or division
            $table->string('division_name')->nullable(); // for division type
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
        Schema::dropIfExists('organizational_structures');
    }
};
