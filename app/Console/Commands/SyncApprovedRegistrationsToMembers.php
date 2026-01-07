<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Console\Command;

class SyncApprovedRegistrationsToMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registrations:sync-to-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync approved registrations to members and ensure users have correct role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Syncing approved registrations to members...');
        $this->newLine();

        // Get all approved registrations
        $approvedRegistrations = Registration::where('status', 'approved')->get();
        
        if ($approvedRegistrations->isEmpty()) {
            $this->warn('No approved registrations found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$approvedRegistrations->count()} approved registrations");
        $this->newLine();

        $stats = [
            'user_role_fixed' => 0,
            'email_verified' => 0,
            'member_linked' => 0,
            'already_ok' => 0,
            'errors' => 0,
        ];

        foreach ($approvedRegistrations as $registration) {
            try {
                $this->line("Processing: {$registration->full_name} ({$registration->email})");

                // Check if user exists
                $user = User::where('email', $registration->email)->first();
                
                if (!$user) {
                    $this->error("  ❌ User not found for: {$registration->email}");
                    $stats['errors']++;
                    continue;
                }

                // Fix user role if needed
                $needsUpdate = false;
                
                if ($user->role === 'user') {
                    $user->role = 'member';
                    $needsUpdate = true;
                    $this->info("  ✅ Updated user role: user → member");
                    $stats['user_role_fixed']++;
                }
                
                // Verify email if not verified
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                    $needsUpdate = true;
                    $this->info("  ✅ Email verified");
                    $stats['email_verified']++;
                }
                
                if ($needsUpdate) {
                    $user->save();
                }

                // Check if member exists
                $member = Member::where('user_id', $user->id)->first();
                
                if (!$member) {
                    $this->error("  ❌ Member record not found for user ID: {$user->id}");
                    $stats['errors']++;
                    continue;
                }

                // Link registration to member if not linked
                if (!$registration->member_id) {
                    $registration->member_id = $member->id;
                    $registration->save();
                    $this->info("  ✅ Linked registration to member");
                    $stats['member_linked']++;
                } else {
                    $this->comment("  ℹ️  Already OK");
                    $stats['already_ok']++;
                }

            } catch (\Exception $e) {
                $this->error("  ❌ Error: {$e->getMessage()}");
                $stats['errors']++;
            }

            $this->newLine();
        }

        // Summary
        $this->newLine();
        $this->info('📊 Summary:');
        $this->table(
            ['Action', 'Count'],
            [
                ['User roles fixed (user → member)', $stats['user_role_fixed']],
                ['Emails verified', $stats['email_verified']],
                ['Registrations linked to members', $stats['member_linked']],
                ['Already OK', $stats['already_ok']],
                ['Errors', $stats['errors']],
            ]
        );

        return Command::SUCCESS;
    }
}
