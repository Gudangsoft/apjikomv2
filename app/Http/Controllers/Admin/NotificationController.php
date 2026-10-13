<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Tipe notifikasi yang relevan untuk admin (request/permintaan dari member).
    private const REQUEST_TYPES = [
        'member_card_request',
        'member_card_update_request',
        'physical_card_request',
        'password_reset_request',
        'new_registration',
    ];

    /**
     * Display a listing of notifications for admin.
     */
    public function index(Request $request)
    {
        // Tiap event (mis. 1 member request update KTA) dibuat satu baris Notification
        // PER admin, supaya tiap admin punya status baca sendiri-sendiri. Jadi daftar ini
        // HARUS di-scope ke admin yang sedang login saja — kalau di-pool ke semua admin
        // ("whereIn user_id $adminIds"), satu event yang sama akan tampil berkali-kali
        // (satu baris untuk tiap admin lain yang juga menerimanya).
        $adminId = Auth::id();

        $notifications = Notification::where('user_id', $adminId)
            ->whereIn('type', self::REQUEST_TYPES)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // If AJAX request, return JSON
        if ($request->ajax() || $request->has('ajax')) {
            $recentNotifications = Notification::where('user_id', $adminId)
                ->whereIn('type', self::REQUEST_TYPES)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon,
                        'color' => $notification->color,
                        'action_url' => $notification->action_url,
                        'action_text' => $notification->action_text,
                        'read_at' => $notification->read_at,
                        'time_ago' => $notification->created_at->diffForHumans(),
                    ];
                });

            return response()->json(['notifications' => $recentNotifications]);
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get unread notification count for admin.
     */
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->whereIn('type', self::REQUEST_TYPES)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }
}
