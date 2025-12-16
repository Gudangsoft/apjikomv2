<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Registration;
use App\Models\Member;
use App\Models\User;

echo "=== CHECKING REGISTRATION & MEMBER STATUS ===\n\n";

$registrations = Registration::all();
echo "Total Registrations: " . $registrations->count() . "\n\n";

foreach ($registrations as $reg) {
    echo "Registration ID: {$reg->id}\n";
    echo "  Status: {$reg->status}\n";
    echo "  Email: {$reg->email}\n";
    echo "  Name: {$reg->full_name}\n";
    
    $user = User::where('email', $reg->email)->first();
    if ($user) {
        echo "  ✓ User exists (ID: {$user->id})\n";
        
        $member = Member::where('user_id', $user->id)->first();
        if ($member) {
            echo "  ✓ Member exists (ID: {$member->id}, Number: {$member->member_number})\n";
        } else {
            echo "  ✗ Member NOT created yet\n";
        }
    } else {
        echo "  ✗ User NOT created yet\n";
    }
    echo "\n";
}

echo "\n=== SUMMARY ===\n";
echo "Total Registrations: " . Registration::count() . "\n";
echo "Total Users: " . User::count() . "\n";
echo "Total Members: " . Member::count() . "\n";
echo "Approved Registrations: " . Registration::where('status', 'approved')->count() . "\n";
