<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public static array $presets = [
        'purple' => [
            'name'    => 'Purple (Default)',
            'emoji'   => '🟣',
            'primary' => '#7C3AED',
            'dark'    => '#5B21B6',
            'light'   => '#8B5CF6',
            'pale'    => '#EDE9FE',
            'footer'  => '#3B0764',
        ],
        'blue' => [
            'name'    => 'Blue Ocean',
            'emoji'   => '🔵',
            'primary' => '#2563EB',
            'dark'    => '#1D4ED8',
            'light'   => '#3B82F6',
            'pale'    => '#EFF6FF',
            'footer'  => '#1E3A8A',
        ],
        'green' => [
            'name'    => 'Green Nature',
            'emoji'   => '🟢',
            'primary' => '#059669',
            'dark'    => '#047857',
            'light'   => '#10B981',
            'pale'    => '#ECFDF5',
            'footer'  => '#064E3B',
        ],
        'red' => [
            'name'    => 'Red Bold',
            'emoji'   => '🔴',
            'primary' => '#DC2626',
            'dark'    => '#B91C1C',
            'light'   => '#EF4444',
            'pale'    => '#FEF2F2',
            'footer'  => '#7F1D1D',
        ],
        'orange' => [
            'name'    => 'Orange Warm',
            'emoji'   => '🟠',
            'primary' => '#EA580C',
            'dark'    => '#C2410C',
            'light'   => '#F97316',
            'pale'    => '#FFF7ED',
            'footer'  => '#7C2D12',
        ],
        'teal' => [
            'name'    => 'Teal Modern',
            'emoji'   => '🩵',
            'primary' => '#0891B2',
            'dark'    => '#0E7490',
            'light'   => '#06B6D4',
            'pale'    => '#ECFEFF',
            'footer'  => '#164E63',
        ],
        'indigo' => [
            'name'    => 'Indigo Classic',
            'emoji'   => '💙',
            'primary' => '#4F46E5',
            'dark'    => '#4338CA',
            'light'   => '#6366F1',
            'pale'    => '#EEF2FF',
            'footer'  => '#1E1B4B',
        ],
        'rose' => [
            'name'    => 'Rose Pink',
            'emoji'   => '🌸',
            'primary' => '#E11D48',
            'dark'    => '#BE123C',
            'light'   => '#F43F5E',
            'pale'    => '#FFF1F2',
            'footer'  => '#881337',
        ],
        'amber' => [
            'name'    => 'Amber Gold',
            'emoji'   => '🟡',
            'primary' => '#D97706',
            'dark'    => '#B45309',
            'light'   => '#F59E0B',
            'pale'    => '#FFFBEB',
            'footer'  => '#78350F',
        ],
        'slate' => [
            'name'    => 'Dark Slate',
            'emoji'   => '⚫',
            'primary' => '#334155',
            'dark'    => '#1E293B',
            'light'   => '#475569',
            'pale'    => '#F1F5F9',
            'footer'  => '#0F172A',
        ],
    ];

    public function index()
    {
        $current = [
            'preset'  => Setting::getValue('theme_preset', 'purple'),
            'primary' => Setting::getValue('theme_primary', '#7C3AED'),
            'dark'    => Setting::getValue('theme_dark', '#5B21B6'),
            'light'   => Setting::getValue('theme_light', '#8B5CF6'),
            'pale'    => Setting::getValue('theme_pale', '#EDE9FE'),
            'footer'  => Setting::getValue('theme_footer', '#3B0764'),
        ];

        return view('admin.theme.index', [
            'presets' => self::$presets,
            'current' => $current,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'theme_preset'  => 'required|string',
            'theme_primary' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_dark'    => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_light'   => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_pale'    => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_footer'  => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ], [
            'theme_primary.regex' => 'Format warna tidak valid. Gunakan format HEX (#RRGGBB).',
            'theme_dark.regex'    => 'Format warna gelap tidak valid.',
            'theme_light.regex'   => 'Format warna terang tidak valid.',
            'theme_pale.regex'    => 'Format warna pucat tidak valid.',
            'theme_footer.regex'  => 'Format warna footer tidak valid.',
        ]);

        Setting::setValue('theme_preset', $request->theme_preset, 'text', 'theme');
        Setting::setValue('theme_primary', $request->theme_primary, 'text', 'theme');
        Setting::setValue('theme_dark',    $request->theme_dark,    'text', 'theme');
        Setting::setValue('theme_light',   $request->theme_light,   'text', 'theme');
        Setting::setValue('theme_pale',    $request->theme_pale,    'text', 'theme');
        Setting::setValue('theme_footer',  $request->theme_footer,  'text', 'theme');

        return redirect()->route('admin.theme.index')
            ->with('success', 'Tema website berhasil diperbarui!');
    }
}
