<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Slider;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any existing slider button_links that point to the old registration URL
        Slider::where('button_link', 'LIKE', '%/register%')
            ->orWhere('button_link', 'LIKE', '%register%')
            ->update([
                'button_link' => url('/daftar-anggota')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert back if needed
        Slider::where('button_link', 'LIKE', '%/daftar-anggota%')
            ->update([
                'button_link' => url('/register')
            ]);
    }
};