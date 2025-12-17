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
            'about_history' => 'required|string',
            'about_founded_year' => 'required|string|max:4',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'textarea', 'about');
        }

        return redirect()->route('admin.about-page.index')
            ->with('success', 'Halaman Tentang Kami berhasil diperbarui!');
    }
}
