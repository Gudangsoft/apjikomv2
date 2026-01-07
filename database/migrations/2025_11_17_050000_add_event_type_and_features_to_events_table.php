<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('event_type', ['online', 'offline', 'hybrid'])->default('offline')->after('event_time');
            $table->boolean('has_registration')->default(false)->after('event_type');
            $table->boolean('has_certificate')->default(false)->after('has_registration');
            $table->string('online_platform')->nullable()->after('has_certificate'); // Zoom, Google Meet, etc
            $table->text('registration_requirements')->nullable()->after('online_platform');
            $table->integer('participant_quota')->nullable()->after('registration_requirements');
            $table->decimal('registration_fee', 10, 2)->nullable()->after('participant_quota');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'event_type',
                'has_registration',
                'has_certificate',
                'online_platform',
                'registration_requirements',
                'participant_quota',
                'registration_fee'
            ]);
        });
    }
};
