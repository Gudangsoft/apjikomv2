<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public function __construct(public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $siteName = Setting::getValue('site_name', config('app.name'));
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject("Reset Password - {$siteName}")
            ->greeting("Halo, {$notifiable->name}!")
            ->line("Kami menerima permintaan untuk mereset password akun Anda di **{$siteName}**.")
            ->action('Reset Password Sekarang', $resetUrl)
            ->line('Link ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini — password Anda tidak akan berubah.')
            ->salutation("Salam,\n{$siteName}");
    }
}
