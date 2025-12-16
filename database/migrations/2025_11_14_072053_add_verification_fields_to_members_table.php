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
            $table->boolean('is_verified')->default(false)->after('status');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->string('verification_document')->nullable()->after('verified_at');
            $table->text('verification_notes')->nullable()->after('verification_document');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verification_notes');
            
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'is_verified',
                'verified_at',
                'verification_document',
                'verification_notes',
                'verified_by'
            ]);
        });
    }
};
