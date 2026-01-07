<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetMemberPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:reset-password {email} {--password=password123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for a member by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->option('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User dengan email '{$email}' tidak ditemukan!");
            return Command::FAILURE;
        }

        // Confirm reset
        $this->info("User ditemukan:");
        $this->line("  Nama: {$user->name}");
        $this->line("  Email: {$user->email}");
        $this->line("  Role: {$user->role}");
        $this->newLine();

        if (!$this->confirm("Reset password untuk user ini?")) {
            $this->warn("Reset password dibatalkan.");
            return Command::SUCCESS;
        }

        // Reset password
        $user->password = Hash::make($password);
        $user->save();

        $this->newLine();
        $this->info("✅ Password berhasil di-reset!");
        $this->newLine();
        $this->line("📋 Detail Login:");
        $this->line("  Email: {$user->email}");
        $this->line("  Password: {$password}");
        $this->newLine();
        $this->comment("💡 Sarankan user untuk mengubah password setelah login!");

        return Command::SUCCESS;
    }
}
