@extends('layouts.admin')
@section('page-title', 'Kelola Bidang')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Bidang / Divisi</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar bidang yang dapat dipilih saat menambah pengurus</p>
    </div>
    <a href="{{ route('admin.organizational-structure.index') }}" class="text-sm text-purple-600 hover:text-purple-800 flex items-center gap-1">
        ← Kembali ke Struktur
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Form Tambah --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Tambah Bidang Baru</h3>
            <form action="{{ route('admin.organizational-divisions.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Divisi Publikasi"
                               class="w-full px-3 py-2 border rounded-lg text-sm @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="description" value="{{ old('description') }}" placeholder="Opsional"
                               class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-24 px-3 py-2 border rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded text-purple-600">
                            Aktif
                        </label>
                    </div>
                    <button type="submit" class="w-full py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">
                        + Tambah Bidang
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Bidang --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Bidang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Urut</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($divisions as $division)
                    <tr id="row-{{ $division->id }}" class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <div id="view-name-{{ $division->id }}" class="text-sm font-medium text-gray-900">{{ $division->name }}</div>
                            <form id="edit-form-{{ $division->id }}" action="{{ route('admin.organizational-divisions.update', $division) }}" method="POST" class="hidden">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $division->name }}" required
                                       class="w-full px-2 py-1 border rounded text-sm mb-1">
                                <input type="text" name="description" value="{{ $division->description }}"
                                       placeholder="Deskripsi" class="w-full px-2 py-1 border rounded text-sm mb-1">
                                <div class="flex gap-2 items-center">
                                    <input type="number" name="order" value="{{ $division->order }}" min="0"
                                           class="w-16 px-2 py-1 border rounded text-sm">
                                    <label class="flex items-center gap-1 text-xs">
                                        <input type="checkbox" name="is_active" value="1" {{ $division->is_active ? 'checked' : '' }}
                                               class="rounded text-purple-600"> Aktif
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <span id="view-desc-{{ $division->id }}">{{ $division->description ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $division->order }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($division->is_active)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="toggleEdit({{ $division->id }})"
                                        id="edit-btn-{{ $division->id }}"
                                        class="text-purple-600 hover:text-purple-900 text-sm">Edit</button>
                                <button onclick="submitEdit({{ $division->id }})"
                                        id="save-btn-{{ $division->id }}"
                                        class="hidden text-green-600 hover:text-green-900 text-sm">Simpan</button>
                                <button onclick="cancelEdit({{ $division->id }})"
                                        id="cancel-btn-{{ $division->id }}"
                                        class="hidden text-gray-500 hover:text-gray-700 text-sm">Batal</button>
                                <form action="{{ route('admin.organizational-divisions.destroy', $division) }}" method="POST"
                                      onsubmit="return confirm('Hapus bidang \'{{ addslashes($division->name) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada bidang. Tambahkan di form kiri.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function toggleEdit(id) {
    document.getElementById('view-name-' + id).classList.add('hidden');
    document.getElementById('edit-form-' + id).classList.remove('hidden');
    document.getElementById('edit-btn-' + id).classList.add('hidden');
    document.getElementById('save-btn-' + id).classList.remove('hidden');
    document.getElementById('cancel-btn-' + id).classList.remove('hidden');
}
function cancelEdit(id) {
    document.getElementById('view-name-' + id).classList.remove('hidden');
    document.getElementById('edit-form-' + id).classList.add('hidden');
    document.getElementById('edit-btn-' + id).classList.remove('hidden');
    document.getElementById('save-btn-' + id).classList.add('hidden');
    document.getElementById('cancel-btn-' + id).classList.add('hidden');
}
function submitEdit(id) {
    document.getElementById('edit-form-' + id).submit();
}
</script>
@endsection
