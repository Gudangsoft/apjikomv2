<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.email-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|in:smtp,sendmail,mailgun,ses,postmark,log',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl,null',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
            'auto_email_enabled' => 'required|boolean',
            'email_registration_approved' => 'required|boolean',
            'email_registration_rejected' => 'required|boolean',
            'email_password_reset' => 'required|boolean',
            'email_card_generated' => 'required|boolean',
        ]);

        // Save all email settings
        foreach ($validated as $key => $value) {
            $type = 'text';
            
            if (in_array($key, ['mail_port'])) {
                $type = 'number';
            } elseif (in_array($key, ['auto_email_enabled', 'email_registration_approved', 'email_registration_rejected', 'email_password_reset', 'email_card_generated'])) {
                $type = 'boolean';
            }

            Setting::setValue($key, $value, $type, 'email');
        }

        // Update .env file (optional - for immediate effect)
        $this->updateEnvFile([
            'MAIL_MAILER' => $validated['mail_mailer'],
            'MAIL_HOST' => $validated['mail_host'] ?? '',
            'MAIL_PORT' => $validated['mail_port'] ?? '',
            'MAIL_USERNAME' => $validated['mail_username'] ?? '',
            'MAIL_PASSWORD' => $validated['mail_password'] ?? '',
            'MAIL_ENCRYPTION' => $validated['mail_encryption'] ?? 'null',
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => '"' . $validated['mail_from_name'] . '"',
        ]);

        return redirect()->route('admin.email-settings.index')
            ->with('success', 'Pengaturan Email berhasil diperbarui!');
    }

    /**
     * Update .env file with new values
     */
    private function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            return;
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            // Escape special characters in value
            $value = str_replace('"', '\\"', $value);
            
            // Check if key exists in .env
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                // Add new key at the end
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Test email connection
     */
    public function testConnection(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            // Update mail config from database
            $this->updateMailConfig();

            \Mail::raw('Halo! Ini adalah test email dari sistem APJIKOM. Jika Anda menerima email ini, berarti konfigurasi email sudah berhasil! ✅', function($message) use ($request) {
                $message->to($request->test_email)
                        ->subject('Test Email - ' . config('app.name'));
            });

            return response()->json([
                'success' => true,
                'message' => '✅ Email test berhasil dikirim ke ' . $request->test_email . '! Silakan cek inbox Anda.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update mail config from database settings
     */
    private function updateMailConfig()
    {
        $settings = Setting::where('group', 'email')->pluck('value', 'key');

        config([
            'mail.default' => $settings['mail_mailer'] ?? 'smtp',
            'mail.mailers.smtp.host' => $settings['mail_host'] ?? '',
            'mail.mailers.smtp.port' => $settings['mail_port'] ?? 465,
            'mail.mailers.smtp.username' => $settings['mail_username'] ?? '',
            'mail.mailers.smtp.password' => $settings['mail_password'] ?? '',
            'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'ssl',
            'mail.from.address' => $settings['mail_from_address'] ?? '',
            'mail.from.name' => $settings['mail_from_name'] ?? 'APJIKOM',
        ]);

        // Purge mailer instance to force recreation with new config
        \Mail::purge();
    }
}
