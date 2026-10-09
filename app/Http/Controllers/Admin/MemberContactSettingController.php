<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MemberContactSettingController extends Controller
{
    public function index()
    {
        $waGroups = member_wa_groups();
        $waContacts = member_wa_contacts();
        $bankAccounts = member_card_bank_accounts();
        $cardFeeNote = setting('member_card_fee_note', '');

        return view('admin.member-contact-settings.index', compact(
            'waGroups',
            'waContacts',
            'bankAccounts',
            'cardFeeNote'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'wa_groups' => 'nullable|array',
            'wa_groups.*.label' => 'nullable|string|max:100',
            'wa_groups.*.url' => 'nullable|string|max:255',

            'wa_contacts' => 'nullable|array',
            'wa_contacts.*.label' => 'nullable|string|max:100',
            'wa_contacts.*.number' => 'nullable|string|max:20',

            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.bank' => 'nullable|string|max:100',
            'bank_accounts.*.number' => 'nullable|string|max:50',
            'bank_accounts.*.holder' => 'nullable|string|max:150',

            'card_fee_note' => 'nullable|string|max:1000',
        ]);

        // Drop fully-empty rows, keep everything else — every row is optional.
        $waGroups = array_values(array_filter(
            $validated['wa_groups'] ?? [],
            fn ($row) => filled($row['url'] ?? null)
        ));

        $waContacts = array_values(array_filter(
            $validated['wa_contacts'] ?? [],
            fn ($row) => filled($row['number'] ?? null)
        ));

        $bankAccounts = array_values(array_filter(
            $validated['bank_accounts'] ?? [],
            fn ($row) => filled($row['bank'] ?? null) || filled($row['number'] ?? null)
        ));

        Setting::setValue('member_wa_groups', json_encode($waGroups), 'json', 'member_contact');
        Setting::setValue('member_wa_contacts', json_encode($waContacts), 'json', 'member_contact');
        Setting::setValue('member_card_bank_accounts', json_encode($bankAccounts), 'json', 'member_contact');
        Setting::setValue('member_card_fee_note', $validated['card_fee_note'] ?? '', 'text', 'member_contact');

        return redirect()->route('admin.member-contact-settings.index')
            ->with('success', 'Pengaturan kontak member & rekening kartu berhasil diperbarui!');
    }
}
