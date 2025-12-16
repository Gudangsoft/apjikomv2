<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('show_in_directory')->default(false)->after('website');
            $table->text('expertise')->nullable()->after('website'); // Keahlian/bidang
            $table->text('bio')->nullable()->after('expertise'); // Short bio
            $table->string('linkedin')->nullable()->after('bio');
            $table->string('facebook')->nullable()->after('linkedin');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('instagram')->nullable()->after('twitter');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'show_in_directory',
                'expertise',
                'bio',
                'linkedin',
                'facebook',
                'twitter',
                'instagram'
            ]);
        });
    }
};
