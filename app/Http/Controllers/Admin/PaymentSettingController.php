<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.payment-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'registration_mode' => 'required|in:paid,free',
            'require_payment_proof' => 'required|boolean',
            'biaya_individu' => 'nullable|numeric|min:0',
            'biaya_prodi' => 'nullable|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'contact_whatsapp' => 'required|string|max:20',
        ]);

        // Save all payment settings
        foreach ($validated as $key => $value) {
            $type = 'text';
            
            if (in_array($key, ['biaya_individu', 'biaya_prodi'])) {
                $type = 'number';
            } elseif ($key === 'require_payment_proof') {
                $type = 'boolean';
            }

            Setting::set($key, $value, $type, 'payment');
        }

        return redirect()->route('admin.payment-settings.index')
            ->with('success', 'Pengaturan Pembayaran & Keanggotaan berhasil diperbarui!');
    }
}
