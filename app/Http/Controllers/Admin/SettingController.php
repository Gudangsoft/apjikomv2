<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
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
            'satisfaction_rate'     => 'required|numeric|min:0|max:100',
            'site_name'             => 'nullable|string|max:255',
            'site_tagline'          => 'nullable|string|max:255',
            'site_description'      => 'nullable|string',
            'contact_email'         => 'nullable|email',
            'contact_phone'         => 'nullable|string',
            'contact_address'       => 'nullable|string',
            'meta_keywords'         => 'nullable|string',
            'meta_description'      => 'nullable|string',
            'google_analytics'      => 'nullable|string',
            'member_number_prefix'  => 'nullable|string|max:30|alpha_dash',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            $logoPath = $request->file('site_logo')->store('settings', 'public');
            
            // Delete old logo
            $oldLogo = Setting::getValue('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            Setting::setValue('site_logo', $logoPath, 'image', 'general');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $request->validate([
                'site_favicon' => 'image|mimes:png,ico|max:512',
            ]);

            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            
            // Delete old favicon
            $oldFavicon = Setting::getValue('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            
            Setting::setValue('site_favicon', $faviconPath, 'image', 'general');
        }

        // Save all text settings
        foreach ($validated as $key => $value) {
            $group = 'general';

            if (str_starts_with($key, 'contact_')) {
                $group = 'contact';
            } elseif (in_array($key, ['meta_keywords', 'meta_description', 'google_analytics'])) {
                $group = 'seo';
            } elseif ($key === 'satisfaction_rate') {
                $group = 'statistics';
            } elseif ($key === 'member_number_prefix') {
                $group = 'membership';
                $value = strtoupper(trim($value ?? 'APJIKOM'));
            }

            $type = 'text';
            if (in_array($key, ['site_description', 'contact_address', 'meta_description', 'google_analytics'])) {
                $type = 'textarea';
            } elseif ($key === 'satisfaction_rate') {
                $type = 'number';
            } elseif ($key === 'contact_email') {
                $type = 'email';
            }

            Setting::setValue($key, $value, $type, $group);
        }

        ActivityLogger::log('settings', 'updated', null, 'Update pengaturan website');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
    }

    public function regenerateMemberCards(Request $request)
    {
        $request->validate([
            'old_prefix' => 'required|string|max:30',
            'confirm'    => 'required|accepted',
        ], [
            'old_prefix.required' => 'Prefix lama wajib diisi.',
            'confirm.accepted'    => 'Centang konfirmasi untuk melanjutkan.',
        ]);

        $oldPrefix = strtoupper(trim($request->old_prefix));
        $newPrefix = strtoupper(trim(Setting::getValue('member_number_prefix', 'APJIKOM')));

        // Find members whose member_number starts with the old prefix
        $members = \App\Models\Member::with('user')
            ->where('member_number', 'LIKE', "{$oldPrefix}.%")
            ->get();

        if ($members->isEmpty()) {
            return back()->with('error', "Tidak ditemukan anggota dengan prefix nomor \"{$oldPrefix}\".");
        }

        $generator = new \App\Services\MemberCardGenerator();
        $success   = 0;
        $failed    = 0;
        $skipped   = 0;

        foreach ($members as $member) {
            try {
                // Replace only the prefix part, keep date and sequence
                $suffix    = substr($member->member_number, strlen($oldPrefix));
                $newNumber = $newPrefix . $suffix;

                $member->update(['member_number' => $newNumber]);

                // Regenerate card image if the member has a photo or we still need the card
                $generator->generate($member->fresh());
                $success++;
            } catch (\Throwable $e) {
                $failed++;
                \Illuminate\Support\Facades\Log::warning(
                    "regenerateMemberCards: failed member #{$member->id}: " . $e->getMessage()
                );
            }
        }

        $msg = "Berhasil: {$success} kartu diperbarui (prefix {$oldPrefix} → {$newPrefix})";
        if ($failed > 0) {
            $msg .= " | Gagal: {$failed}";
        }

        ActivityLogger::log('members', 'bulk_regenerate_cards', null,
            "Regenerasi kartu: prefix \"{$oldPrefix}\" → \"{$newPrefix}\", {$success} berhasil, {$failed} gagal");

        return back()->with('success', $msg);
    }
}
