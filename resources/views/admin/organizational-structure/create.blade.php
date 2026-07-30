@extends('layouts.admin')
@section('page-title', 'Tambah Pengurus')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pengurus</h1>
        <p class="text-gray-500 text-sm mt-1">Input banyak pengurus sekaligus. Klik "+ Tambah Baris" untuk menambah.</p>
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
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.organizational-structure.store') }}" method="POST" enctype="multipart/form-data" id="bulkForm">
@csrf

<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-4">
    <div class="overflow-x-auto">
        <table class="min-w-full" id="bulk-table">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-10">#</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-28">Tipe</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-44">Bidang/Divisi</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-40">Jabatan *</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Lengkap *</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-44">Institusi</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-28">Foto</th>
                    <th class="px-3 py-3 text-center text-xs font-semibold text-gray-600 uppercase w-16">Urut</th>
                    <th class="px-3 py-3 text-center text-xs font-semibold text-gray-600 uppercase w-16">Aktif</th>
                    <th class="px-3 py-3 w-10"></th>
                </tr>
            </thead>
            <tbody id="rows-container">
                {{-- rows injected by JS --}}
            </tbody>
        </table>
    </div>
</div>

<div class="flex items-center justify-between">
    <button type="button" onclick="addRow()"
            class="flex items-center gap-2 px-4 py-2 border-2 border-dashed border-purple-300 text-purple-600 rounded-lg hover:bg-purple-50 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Baris
    </button>
    <button type="submit"
            class="px-8 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Simpan Semua
    </button>
</div>

</form>

{{-- Hidden division options for JS --}}
<script>
const DIVISIONS = @json($divisions->map(fn($d) => ['id' => $d->id, 'name' => $d->name]));

let rowCount = 0;

function buildRow(index) {
    const divisionOptions = DIVISIONS.map(d =>
        `<option value="${d.name}">${d.name}</option>`
    ).join('');

    return `
    <tr id="row-${index}" class="border-b hover:bg-gray-50/50 align-top">
        <td class="px-3 py-2 text-sm text-gray-400 pt-3">${index + 1}</td>

        <td class="px-3 py-2">
            <select name="members[${index}][type]" onchange="toggleBidang(${index}, this.value)"
                    class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
                <option value="leadership">Pengurus Inti</option>
                <option value="division">Divisi</option>
            </select>
        </td>

        <td class="px-3 py-2" id="bidang-cell-${index}">
            <div class="hidden" id="bidang-wrap-${index}">
                <select name="members[${index}][division_name]"
                        class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400 mb-1">
                    <option value="">— Pilih Bidang —</option>
                    ${divisionOptions}
                </select>
                <input type="text" placeholder="atau ketik manual..."
                       class="w-full px-2 py-1.5 border rounded text-xs text-gray-500"
                       oninput="manualDivision(${index}, this.value)">
            </div>
            <span id="bidang-empty-${index}" class="text-xs text-gray-300 italic">—</span>
        </td>

        <td class="px-3 py-2">
            <input type="text" name="members[${index}][position]" required
                   placeholder="Ketua Umum, Koordinator..."
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>

        <td class="px-3 py-2">
            <input type="text" name="members[${index}][name]" required
                   placeholder="Nama lengkap"
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>

        <td class="px-3 py-2">
            <input type="text" name="members[${index}][institusi]"
                   placeholder="Asal institusi"
                   class="w-full px-2 py-1.5 border rounded text-sm focus:ring-1 focus:ring-purple-400">
        </td>

        <td class="px-3 py-2">
            <label class="flex items-center gap-1 cursor-pointer">
                <input type="file" name="photos[${index}]" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-purple-50 file:text-purple-700 file:text-xs">
            </label>
        </td>

        <td class="px-3 py-2">
            <input type="number" name="members[${index}][order]" value="${index}"
                   min="0" class="w-14 px-2 py-1.5 border rounded text-sm text-center focus:ring-1 focus:ring-purple-400">
        </td>

        <td class="px-3 py-2 text-center">
            <input type="checkbox" name="members[${index}][is_active]" value="1" checked
                   class="w-4 h-4 rounded text-purple-600">
        </td>

        <td class="px-3 py-2 text-center">
            <button type="button" onclick="removeRow(${index})"
                    class="text-red-400 hover:text-red-600 text-lg leading-none font-bold" title="Hapus baris">×</button>
        </td>
    </tr>`;
}

function addRow() {
    const index = rowCount++;
    document.getElementById('rows-container').insertAdjacentHTML('beforeend', buildRow(index));
    updateNumbers();
}

function removeRow(index) {
    const row = document.getElementById('row-' + index);
    if (row) row.remove();
    updateNumbers();
}

function updateNumbers() {
    document.querySelectorAll('#rows-container tr').forEach((tr, i) => {
        tr.querySelector('td:first-child').textContent = i + 1;
    });
}

function toggleBidang(index, type) {
    const wrap = document.getElementById('bidang-wrap-' + index);
    const empty = document.getElementById('bidang-empty-' + index);
    if (type === 'division') {
        wrap.classList.remove('hidden');
        empty.classList.add('hidden');
    } else {
        wrap.classList.add('hidden');
        empty.classList.remove('hidden');
    }
}

function manualDivision(index, val) {
    const sel = document.querySelector(`select[name="members[${index}][division_name]"]`);
    if (val) sel.value = '';
    sel.setAttribute('data-manual', val);
    // Use a hidden input to override
    let hidden = document.getElementById('manual-div-' + index);
    if (!hidden) {
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.id = 'manual-div-' + index;
        hidden.name = `members[${index}][division_name]`;
        sel.parentNode.appendChild(hidden);
        sel.name = ''; // disable original select
    }
    hidden.value = val;
    if (!val) {
        hidden.remove();
        sel.name = `members[${index}][division_name]`;
    }
}

// Add initial row on load
addRow();
</script>
@endsection
