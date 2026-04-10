<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function create()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        session(['captcha_answer' => $a + $b, 'captcha_question' => "$a + $b"]);

        return view('registration.create');
    }

    public function store(Request $request)
    {
        // Verify math CAPTCHA
        $captchaInput = (int) $request->input('captcha_answer');
        $captchaExpected = (int) session('captcha_answer');

        if ($captchaInput !== $captchaExpected || $captchaExpected === 0) {
            return back()->withErrors(['captcha_answer' => 'Jawaban CAPTCHA salah. Silakan coba lagi.'])->withInput();
        }

        // Clear captcha session after use
        session()->forget(['captcha_answer', 'captcha_question']);

        $rules = [
            'type' => 'required|in:individu,prodi',
            'email' => 'required|email|unique:registrations,email',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
        ];

        // Validasi tambahan untuk tipe prodi
        if ($request->type === 'prodi') {
            $rules['institution'] = 'required|string|max:255';
            $rules['study_program'] = 'required|string|max:255';
            $rules['accreditation'] = 'required|string|max:50';
            $rules['accreditation_valid_until'] = 'required|date';
            $rules['province'] = 'required|string|max:100';
            $rules['authorization_letter'] = 'nullable|file|mimes:jpg,jpeg,png,bmp,pdf,doc,docx|max:5120';
        }

        $customMessages = [
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone.max' => 'Nomor handphone maksimal 13 karakter.',
        ];

        $validated = $request->validate($rules, $customMessages);

        // Upload surat kuasa jika ada
        if ($request->hasFile('authorization_letter')) {
            $validated['authorization_letter'] = $request->file('authorization_letter')->store('registrations/letters', 'public');
        }

        // Hash password before saving
        $validated['password'] = bcrypt($validated['password']);

        $registration = Registration::create($validated);

        // Notify admins about new registration
        \App\Services\NotificationService::newMemberRegistration($registration);

        return redirect()->route('registration.create')
            ->with('success', 'Pendaftaran berhasil! Silahkan hubungi admin untuk proses approve akun.');
    }
}
