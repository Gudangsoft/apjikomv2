<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        return view('admin.about-page.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'about_page_title' => 'required|string|max:255',
            'about_page_subtitle' => 'required|string|max:255',
            'about_vision' => 'required|string',
            'about_mission' => 'required|string',
            'about_history_title' => 'required|string|max:255',
            'about_history' => 'required|string',
            'about_founded_year' => 'required|string|max:4',
            'about_stat1_label' => 'nullable|string|max:100',
            'about_stat2_label' => 'nullable|string|max:100',
            'about_stat3_label' => 'nullable|string|max:100',
            'about_structure_title' => 'required|string|max:255',
            'about_cta_title' => 'required|string|max:255',
            'about_cta_subtitle' => 'required|string|max:500',
            'about_cta_button1_text' => 'nullable|string|max:100',
            'about_cta_button2_text' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::setValue($key, $value, 'text', 'about');
            }
        }

        return redirect()->route('admin.about-page.index')
            ->with('success', 'Halaman Tentang Kami berhasil diperbarui!');
    }
}
