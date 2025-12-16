<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.about-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'about_tag' => 'nullable|string|max:50',
            'section_label_about' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_stat1_number' => 'nullable|string|max:10',
            'about_stat1_label' => 'nullable|string|max:50',
            'about_stat2_number' => 'nullable|string|max:10',
            'about_stat2_label' => 'nullable|string|max:50',
            'about_feature1_title' => 'nullable|string|max:100',
            'about_feature1_desc' => 'nullable|string|max:500',
            'about_feature2_title' => 'nullable|string|max:100',
            'about_feature2_desc' => 'nullable|string|max:500',
            'about_feature3_title' => 'nullable|string|max:100',
            'about_feature3_desc' => 'nullable|string|max:500',
            'about_cta_label' => 'nullable|string|max:50',
            'about_cta_link' => 'nullable|string|max:255',
        ]);

        // Handle about image upload
        if ($request->hasFile('about_image')) {
            $request->validate([
                'about_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $aboutImagePath = $request->file('about_image')->store('about', 'public');
            
            // Delete old about image
            $oldAboutImage = Setting::get('about_image');
            if ($oldAboutImage && Storage::disk('public')->exists($oldAboutImage)) {
                Storage::disk('public')->delete($oldAboutImage);
            }
            
            Setting::set('about_image', $aboutImagePath, 'image', 'about');
        }

        // Save all text settings
        foreach ($validated as $key => $value) {
            $type = 'text';
            
            if ($key === 'about_description') {
                $type = 'textarea';
            }

            Setting::set($key, $value, $type, 'about');
        }

        return redirect()->route('admin.about-settings.index')
            ->with('success', 'Pengaturan Section Tentang berhasil diperbarui!');
    }
}
