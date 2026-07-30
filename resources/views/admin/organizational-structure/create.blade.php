@extends('layouts.admin')
@section('page-title', 'Tambah Pengurus')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pengurus</h1>
        <p class="text-gray-500 text-sm mt-1">Kelompokkan per bidang, lalu tambahkan anggota di dalamnya.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.organizational-divisions.index') }}"
           class="px-4 py-2 border border-purple-200 text-purple-700 rounded-lg hover:bg-purple-50 text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Kelola Bidang
        </a>
        <a href="{{ route('admin.organizational-structure.index') }}"
           class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50 text-sm">Batal</a>
    </div>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.organizational-structure.store') }}" method="POST"
      enctype="multipart/form-data" id="mainForm">
@csrf

{{-- ─── PENGURUS INTI ─────────────────────────────────────────── --}}
<div class="bg-white rounded-xl shadow-sm border mb-5" id="section-leadership">
    <div class="flex items-center justify-between px-5 py-4 border-b bg-purple-50 rounded-t-xl">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Pengurus Inti</h3>
                <p class="text-xs text-gray-500">Ketua, Sekretaris, Bendahara, dll.</p>
            </div>
        </div>
        <button type="button" onclick="addLeadershipRow()"
                class="flex items-center gap-1.5 px-3 py-1.5 text-purple-700 border border-purple-300 rounded-lg hover:bg-purple-100 text-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Anggota
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-8">#</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-44">Jabatan *</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nama Lengkap *</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-44">Institusi</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-32">Foto</th>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase w-14">Urut</th>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase w-14">Aktif</th>
                    <th class="px-4 py-2 w-8"></th>
                </tr>
            </thead>
            <tbody id="leadership-rows"></tbody>
        </table>
    </div>
    <div id="leadership-empty" class="py-6 text-center text-sm text-gray-400">
        Klik "Tambah Anggota" untuk menambah pengurus inti.
    </div>
</div>

{{-- ─── BLOK BIDANG ─────────────────────────────────────────────── --}}
<div id="division-blocks" class="space-y-5"></div>

{{-- ─── FOOTER ACTIONS ──────────────────────────────────────────── --}}
<div class="flex items-center justify-between mt-5">
    <button type="button" onclick="addDivisionBlock()"
            class="flex items-center gap-2 px-5 py-2.5 border-2 border-dashed border-indigo-300 text-indigo-600 rounded-xl hover:bg-indigo-50 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Blok Bidang
    </button>
    <button type="submit"
            class="px-8 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Simpan Semua
    </button>
</div>

</form>

<script>
const DIVISIONS = @json($divisions->map(fn($d) => ['id' => $d->id, 'name' => $d->name]));

let globalIdx  = 0; // unique index for each member row (used for form names)
let blockCount = 0; // unique index for each division block
const ACCENT_COLORS = [
    'from-indigo-500 to-indigo-600','from-purple-500 to-purple-600',
    'from-blue-500 to-blue-600','from-cyan-500 to-cyan-600',
    'from-teal-500 to-teal-600','from-violet-500 to-violet-600',
];

// ── Build a single member row ────────────────────────────────────
function buildMemberRow(rowIdx, type, divisionName) {
    const isLeader = type === 'leadership';
    return `
    <tr id="member-${rowIdx}" class="border-b last:border-0 hover:bg-gray-50 align-middle">
        <input type="hidden" name="members[${rowIdx}][type]" value="${type}">
        <input type="hidden" name="members[${rowIdx}][division_name]"
               id="divname-${rowIdx}" value="${divisionName || ''}">
        <td class="px-4 py-2 text-sm text-gray-400 w-8">
            <span class="row-num"></span>
        </td>
        <td class="px-4 py-2">
            <input type="text" name="members[${rowIdx}][position]" required
                   placeholder="${isLeader ? 'Ketua Umum, Sekretaris…' : 'Koordinator, Anggota…'}"
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>
        <td class="px-4 py-2">
            <input type="text" name="members[${rowIdx}][name]" required
                   placeholder="Nama lengkap"
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>
        <td class="px-4 py-2">
            <input type="text" name="members[${rowIdx}][institusi]"
                   placeholder="Asal institusi"
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>
        <td class="px-4 py-2">
            <input type="file" name="photos[${rowIdx}]" accept="image/*"
                   class="w-full text-xs text-gray-500 file:py-1 file:px-2 file:rounded file:border-0 file:bg-purple-50 file:text-purple-700 file:text-xs">
        </td>
        <td class="px-4 py-2 text-center">
            <input type="number" name="members[${rowIdx}][order]" value="${rowIdx}" min="0"
                   class="w-12 px-1 py-1.5 border rounded text-sm text-center focus:ring-1 focus:ring-purple-400">
        </td>
        <td class="px-4 py-2 text-center">
            <input type="checkbox" name="members[${rowIdx}][is_active]" value="1" checked
                   class="w-4 h-4 rounded text-purple-600">
        </td>
        <td class="px-4 py-2 text-center">
            <button type="button" onclick="removeRow(${rowIdx})"
                    class="text-red-400 hover:text-red-600 text-lg font-bold leading-none">×</button>
        </td>
    </tr>`;
}

