<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LoginUrlController extends Controller
{
    public function index()
    {
        $currentUrl = Setting::getValue('admin_login_url', 'admin-login');
        return view('admin.settings.login-url', compact('currentUrl'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'admin_login_url' => [
                'required',
                'string',
                'min:5',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'register', 'login', 'logout', 'password', 'verify-email', 'confirm-password', 'forgot-password', 'reset-password'];
                    if (in_array($value, $reserved)) {
                        $fail('URL tersebut tidak boleh digunakan karena merupakan kata yang dicadangkan.');
                    }
                },
            ],
        ], [
            'admin_login_url.required' => 'URL login wajib diisi.',
            'admin_login_url.min' => 'URL login minimal 5 karakter.',
            'admin_login_url.max' => 'URL login maksimal 100 karakter.',
            'admin_login_url.regex' => 'URL hanya boleh mengandung huruf kecil, angka, dan tanda hubung (-). Tidak boleh diawali atau diakhiri dengan tanda hubung.',
        ]);

        Setting::setValue('admin_login_url', $request->admin_login_url, 'text', 'security');

        // Clear route cache so new URL takes effect
        try {
            Artisan::call('route:clear');
        } catch (\Exception $e) {
            // Ignore if route cache doesn't exist
        }

        return redirect()->route('admin.login-url.index')
            ->with('success', 'URL halaman login berhasil diperbarui! URL baru: /' . $request->admin_login_url);
    }
}
