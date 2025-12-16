<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Create notifications table
    if (!Schema::hasTable('notifications')) {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->string('color')->default('blue');
            $table->string('action_url')->nullable();
            $table->string('action_text')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'read_at']);
        });
        
        echo "✅ Tabel 'notifications' berhasil dibuat!\n";
    } else {
        echo "ℹ️ Tabel 'notifications' sudah ada.\n";
    }

    // Create event_registrations table
    if (!Schema::hasTable('event_registrations')) {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('registered');
            $table->text('notes')->nullable();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();
            
            $table->unique(['event_id', 'user_id']);
        });
        
        echo "✅ Tabel 'event_registrations' berhasil dibuat!\n";
    } else {
        echo "ℹ️ Tabel 'event_registrations' sudah ada.\n";
    }
    
    echo "\n🎉 Semua tabel berhasil dibuat!\n";
    echo "📍 Fitur yang sudah aktif:\n";
    echo "   - Notification System\n";
    echo "   - Event RSVP\n";
    echo "   - Dashboard Analytics\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
