<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Database\Seeders\JournalSeeder;

try {
    $seeder = new JournalSeeder();
    $seeder->setCommand(new class {
        public function info($message) {
            echo "✅ " . $message . "\n";
        }
    });
    
    $seeder->run();
    echo "\n🎉 Seeder berhasil dijalankan!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
