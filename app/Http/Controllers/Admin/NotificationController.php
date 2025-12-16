<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for admin.
     */
    public function index(Request $request)
    {
        // Admin hanya melihat notifikasi untuk admin (bukan notifikasi member)
        // Dan hanya notifikasi yang berkaitan dengan request/permintaan
        $adminIds = User::where('role', 'admin')->pluck('id');
        
        $requestTypes = [
            'member_card_request',
            'member_card_update_request',
            'password_reset_request',
            'new_registration',
        ];
        
        $notifications = Notification::with('user')
            ->whereIn('user_id', $adminIds)
            ->whereIn('type', $requestTypes)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // If AJAX request, return JSON
        if ($request->ajax() || $request->has('ajax')) {
            $recentNotifications = Notification::with('user')
                ->whereIn('user_id', $adminIds)
                ->whereIn('type', $requestTypes)
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
                        'user_name' => $notification->user->name ?? 'System',
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
        // Admin hanya melihat notifikasi untuk admin yang belum dibaca
        // Dan hanya notifikasi yang berkaitan dengan request/permintaan
        $adminIds = User::where('role', 'admin')->pluck('id');
        
        $requestTypes = [
            'member_card_request',
            'member_card_update_request',
            'password_reset_request',
            'new_registration',
        ];
        
        $count = Notification::whereIn('user_id', $adminIds)
            ->whereIn('type', $requestTypes)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $adminIds = User::where('role', 'admin')->pluck('id');
        Notification::whereIn('user_id', $adminIds)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }
}
