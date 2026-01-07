<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('member');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting current logged in user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang login!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
    
    /**
     * Reset password to default
     */
    public function resetPassword(string $id)
    {
        $user = User::findOrFail($id);
        
        $defaultPassword = '@apjikom.oke';
        $user->password = Hash::make($defaultPassword);
        $user->save();
        
        // Send email notification
        $this->sendPasswordResetEmail($user, $defaultPassword);
        
        // Create in-app notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'password_reset_by_admin',
            'title' => 'Password Anda Telah Direset oleh Admin',
            'message' => "Password Anda telah direset oleh admin. Password default: {$defaultPassword}. Segera ubah password Anda untuk keamanan akun.",
            'icon' => 'key',
            'color' => 'blue',
            'action_url' => route('member.profile'),
            'action_text' => 'Ubah Password',
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', "Password berhasil direset ke {$defaultPassword}. Email notifikasi telah dikirim.");
    }
    
    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);
        
        // Prevent deleting current logged in user
        $userIds = array_filter($request->user_ids, function($id) {
            return $id != auth()->id();
        });
        
        if (empty($userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang login!');
        }
        
        User::whereIn('id', $userIds)->delete();
        
        $count = count($userIds);
        return redirect()->route('admin.users.index')
            ->with('success', "{$count} user berhasil dihapus!");
    }
    
    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail($user, $newPassword)
    {
        try {
            // Update mail config from database
            $this->updateMailConfig();
            
            \Mail::send('emails.password-reset', [
                'user' => $user,
                'newPassword' => $newPassword,
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Password Anda Telah Direset - APJIKOM');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
        }
    }
    
    /**
     * Update mail config from database settings
     */
    private function updateMailConfig()
    {
        $settings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
        
        if ($settings->isEmpty()) {
            return;
        }

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
