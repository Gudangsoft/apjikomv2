<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a plain WhatsApp message through the configured gateway
     * (same WhaCenter gateway used by the WA Blaster feature —
     * https://app.whacenter.com/api/send, authenticated by device_id).
     *
     * Silently returns false (and logs) when the gateway isn't configured or
     * the send fails — callers should treat this as best-effort, the same
     * way the existing email notifications are wrapped in try/catch.
     */
    public static function send(?string $phone, string $message): bool
    {
        $phone = trim((string) $phone);
        if ($phone === '' || trim($message) === '') {
            return false;
        }

        $url    = Setting::getValue('wa_gateway_url', 'https://app.whacenter.com/api/send');
        $device = Setting::getValue('wa_gateway_device', '');

        // WhaCenter's device_id IS the credential — tidak ada token/Authorization header.
        if (empty($device)) {
            Log::info('WhatsAppService: Device ID WhaCenter belum diatur (Admin > WA Blaster), pesan tidak dikirim.', [
                'phone' => $phone,
            ]);
            return false;
        }

        try {
            $payload = ['device_id' => $device, 'number' => wa_number($phone), 'message' => $message];

            $response = Http::asForm()
                ->timeout(15)
                ->post($url, $payload);

            if ($response->successful() && $response->json('status') !== false) {
                return true;
            }

            Log::warning('WhatsAppService: gagal mengirim pesan WA.', [
                'phone'    => $phone,
                'response' => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::warning('WhatsAppService: exception saat mengirim pesan WA: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify a member via WhatsApp that their password was reset by admin,
     * including the email they log in with and the new password.
     * Returns false (no-op) when the member has no phone number on file.
     */
    public static function sendPasswordReset(User $user, string $newPassword): bool
    {
        $phone = $user->member->phone ?? null;
        if (empty($phone)) {
            return false;
        }

        $siteName = Setting::getValue('site_name', 'Website Asosiasi');
        $loginUrl = route('member.login');

        $message = "Halo {$user->name},\n\n"
            . "Password akun {$siteName} Anda telah *direset oleh admin*.\n\n"
            . "📧 Email (login): {$user->email}\n"
            . "🔑 Password baru: {$newPassword}\n\n"
            . "Segera login dan ganti password Anda demi keamanan akun.\n"
            . "Login: {$loginUrl}";

        return self::send($phone, $message);
    }
}
