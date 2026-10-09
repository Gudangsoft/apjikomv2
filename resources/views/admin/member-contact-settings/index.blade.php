@extends('layouts.admin')

@section('page-title', 'Kontak Member & Rekening Kartu')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Kontak Member & Rekening Kartu</h2>
            <p class="text-sm text-gray-600 mt-1">
                Nomor WA grup, WA tim APJIKOM, dan rekening untuk biaya cetak kartu anggota — tampil di dashboard member.
                Semua baris bersifat opsional dan boleh lebih dari satu.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.member-contact-settings.update') }}" id="contactSettingsForm" class="p-6">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <!-- Grup WhatsApp -->
            <div class="mb-8 bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0012.05 0"/>
                        </svg>
                        Grup WhatsApp Member
                    </h4>
                    <button type="button" onclick="addRow('groups')"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-green-700 border border-green-300 rounded-lg hover:bg-green-100 text-sm bg-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-3">Link undangan grup WA (mis. https://chat.whatsapp.com/...). Boleh lebih dari satu grup, misalnya per angkatan/wilayah.</p>
                <div id="groups-rows" class="space-y-2"></div>
                <p id="groups-empty" class="text-sm text-gray-400 hidden">Belum ada grup WA ditambahkan.</p>
            </div>

            <!-- Kontak WA Tim -->
            <div class="mb-8 bg-teal-50 p-4 rounded-lg border border-teal-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Kontak WhatsApp Tim APJIKOM
                    </h4>
                    <button type="button" onclick="addRow('contacts')"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-teal-700 border border-teal-300 rounded-lg hover:bg-teal-100 text-sm bg-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-3">Nomor WA yang bisa dihubungi member langsung, mis. Admin Sekretariat, CP Keanggotaan.</p>
                <div id="contacts-rows" class="space-y-2"></div>
                <p id="contacts-empty" class="text-sm text-gray-400 hidden">Belum ada kontak WA ditambahkan.</p>
            </div>

            <!-- Rekening Cetak Kartu -->
            <div class="mb-8 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                        Rekening Bank untuk Cetak Kartu
                    </h4>
                    <button type="button" onclick="addRow('banks')"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-blue-700 border border-blue-300 rounded-lg hover:bg-blue-100 text-sm bg-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-3">Ditampilkan ke member saat mereka request cetak/update kartu anggota, beserta tombol unggah bukti bayar.</p>
                <div id="banks-rows" class="space-y-2"></div>
                <p id="banks-empty" class="text-sm text-gray-400 hidden">Belum ada rekening ditambahkan.</p>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Instruksi Biaya (opsional)</label>
                    <textarea name="card_fee_note" rows="2" maxlength="1000"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Contoh: Biaya cetak kartu Rp25.000, transfer lalu lampirkan bukti bayar saat request.">{{ old('card_fee_note', $cardFeeNote) }}</textarea>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-6 border-t">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md hover:shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pengaturan
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const INITIAL = {
    groups:   @json(old('wa_groups', $waGroups)),
    contacts: @json(old('wa_contacts', $waContacts)),
    banks:    @json(old('bank_accounts', $bankAccounts)),
};

const FIELD_NAMES = { groups: 'wa_groups', contacts: 'wa_contacts', banks: 'bank_accounts' };
let rowIdx = { groups: 0, contacts: 0, banks: 0 };

function rowTemplate(type, idx, data) {
    data = data || {};
    const name = FIELD_NAMES[type];

    if (type === 'groups') {
        return `
        <div class="flex gap-2 items-start" id="${type}-row-${idx}">
            <input type="text" name="${name}[${idx}][label]" value="${data.label ? data.label.replace(/"/g, '&quot;') : ''}"
                   placeholder="Label (mis. Grup WA Anggota)"
                   class="w-56 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-green-400">
            <input type="text" name="${name}[${idx}][url]" value="${data.url ? data.url.replace(/"/g, '&quot;') : ''}"
                   placeholder="https://chat.whatsapp.com/..."
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-green-400">
            <button type="button" onclick="removeRow('${type}', ${idx})"
                    class="px-3 py-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>`;
    }

    if (type === 'contacts') {
        return `
        <div class="flex gap-2 items-start" id="${type}-row-${idx}">
            <input type="text" name="${name}[${idx}][label]" value="${data.label ? data.label.replace(/"/g, '&quot;') : ''}"
                   placeholder="Label (mis. Admin Sekretariat)"
                   class="w-56 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-teal-400">
            <input type="text" name="${name}[${idx}][number]" value="${data.number ? data.number.replace(/"/g, '&quot;') : ''}"
                   placeholder="08xxxxxxxxxx"
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-teal-400">
            <button type="button" onclick="removeRow('${type}', ${idx})"
                    class="px-3 py-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>`;
    }

    // banks
    return `
    <div class="flex gap-2 items-start" id="${type}-row-${idx}">
        <input type="text" name="${name}[${idx}][bank]" value="${data.bank ? data.bank.replace(/"/g, '&quot;') : ''}"
               placeholder="Nama Bank"
               class="w-44 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-400">
        <input type="text" name="${name}[${idx}][number]" value="${data.number ? data.number.replace(/"/g, '&quot;') : ''}"
               placeholder="Nomor Rekening"
               class="w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-400">
        <input type="text" name="${name}[${idx}][holder]" value="${data.holder ? data.holder.replace(/"/g, '&quot;') : ''}"
               placeholder="Atas Nama"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-400">
        <button type="button" onclick="removeRow('${type}', ${idx})"
                class="px-3 py-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>`;
}

function addRow(type, data) {
    const idx = rowIdx[type]++;
    document.getElementById(`${type}-rows`).insertAdjacentHTML('beforeend', rowTemplate(type, idx, data));
    toggleEmpty(type);
}

function removeRow(type, idx) {
    document.getElementById(`${type}-row-${idx}`)?.remove();
    toggleEmpty(type);
}

function toggleEmpty(type) {
    const container = document.getElementById(`${type}-rows`);
    const empty = document.getElementById(`${type}-empty`);
    empty.classList.toggle('hidden', container.children.length > 0);
}

// Bootstrap existing rows (or one empty row to start with)
['groups', 'contacts', 'banks'].forEach(type => {
    const items = INITIAL[type] || [];
    if (items.length) {
        items.forEach(item => addRow(type, item));
    } else {
        toggleEmpty(type);
    }
});
</script>
@endsection
