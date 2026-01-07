<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $siteName = Setting::getValue('site_name') ?? 'APJIKOM';
        $siteLogo = Setting::getValue('site_logo');
        
        // Generate simple math CAPTCHA
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_num1' => $num1, 'captcha_num2' => $num2, 'captcha_answer' => $num1 + $num2]);
        
        return view('auth.login', compact('siteName', 'siteLogo'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect admin langsung ke admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
