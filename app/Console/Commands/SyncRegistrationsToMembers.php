<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SyncRegistrationsToMembers extends Command
{
    protected $signature = 'members:sync-from-registrations';
    protected $description = 'Sync approved registrations to members table';

    public function handle()
    {
        $this->info('🔄 Syncing approved registrations to members...');
        $this->newLine();

        $approvedRegistrations = Registration::where('status', 'approved')->get();
        
        if ($approvedRegistrations->isEmpty()) {
            $this->warn('No approved registrations found.');
            return 0;
        }

        $this->info("Found {$approvedRegistrations->count()} approved registrations");
        $this->newLine();

        $created = 0;
        $skipped = 0;

        foreach ($approvedRegistrations as $registration) {
            $this->line("Processing: {$registration->full_name} ({$registration->email})");

            // Check if user exists
            $user = User::where('email', $registration->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $registration->full_name,
                    'email' => $registration->email,
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);
                $this->info("  ✓ User created");
            } else {
                $this->comment("  → User already exists");
            }

            // Check if member exists
            $existingMember = Member::where('user_id', $user->id)->first();
            
            if (!$existingMember) {
                // Generate member number
                $lastMember = Member::latest('id')->first();
                $nextNumber = $lastMember ? (intval(substr($lastMember->member_number, -4)) + 1) : 1;
                $memberNumber = 'APJ' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                // Create member
                Member::create([
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

                $this->info("  ✓ Member created ({$memberNumber})");
                $created++;
            } else {
                $this->comment("  → Member already exists ({$existingMember->member_number})");
                $skipped++;
            }

            $this->newLine();
        }

        $this->newLine();
        $this->info("✅ Sync completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Created', $created],
                ['Skipped (already exists)', $skipped],
                ['Total processed', $created + $skipped],
            ]
        );

        return 0;
    }
}
