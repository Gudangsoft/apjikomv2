@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Layanan Baru</h1>
        <p class="text-gray-600 mt-1">Tambahkan layanan atau program baru APJIKOM</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Layanan <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icon -->
            <div class="mb-6">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                    Icon Class (Opsional)
                </label>
                <input 
                    type="text" 
                    id="icon" 
                    name="icon" 
                    value="{{ old('icon') }}"
                    placeholder="Contoh: fas fa-book atau heroicon-outline:book"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak menggunakan icon khusus</p>
            </div>

            <!-- Color -->
            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    Warna <span class="text-red-500">*</span>
                </label>
                <select 
                    id="color" 
                    name="color" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('color') border-red-500 @enderror"
                    required
                >
                    <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Biru</option>
                    <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Ungu</option>
                    <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Hijau</option>
                    <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }}>Oranye</option>
                    <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Merah</option>
                    <option value="teal" {{ old('color') == 'teal' ? 'selected' : '' }}>Teal</option>
                    <option value="indigo" {{ old('color') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                </select>
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Features -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Fitur/Benefit (Maksimal 6)
                </label>
                <div id="features-container" class="space-y-2">
                    @for($i = 0; $i < 4; $i++)
                        <input 
                            type="text" 
                            name="features[]" 
                            value="{{ old('features.'.$i) }}"
                            placeholder="Fitur {{ $i + 1 }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    @endfor
                </div>
                <button type="button" onclick="addFeature()" class="mt-2 text-sm text-purple-600 hover:text-purple-800">
                    + Tambah Fitur
                </button>
            </div>

            <!-- CTA Text -->
            <div class="mb-6">
                <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Teks Tombol CTA (Opsional)
                </label>
                <input 
                    type="text" 
                    id="cta_text" 
                    name="cta_text" 
                    value="{{ old('cta_text', 'Hubungi Kami') }}"
                    placeholder="Contoh: Hubungi Kami, Pelajari Lebih Lanjut"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
            </div>

            <!-- CTA Link -->
            <div class="mb-6">
                <label for="cta_link" class="block text-sm font-medium text-gray-700 mb-2">
                    Link Tombol CTA (Opsional)
                </label>
                <input 
                    type="text" 
                    id="cta_link" 
                    name="cta_link" 
                    value="{{ old('cta_link') }}"
                    placeholder="Contoh: /kontak atau https://wa.me/..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
            </div>

            <!-- Order -->
            <div class="mb-6">
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="order" 
                    name="order" 
                    value="{{ old('order', 0) }}"
                    min="0"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('order') border-red-500 @enderror"
                    required
                >
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Semakin kecil, semakin awal tampil</p>
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                    >
                    <span class="ml-2 text-sm text-gray-700">Aktifkan layanan ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Simpan Layanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let featureCount = 4;

function addFeature() {
    if (featureCount >= 6) {
        alert('Maksimal 6 fitur');
        return;
    }
    
    const container = document.getElementById('features-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'features[]';
    input.placeholder = 'Fitur ' + (featureCount + 1);
    input.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent';
    
    container.appendChild(input);
    featureCount++;
}
</script>
@endsection
