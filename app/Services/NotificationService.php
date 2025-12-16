<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public static function create(User $user, string $type, string $title, string $message, array $options = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $options['icon'] ?? null,
            'color' => $options['color'] ?? 'blue',
            'action_url' => $options['action_url'] ?? null,
            'action_text' => $options['action_text'] ?? null,
        ]);
    }

    /**
     * Notify when card is ready
     */
    public static function cardReady(User $user)
    {
        return self::create(
            $user,
            'card_ready',
            'Kartu Anggota Anda Sudah Siap!',
            'Kartu Anggota (KTA) Anda telah berhasil dibuat dan siap diunduh.',
            [
                'icon' => 'check-circle',
                'color' => 'green',
                'action_url' => route('member.card'),
                'action_text' => 'Lihat Kartu'
            ]
        );
    }

    /**
     * Notify when card update is ready
     */
    public static function cardUpdateReady(User $user)
    {
        return self::create(
            $user,
            'card_update_ready',
            'Kartu Anggota Berhasil Diperbarui!',
            'Kartu Anggota (KTA) Anda telah diperbarui dengan data terbaru.',
            [
                'icon' => 'refresh',
                'color' => 'green',
                'action_url' => route('member.card'),
                'action_text' => 'Lihat Kartu'
            ]
        );
    }

    /**
     * Notify when profile needs completion
     */
    public static function profileIncomplete(User $user)
    {
        return self::create(
            $user,
            'profile_incomplete',
            'Lengkapi Profil Anda',
            'Silakan lengkapi data profil Anda untuk dapat mengajukan Kartu Anggota.',
            [
                'icon' => 'exclamation',
                'color' => 'yellow',
                'action_url' => route('member.profile'),
                'action_text' => 'Lengkapi Profil'
            ]
        );
    }

    /**
     * Notify about new event
     */
    public static function newEvent(User $user, $event)
    {
        return self::create(
            $user,
            'new_event',
            'Kegiatan Baru: ' . $event->title,
            'Ada kegiatan baru yang mungkin menarik untuk Anda.',
            [
                'icon' => 'calendar',
                'color' => 'blue',
                'action_url' => route('events.show', $event),
                'action_text' => 'Lihat Detail'
            ]
        );
    }

    /**
     * Notify about new journal
     */
    public static function newJournal(User $user, $journal)
    {
        return self::create(
            $user,
            'new_journal',
            'Jurnal Baru: ' . $journal->title,
            'Jurnal ilmiah baru telah dipublikasikan.',
            [
                'icon' => 'book',
                'color' => 'purple',
                'action_url' => route('journals.show', $journal),
                'action_text' => 'Baca Jurnal'
            ]
        );
    }

    /**
     * Notify when member is verified
     */
    public static function memberVerified(User $user)
    {
        return self::create(
            $user,
            'member_verified',
            'Akun Anda Telah Diverifikasi!',
            'Selamat! Akun keanggotaan Anda telah diverifikasi oleh admin. Anda sekarang memiliki status verified member.',
            [
                'icon' => 'badge-check',
                'color' => 'green',
                'action_url' => route('member.profile'),
                'action_text' => 'Lihat Profil'
            ]
        );
    }

    /**
     * Get unread count for user
     */
    public static function getUnreadCount(User $user)
    {
        return Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Mark all as read for user
     */
    public static function markAllAsRead(User $user)
    {
        return Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Notify ALL admins about member activities
     */
    public static function notifyAdmins(string $type, string $title, string $message, array $options = [])
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            self::create($admin, $type, $title, $message, $options);
        }
    }

    /**
     * Notify admins when member requests card
     */
    public static function memberRequestedCard(User $member)
    {
        $memberId = optional($member->member)->id;
        return self::notifyAdmins(
            'member_card_request',
            'Permintaan Kartu Anggota Baru',
            $member->name . ' telah mengajukan permintaan untuk mendapatkan Kartu Anggota (KTA).',
            [
                'icon' => 'id-card',
                'color' => 'blue',
                'action_url' => $memberId ? route('admin.members.show', $memberId) : route('admin.members.index'),
                'action_text' => 'Lihat Detail Member'
            ]
        );
    }

    /**
     * Notify admins when member requests card update
     */
    public static function memberRequestedCardUpdate(User $member)
    {
        $memberId = optional($member->member)->id;
        return self::notifyAdmins(
            'member_card_update_request',
            'Permintaan Update Kartu Anggota',
            $member->name . ' telah mengajukan permintaan untuk memperbarui Kartu Anggota (KTA).',
            [
                'icon' => 'refresh',
                'color' => 'orange',
                'action_url' => $memberId ? route('admin.members.show', $memberId) : route('admin.members.index'),
                'action_text' => 'Lihat Detail Member'
            ]
        );
    }

    /**
     * Notify admins when member updates profile
     */
    public static function memberUpdatedProfile(User $member)
    {
        $memberId = optional($member->member)->id;
        return self::notifyAdmins(
            'member_profile_update',
            'Member Memperbarui Profil',
            $member->name . ' telah memperbarui data profilnya.',
            [
                'icon' => 'user',
                'color' => 'blue',
                'action_url' => $memberId ? route('admin.members.show', $memberId) : route('admin.members.index'),
                'action_text' => 'Lihat Profil'
            ]
        );
    }

    /**
     * Notify admins when member requests password reset
     */
    public static function memberRequestedPasswordReset(User $member)
    {
        return self::notifyAdmins(
            'password_reset_request',
            'Permintaan Reset Password',
            $member->name . ' telah mengajukan permintaan reset password.',
            [
                'icon' => 'key',
                'color' => 'yellow',
                'action_url' => route('admin.password-reset-requests.index'),
                'action_text' => 'Lihat Permintaan'
            ]
        );
    }

    /**
     * Notify admins when new member registers
     */
    public static function newMemberRegistration($registration)
    {
        return self::notifyAdmins(
            'new_registration',
            'Pendaftaran Anggota Baru',
            $registration->full_name . ' telah mendaftar sebagai anggota baru. Status: ' . ucfirst($registration->status),
            [
                'icon' => 'user-plus',
                'color' => 'green',
                'action_url' => route('admin.registrations.show', $registration->id),
                'action_text' => 'Lihat Pendaftaran'
            ]
        );
    }

    /**
     * Notify admins when member uploads testimonial
     */
    public static function memberAddedTestimonial(User $member, $testimonial)
    {
        return self::notifyAdmins(
            'member_testimonial',
            'Testimoni Baru dari Member',
            $member->name . ' telah mengirimkan testimoni baru.',
            [
                'icon' => 'message',
                'color' => 'purple',
                'action_url' => route('admin.testimonials.index'),
                'action_text' => 'Lihat Testimoni'
            ]
        );
    }
}
