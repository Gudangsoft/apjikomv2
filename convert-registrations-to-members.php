<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Registration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CONVERTING APPROVED REGISTRATIONS TO MEMBERS ===\n\n";

$approvedRegistrations = Registration::where('status', 'approved')->get();

echo "Found {$approvedRegistrations->count()} approved registrations\n\n";

foreach ($approvedRegistrations as $registration) {
    echo "Processing Registration ID: {$registration->id}\n";
    echo "  Name: {$registration->full_name}\n";
    echo "  Email: {$registration->email}\n";
    
    // Check if user already exists
    $user = User::where('email', $registration->email)->first();
    
    if (!$user) {
        // Create new user
        $user = User::create([
            'name' => $registration->full_name,
            'email' => $registration->email,
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        echo "  ✓ User created (ID: {$user->id})\n";
    } else {
        echo "  ✓ User already exists (ID: {$user->id})\n";
    }
    
    // Check if member already exists
    $existingMember = Member::where('user_id', $user->id)->first();
    
    if (!$existingMember) {
        // Generate member number
        $lastMember = Member::latest('id')->first();
        $nextNumber = $lastMember ? (intval(substr($lastMember->member_number, -4)) + 1) : 1;
        $memberNumber = 'APJ' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Create member
        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => $memberNumber,
            'full_name' => $registration->full_name,
            'phone' => $registration->phone,
            'institution' => $registration->institution,
            'membership_type' => $registration->type === 'prodi' ? 'institutional' : 'individual',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
            'status' => 'active',
            'address' => $registration->address ?? null,
        ]);
        
        echo "  ✓ Member created (ID: {$member->id}, Number: {$memberNumber})\n";
    } else {
        echo "  ✓ Member already exists (ID: {$existingMember->id}, Number: {$existingMember->member_number})\n";
    }
    
    echo "  ✅ DONE\n\n";
}

echo "\n=== FINAL SUMMARY ===\n";
echo "Total Users: " . User::count() . "\n";
echo "Total Members: " . Member::count() . "\n";
echo "Approved Registrations: " . Registration::where('status', 'approved')->count() . "\n";