// ── Build a division block ───────────────────────────────────────
function buildDivisionBlock(blockIdx) {
    const color = ACCENT_COLORS[blockIdx % ACCENT_COLORS.length];
    const divOptions = DIVISIONS.map(d =>
        `<option value="${d.name}">${d.name}</option>`
    ).join('');

    return `
    <div id="block-${blockIdx}" class="bg-white rounded-xl shadow-sm border">
        <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50 rounded-t-xl gap-4">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br ${color} flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <select id="block-div-${blockIdx}"
                                onchange="onDivisionChange(${blockIdx}, this.value)"
                                class="font-semibold text-gray-800 bg-transparent border-b border-dashed border-gray-400 focus:outline-none focus:border-purple-500 text-sm pr-4 max-w-xs">
                            <option value="">— Pilih Bidang —</option>
                            ${divOptions}
                        </select>
                    </div>
                    <input type="text" id="block-manual-${blockIdx}"
                           placeholder="atau ketik nama bidang manual..."
                           oninput="onManualDivision(${blockIdx}, this.value)"
                           class="text-xs text-gray-500 bg-transparent border-0 outline-none mt-0.5 w-full">
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button type="button" onclick="addRowToBlock(${blockIdx})"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-indigo-700 border border-indigo-300 rounded-lg hover:bg-indigo-50 text-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Anggota
                </button>
                <button type="button" onclick="removeBlock(${blockIdx})"
                        class="p-1.5 text-red-400 hover:text-red-600 rounded hover:bg-red-50" title="Hapus blok ini">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-8">#</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-44">Jabatan *</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nama Lengkap *</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-44">Institusi</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase w-32">Foto</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase w-14">Urut</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase w-14">Aktif</th>
                        <th class="px-4 py-2 w-8"></th>
                    </tr>
                </thead>
                <tbody id="block-${blockIdx}-rows"></tbody>
            </table>
        </div>
        <div id="block-${blockIdx}-empty" class="py-5 text-center text-sm text-gray-400">
            Klik "Tambah Anggota" untuk menambahkan ke bidang ini.
        </div>
    </div>`;
}

// ── Event handlers ───────────────────────────────────────────────
function addLeadershipRow() {
    const idx = globalIdx++;
    const tbody = document.getElementById('leadership-rows');
    tbody.insertAdjacentHTML('beforeend', buildMemberRow(idx, 'leadership', ''));
    document.getElementById('leadership-empty').classList.add('hidden');
    updateRowNumbers('leadership-rows');
}

function addDivisionBlock() {
    const bIdx = blockCount++;
    document.getElementById('division-blocks').insertAdjacentHTML('beforeend', buildDivisionBlock(bIdx));
    // auto add one empty row
    addRowToBlock(bIdx);
}

function addRowToBlock(blockIdx) {
    const divName = getCurrentDivisionName(blockIdx);
    const idx = globalIdx++;
    const tbody = document.getElementById(`block-${blockIdx}-rows`);
    tbody.insertAdjacentHTML('beforeend', buildMemberRow(idx, 'division', divName));
    document.getElementById(`block-${blockIdx}-empty`).classList.add('hidden');
    updateRowNumbers(`block-${blockIdx}-rows`);
}

function onDivisionChange(blockIdx, value) {
    // clear manual if dropdown selected
    if (value) document.getElementById(`block-manual-${blockIdx}`).value = '';
    propagateDivisionName(blockIdx, value);
}

function onManualDivision(blockIdx, value) {
    // clear dropdown if typing manually
    if (value) document.getElementById(`block-div-${blockIdx}`).value = '';
    propagateDivisionName(blockIdx, value);
}

function getCurrentDivisionName(blockIdx) {
    const manual = document.getElementById(`block-manual-${blockIdx}`)?.value || '';
    const sel    = document.getElementById(`block-div-${blockIdx}`)?.value  || '';
    return manual || sel;
}

function propagateDivisionName(blockIdx, value) {
    // update all hidden division_name inputs within this block
    document.querySelectorAll(`#block-${blockIdx}-rows input[id^="divname-"]`).forEach(inp => {
        inp.value = value;
    });
}

function removeRow(rowIdx) {
    const row = document.getElementById(`member-${rowIdx}`);
    if (!row) return;
    const tbody = row.closest('tbody');
    row.remove();
    updateRowNumbers(tbody.id);
    // check if tbody is empty
    if (!tbody.rows.length) {
        const emptyEl = document.getElementById(tbody.id.replace('-rows', '-empty'));
        if (emptyEl) emptyEl.classList.remove('hidden');
    }
}

function removeBlock(blockIdx) {
    if (!confirm('Hapus blok bidang ini beserta semua anggotanya?')) return;
    document.getElementById(`block-${blockIdx}`)?.remove();
}

function updateRowNumbers(tbodyId) {
    document.querySelectorAll(`#${tbodyId} .row-num`).forEach((el, i) => {
        el.textContent = i + 1;
    });
}

// Start with 1 leadership row and 1 division block
addLeadershipRow();
addDivisionBlock();
</script>
@endsection
