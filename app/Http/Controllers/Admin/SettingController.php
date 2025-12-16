<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'satisfaction_rate' => 'required|numeric|min:0|max:100',
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'contact_address' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'google_analytics' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            $logoPath = $request->file('site_logo')->store('settings', 'public');
            
            // Delete old logo
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            Setting::set('site_logo', $logoPath, 'image', 'general');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $request->validate([
                'site_favicon' => 'image|mimes:png,ico|max:512',
            ]);

            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            
            // Delete old favicon
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            
            Setting::set('site_favicon', $faviconPath, 'image', 'general');
        }

        // Save all text settings
        foreach ($validated as $key => $value) {
            $group = 'general';
            
            if (str_starts_with($key, 'contact_')) {
                $group = 'contact';
            } elseif (in_array($key, ['facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url'])) {
                $group = 'social';
            } elseif (in_array($key, ['meta_keywords', 'meta_description', 'google_analytics'])) {
                $group = 'seo';
            } elseif ($key === 'satisfaction_rate') {
                $group = 'statistics';
            }

            $type = 'text';
            if (in_array($key, ['site_description', 'contact_address', 'meta_description', 'google_analytics'])) {
                $type = 'textarea';
            } elseif ($key === 'satisfaction_rate') {
                $type = 'number';
            } elseif ($key === 'contact_email') {
                $type = 'email';
            }

            Setting::set($key, $value, $type, $group);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
