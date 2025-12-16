<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Jika user adalah admin atau tidak punya member profile, redirect ke admin
        if ($user->role === 'admin' || !$user->member) {
            return redirect()->route('admin.dashboard');
        }
        
        $member = $user->member;
        return view('member.dashboard', compact('member'));
    }
}
