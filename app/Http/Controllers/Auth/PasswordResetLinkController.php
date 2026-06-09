<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password', [
            'siteName' => Setting::getValue('site_name', 'APJIKOM'),
            'siteLogo' => Setting::getValue('site_logo'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $status = Password::sendResetLink($request->only('email'));
        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
            Log::error('Password reset mail failed: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Gagal mengirim email. Konfigurasi SMTP belum benar. Hubungi administrator.']);
        } catch (\Exception $e) {
            Log::error('Password reset failed: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Terjadi kesalahan saat mengirim email. Silakan coba lagi nanti.']);
        }

        $messages = [
            Password::RESET_LINK_SENT => 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.',
            Password::INVALID_USER    => 'Email tidak ditemukan dalam sistem kami.',
            'passwords.throttled'     => 'Terlalu banyak percobaan. Silakan tunggu beberapa menit sebelum mencoba lagi.',
        ];

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', $messages[Password::RESET_LINK_SENT])
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => $messages[$status] ?? __($status)]);
    }
}
