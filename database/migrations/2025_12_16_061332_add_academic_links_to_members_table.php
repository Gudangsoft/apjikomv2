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
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'google_scholar_link')) {
                $table->string('google_scholar_link')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('members', 'sinta_link')) {
                $table->string('sinta_link')->nullable()->after('google_scholar_link');
            }
            if (!Schema::hasColumn('members', 'orcid_link')) {
                $table->string('orcid_link')->nullable()->after('sinta_link');
            }
            if (!Schema::hasColumn('members', 'scopus_link')) {
                $table->string('scopus_link')->nullable()->after('orcid_link');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['google_scholar_link', 'sinta_link', 'orcid_link', 'scopus_link']);
        });
    }
};
