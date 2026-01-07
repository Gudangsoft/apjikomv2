<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Test email configuration by sending a test email';

    public function handle()
    {
        $recipient = $this->argument('email');
        
        $this->info("🚀 Mengirim test email ke: {$recipient}");
        $this->newLine();

        try {
            Mail::raw('Halo! Ini adalah test email dari sistem APJIKOM. Jika Anda menerima email ini, berarti konfigurasi email sudah berhasil! ✅', function ($message) use ($recipient) {
                $message->to($recipient)
                        ->subject('Test Email - APJIKOM System');
            });

            $this->info('✅ Email berhasil dikirim!');
            $this->newLine();
            $this->line('Konfigurasi Email:');
            $this->line('  SMTP Host: ' . config('mail.mailers.smtp.host'));
            $this->line('  Port: ' . config('mail.mailers.smtp.port'));
            $this->line('  Username: ' . config('mail.mailers.smtp.username'));
            $this->line('  Encryption: ' . config('mail.mailers.smtp.encryption'));
            $this->line('  From: ' . config('mail.from.address'));
            $this->newLine();
            $this->info('✨ Silakan cek inbox email Anda!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email!');
            $this->newLine();
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Tips troubleshooting:');
            $this->line('  1. Pastikan SMTP credentials benar');
            $this->line('  2. Cek apakah port 465 tidak diblokir firewall');
            $this->line('  3. Verifikasi SSL encryption supported');
            $this->line('  4. Cek log di storage/logs/laravel.log');
            
            return Command::FAILURE;
        }
    }
}
