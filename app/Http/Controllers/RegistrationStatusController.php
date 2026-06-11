<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationStatusController extends Controller
{
    public function index()
    {
        return view('registration-status');
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $email = strtolower(trim($request->email));

        $registration = Registration::where('email', $email)
            ->latest()
            ->first();

        $member = null;
        if ($registration && $registration->status === 'approved') {
            $user = User::where('email', $email)->first();
            if ($user) {
                $member = Member::where('user_id', $user->id)->first();
            }
        }

        return view('registration-status', compact('registration', 'member', 'email'));
    }
}
