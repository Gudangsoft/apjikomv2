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
        $paymentSettings = [
            'registration_mode' => Setting::get('registration_mode') ?? 'paid',
            'require_payment_proof' => Setting::get('require_payment_proof') ?? '1',
            'biaya_individu' => Setting::get('biaya_individu') ?? '250000',
            'biaya_prodi' => Setting::get('biaya_prodi') ?? '750000',
            'bank_name' => Setting::get('bank_name') ?? 'BNI 46 Cabang Perintis Kemerdekaan',
            'account_number' => Setting::get('account_number') ?? '1119995552',
            'account_name' => Setting::get('account_name') ?? 'APTIKOM',
            'contact_email' => Setting::get('contact_email') ?? 'admin@apjikom.or.id',
            'contact_phone' => Setting::get('contact_phone') ?? '081234567890',
            'contact_whatsapp' => Setting::get('contact_whatsapp') ?? '081234567890',
        ];
        
        return view('registration.create', compact('paymentSettings'));
    }

    public function store(Request $request)
    {
        // Get settings
        $registrationMode = Setting::get('registration_mode') ?? 'paid';
        $requirePaymentProof = Setting::get('require_payment_proof') ?? '1';
        
        $rules = [
            'type' => 'required|in:individu,prodi',
            'email' => 'required|email|unique:registrations,email',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
        ];
        
        // Payment proof conditional based on settings
        // Jika mode free, bukti pembayaran tidak wajib
        // Jika mode paid, bukti pembayaran wajib jika require_payment_proof = 1
        if ($registrationMode === 'free') {
            $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,bmp,pdf|max:5120';
        } elseif ($registrationMode === 'paid' && $requirePaymentProof == '1') {
            $rules['payment_proof'] = 'required|file|mimes:jpg,jpeg,png,bmp,pdf|max:5120';
        } else {
            $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,bmp,pdf|max:5120';
        }

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
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.max' => 'Ukuran file maksimal 5MB.',
            'phone.max' => 'Nomor handphone maksimal 13 karakter.',
        ];

        $validated = $request->validate($rules, $customMessages);

        // Upload bukti pembayaran jika ada
        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('registrations/payments', 'public');
        }

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
