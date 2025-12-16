<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

echo "Running migration for card update request fields...\n\n";

try {
    Illuminate\Support\Facades\Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_11_15_171700_add_card_update_request_fields_to_members_table.php',
        '--force' => true
    ]);
    
    echo Illuminate\Support\Facades\Artisan::output();
    echo "\n✓ Migration completed successfully!\n";
} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
}
