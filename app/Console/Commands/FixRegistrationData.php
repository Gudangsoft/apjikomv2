<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;
use App\Models\User;
use App\Models\Member;

class FixRegistrationData extends Command
{
    protected $signature = 'fix:registrations';
    protected $description = 'Fix registration data - recreate users and members from approved registrations';

    public function handle()
    {
        $this->info('Checking approved registrations...');
        
        $approvedRegistrations = Registration::where('status', 'approved')->get();
        
        if ($approvedRegistrations->isEmpty()) {
            $this->info('No approved registrations found.');
            return 0;
        }
        
        $this->info("Found {$approvedRegistrations->count()} approved registration(s).");
        
        foreach ($approvedRegistrations as $registration) {
            $this->info("\nProcessing: {$registration->email}");
            
            // Check if user exists
            $user = User::where('email', $registration->email)->first();
            
            if (!$user) {
                $this->warn("  User not found. Creating...");
                $user = User::create([
                    'name' => $registration->full_name,
                    'email' => $registration->email,
                    'password' => $registration->password, // Already hashed
                    'email_verified_at' => now(),
                ]);
                $this->info("  ✓ User created (ID: {$user->id})");
            } else {
                $this->info("  ✓ User exists (ID: {$user->id})");
            }
            
            // Check if member exists
            $member = Member::where('user_id', $user->id)->first();
            
            if (!$member) {
                $this->warn("  Member not found. Creating...");
                
                // Generate member number
                $lastMember = Member::latest('id')->first();
                $nextNumber = $lastMember ? (intval(substr($lastMember->member_number, -4)) + 1) : 1;
                $memberNumber = 'APJ' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                
                $joinDate = now();
                $member = Member::create([
                    'user_id' => $user->id,
                    'member_number' => $memberNumber,
                    'full_name' => $registration->full_name,
                    'phone' => $registration->phone,
                    'institution' => $registration->institution,
                    'membership_type' => $registration->type === 'prodi' ? 'institutional' : 'individual',
                    'join_date' => $joinDate,
                    'expiry_date' => $joinDate->copy()->addYear(),
                    'status' => 'active',
                    'address' => $registration->address ?? null,
                    'show_in_directory' => false,
                ]);
                
                $this->info("  ✓ Member created (ID: {$member->id}, Number: {$memberNumber})");
                
                // Link registration to member
                $registration->member_id = $member->id;
                $registration->save();
                $this->info("  ✓ Registration linked to member");
                
            } else {
                $this->info("  ✓ Member exists (ID: {$member->id}, Number: {$member->member_number})");
                
                // Update link if missing
                if (!$registration->member_id) {
                    $registration->member_id = $member->id;
                    $registration->save();
                    $this->info("  ✓ Registration linked to member");
                }
            }
        }
        
        $this->info("\n✓ All done!");
        return 0;
    }
}
