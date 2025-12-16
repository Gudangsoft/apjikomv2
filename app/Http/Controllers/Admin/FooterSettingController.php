<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.footer-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Menu Column 1
            'footer_menu1_title' => 'nullable|string|max:50',
            'footer_menu1_item1_label' => 'nullable|string|max:100',
            'footer_menu1_item1_url' => 'nullable|string|max:255',
            'footer_menu1_item2_label' => 'nullable|string|max:100',
            'footer_menu1_item2_url' => 'nullable|string|max:255',
            'footer_menu1_item3_label' => 'nullable|string|max:100',
            'footer_menu1_item3_url' => 'nullable|string|max:255',
            'footer_menu1_item4_label' => 'nullable|string|max:100',
            'footer_menu1_item4_url' => 'nullable|string|max:255',
            'footer_menu1_item5_label' => 'nullable|string|max:100',
            'footer_menu1_item5_url' => 'nullable|string|max:255',
            
            // Menu Column 2
            'footer_menu2_title' => 'nullable|string|max:50',
            'footer_menu2_item1_label' => 'nullable|string|max:100',
            'footer_menu2_item1_url' => 'nullable|string|max:255',
            'footer_menu2_item2_label' => 'nullable|string|max:100',
            'footer_menu2_item2_url' => 'nullable|string|max:255',
            'footer_menu2_item3_label' => 'nullable|string|max:100',
            'footer_menu2_item3_url' => 'nullable|string|max:255',
            'footer_menu2_item4_label' => 'nullable|string|max:100',
            'footer_menu2_item4_url' => 'nullable|string|max:255',
            'footer_menu2_item5_label' => 'nullable|string|max:100',
            'footer_menu2_item5_url' => 'nullable|string|max:255',
            
            // Footer Copyright
            'footer_copyright_text' => 'nullable|string|max:255',
        ]);

        // Save all footer settings
        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'text', 'footer');
        }

        return redirect()->route('admin.footer-settings.index')
            ->with('success', 'Pengaturan Menu Footer berhasil diperbarui!');
    }
}
