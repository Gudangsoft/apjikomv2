<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /** Pesan berhasil dikirim. */
    public const SENT = 'sent';
    /** Nomor HP tujuan kosong (mis. member belum isi nomor telepon di profil). */
    public const NO_PHONE = 'no_phone';
    /** Gateway WhaCenter belum dikonfigurasi (Device ID kosong). */
    public const NOT_CONFIGURED = 'not_configured';
    /** Sudah dicoba kirim tapi gateway menolak / exception. */
    public const FAILED = 'failed';

    /**
     * Send a plain WhatsApp message through the configured gateway
     * (same WhaCenter gateway used by the WA Blaster feature —
     * https://app.whacenter.com/api/send, authenticated by device_id).
     *
     * Best-effort — never throws, so callers (e.g. password reset) never fail
     * just because WA didn't go out. Returns one of the class const result
     * codes so the caller can show the admin *why* it didn't send, instead of
     * staying silent about it.
     */
    public static function send(?string $phone, string $message): string
    {
        $phone = trim((string) $phone);
        if ($phone === '' || trim($message) === '') {
            return self::NO_PHONE;
        }

        $url    = Setting::getValue('wa_gateway_url', 'https://app.whacenter.com/api/send');
        $device = Setting::getValue('wa_gateway_device', '');

        // WhaCenter's device_id IS the credential — tidak ada token/Authorization header.
        if (empty($device)) {
            Log::info('WhatsAppService: Device ID WhaCenter belum diatur (Admin > WA Blaster), pesan tidak dikirim.', [
                'phone' => $phone,
            ]);
            return self::NOT_CONFIGURED;
        }

        try {
            $payload = ['device_id' => $device, 'number' => wa_number($phone), 'message' => $message];

            $response = Http::asForm()
                ->timeout(15)
                ->post($url, $payload);

            if ($response->successful() && $response->json('status') !== false) {
                return self::SENT;
            }

            Log::warning('WhatsAppService: gagal mengirim pesan WA.', [
                'phone'    => $phone,
                'response' => $response->body(),
            ]);
            return self::FAILED;
        } catch (\Throwable $e) {
            Log::warning('WhatsAppService: exception saat mengirim pesan WA: ' . $e->getMessage());
            return self::FAILED;
        }
    }

    /**
     * Notify a member via WhatsApp that their password was reset by admin,
     * including the email they log in with and the new password.
     * Returns a result code — see the class constants — so the caller can
     * tell the admin why it wasn't sent instead of failing silently.
     */
    public static function sendPasswordReset(User $user, string $newPassword): string
    {
        $phone = $user->member->phone ?? null;
        if (empty($phone)) {
            return self::NO_PHONE;
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

    /**
     * Human-readable (Indonesian) note for a send() / sendPasswordReset()
     * result code, meant to be appended to an admin-facing flash message.
     */
    public static function resultNote(string $result): string
    {
        return match ($result) {
            self::SENT => ' Notifikasi WhatsApp telah dikirim.',
            self::NO_PHONE => ' WhatsApp tidak terkirim: member tidak punya nomor HP tersimpan.',
            self::NOT_CONFIGURED => ' WhatsApp tidak terkirim: Device ID gateway WhatsApp belum diatur (Admin > WA Blaster).',
            self::FAILED => ' WhatsApp gagal terkirim (gateway menolak/error) — cek log aplikasi.',
            default => '',
        };
    }
}
