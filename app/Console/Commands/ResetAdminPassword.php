<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email?}';
    protected $description = 'Reset admin password or create new admin';

    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Enter admin email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User dengan email {$email} tidak ditemukan!");
            
            if ($this->confirm('Buat admin baru?', true)) {
                $name = $this->ask('Nama admin', 'Admin APJIKOM');
                $password = $this->secret('Password baru');
                
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'is_admin' => true,
                    'email_verified_at' => now(),
                ]);
                
                $this->info("✅ Admin baru berhasil dibuat!");
                $this->table(
                    ['Field', 'Value'],
                    [
                        ['Email', $email],
                        ['Password', $password],
                        ['Name', $name],
                    ]
                );
                
                return Command::SUCCESS;
            }
            
            return Command::FAILURE;
        }
        
        // Reset password
        $password = $this->secret('Password baru untuk ' . $user->name);
        
        $user->update([
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_admin' => true,
        ]);
        
        $this->info("✅ Password berhasil direset!");
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $user->name],
                ['Email', $user->email],
                ['New Password', $password],
            ]
        );
        
        return Command::SUCCESS;
    }
}
