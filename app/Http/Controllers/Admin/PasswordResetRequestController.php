<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetRequestController extends Controller
{
    /**
     * Display a listing of password reset requests
     */
    public function index(Request $request)
    {
        $query = PasswordResetRequest::with(['user', 'approvedBy'])->latest();
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $requests = $query->paginate(20);
        
        return view('admin.password-reset-requests.index', compact('requests'));
    }
    
    /**
     * Approve password reset request
     */
    public function approve(Request $httpRequest, $request)
    {
        $passwordResetRequest = PasswordResetRequest::findOrFail($request);
        
        if ($passwordResetRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }
        
        $user = $passwordResetRequest->user;
        $defaultPassword = '@apjikom.oke';
        
        // Reset password to default
        $user->password = Hash::make($defaultPassword);
        $user->save();
        
        // Update request status
        $passwordResetRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        // Create notification for member
        Notification::create([
            'user_id' => $user->id,
            'type' => 'password_reset_approved',
            'title' => 'Password Anda Telah Direset',
            'message' => "Password Anda telah direset oleh admin. Password default: {$defaultPassword}. Segera ubah password Anda untuk keamanan akun.",
            'icon' => 'check-circle',
            'color' => 'green',
            'action_url' => route('member.profile'),
            'action_text' => 'Ubah Password',
        ]);
        
        return back()->with('success', "Password {$user->name} berhasil direset ke {$defaultPassword}");
    }
    
    /**
     * Reject password reset request
     */
    public function reject(Request $httpRequest, $request)
    {
        $passwordResetRequest = PasswordResetRequest::findOrFail($request);
        
        if ($passwordResetRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }
        
        $user = $passwordResetRequest->user;
        
        // Update request status
        $passwordResetRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        // Create notification for member
        Notification::create([
            'user_id' => $user->id,
            'type' => 'password_reset_rejected',
            'title' => 'Permintaan Reset Password Ditolak',
            'message' => 'Permintaan reset password Anda ditolak oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.',
            'icon' => 'x-circle',
            'color' => 'red',
            'action_url' => route('member.profile'),
            'action_text' => 'Lihat Profil',
        ]);
        
        return back()->with('success', "Permintaan reset password dari {$user->name} telah ditolak.");
    }
}
