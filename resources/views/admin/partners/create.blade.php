@extends('layouts.admin')

@section('title', 'Tambah Partner')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Partner</h1>
        <p class="text-gray-600 mt-1">Tambahkan logo partner baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Partner <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div class="mb-6">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    Logo <span class="text-red-500">*</span>
                </label>
                <input type="file" 
                       name="logo" 
                       id="logo" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent @error('logo') border-red-500 @enderror"
                       onchange="previewImage(event)"
                       required>
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, SVG, WebP. Max: 2MB. Rekomendasi ukuran: 200x100px</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Preview -->
                <div id="logo-preview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <img id="preview-image" src="" alt="Preview" class="w-48 h-24 object-contain bg-gray-50 border border-gray-200 rounded p-2">
                </div>
            </div>

            <!-- URL -->
            <div class="mb-6">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                    Website URL (Opsional)
                </label>
                <input type="url" 
                       name="url" 
                       id="url" 
                       value="{{ old('url') }}"
                       placeholder="https://example.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent @error('url') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Link akan dibuka di tab baru saat logo diklik</p>
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order -->
            <div class="mb-6">
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="order" 
                       id="order" 
                       value="{{ old('order', 0) }}"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent @error('order') border-red-500 @enderror"
                       required>
                <p class="mt-1 text-xs text-gray-500">Semakin kecil angka, semakin awal ditampilkan. Atau gunakan drag & drop di halaman daftar.</p>
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#00629B] border-gray-300 rounded focus:ring-2 focus:ring-[#00629B]">
                    <span class="ml-2 text-sm text-gray-700">Aktif (tampilkan di website)</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-[#00629B] hover:bg-[#003A5D] text-white rounded-lg transition">
                    Simpan Partner
                </button>
                <a href="{{ route('admin.partners.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('logo-preview');
    const previewImage = document.getElementById('preview-image');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endsection
