@extends('layouts.admin')
@section('page-title', 'Edit Pengurus')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Pengurus</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $organizationalStructure->position }} — {{ $organizationalStructure->name }}</p>
    </div>
    <a href="{{ route('admin.organizational-structure.index') }}"
       class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50 text-sm">Batal</a>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form action="{{ route('admin.organizational-structure.update', $organizationalStructure) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tipe --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe <span class="text-red-500">*</span></label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="type" value="leadership"
                               {{ old('type', $organizationalStructure->type) == 'leadership' ? 'checked' : '' }}
                               class="text-purple-600" onchange="toggleDivisionField()">
                        <span class="text-sm">Pengurus Inti</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="type" value="division"
                               {{ old('type', $organizationalStructure->type) == 'division' ? 'checked' : '' }}
                               class="text-purple-600" onchange="toggleDivisionField()">
                        <span class="text-sm">Divisi</span>
                    </label>
                </div>
            </div>

            {{-- Bidang/Divisi --}}
            <div id="division-field" class="md:col-span-2 {{ $organizationalStructure->type == 'division' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Bidang / Divisi</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <select name="division_name" id="division_select"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-purple-400"
                            onchange="syncDivisionSelect()">
                        <option value="">— Pilih dari daftar —</option>
                        @foreach($divisions as $div)
                        <option value="{{ $div->name }}"
                            {{ old('division_name', $organizationalStructure->division_name) == $div->name ? 'selected' : '' }}>
                            {{ $div->name }}
                        </option>
                        @endforeach
                    </select>
                    <input type="text" id="division_manual" placeholder="atau ketik manual..."
                           value="{{ old('division_name', $organizationalStructure->division_name) && !$divisions->pluck('name')->contains(old('division_name', $organizationalStructure->division_name)) ? old('division_name', $organizationalStructure->division_name) : '' }}"
                           class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-purple-400"
                           oninput="manualOverride(this.value)">
                </div>
                <p class="text-xs text-gray-400 mt-1">Pilih dari dropdown atau ketik manual jika belum ada di daftar.</p>
            </div>

            {{-- Jabatan --}}
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" id="position" name="position"
                       value="{{ old('position', $organizationalStructure->position) }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm @error('position') border-red-500 @enderror">
                @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $organizationalStructure->name) }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Institusi --}}
            <div>
                <label for="institusi" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                <input type="text" id="institusi" name="institusi"
                       value="{{ old('institusi', $organizationalStructure->institusi) }}"
                       placeholder="Asal instansi / perguruan tinggi"
                       class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-purple-400">
            </div>

            {{-- Urutan --}}
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
                <input type="number" id="order" name="order"
                       value="{{ old('order', $organizationalStructure->order) }}" min="0" required
                       class="w-32 px-3 py-2 border rounded-lg text-sm @error('order') border-red-500 @enderror">
                @error('order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Foto saat ini --}}
            @if($organizationalStructure->photo)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                <img src="{{ asset('storage/' . $organizationalStructure->photo) }}"
                     alt="{{ $organizationalStructure->name }}"
                     class="w-24 h-24 rounded-full object-cover border">
            </div>
            @endif

            {{-- Upload Foto --}}
            <div class="md:col-span-2">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $organizationalStructure->photo ? 'Ganti Foto (opsional)' : 'Upload Foto (opsional)' }}
                </label>
                <input type="file" id="photo" name="photo" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded file:border-0 file:bg-purple-50 file:text-purple-700">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — maks 5MB. Kosongkan jika tidak ingin mengubah foto.</p>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (opsional)</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border rounded-lg text-sm">{{ old('description', $organizationalStructure->description) }}</textarea>
            </div>

            {{-- Status --}}
            <div class="md:col-span-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $organizationalStructure->is_active) ? 'checked' : '' }}
                           class="rounded text-purple-600">
                    <span class="text-sm text-gray-700">Pengurus aktif (tampil di website)</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
            <a href="{{ route('admin.organizational-structure.index') }}"
               class="px-6 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
function toggleDivisionField() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const field = document.getElementById('division-field');
    field.classList.toggle('hidden', type !== 'division');
}

function syncDivisionSelect() {
    // Clear manual input when dropdown is chosen
    document.getElementById('division_manual').value = '';
}

function manualOverride(val) {
    const sel = document.getElementById('division_select');
    if (val) {
        sel.value = '';
        sel.name = '';
        // Ensure a hidden input carries the manual value
        let h = document.getElementById('division_manual_hidden');
        if (!h) {
            h = document.createElement('input');
            h.type = 'hidden';
            h.id = 'division_manual_hidden';
            h.name = 'division_name';
            sel.parentNode.appendChild(h);
        }
        h.value = val;
    } else {
        sel.name = 'division_name';
        const h = document.getElementById('division_manual_hidden');
        if (h) h.remove();
    }
}

// On load: if manual value was set, disable the select
(function() {
    const manual = document.getElementById('division_manual').value;
    if (manual) manualOverride(manual);
})();
</script>
@endsection
