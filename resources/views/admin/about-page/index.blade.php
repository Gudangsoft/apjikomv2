@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang Kami')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Halaman Tentang Kami</h1>
        <p class="text-gray-600 mt-1">Kelola konten visi, misi, dan sejarah APJIKOM</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.about-page.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Visi -->
            <div class="mb-6">
                <label for="about_vision" class="block text-sm font-medium text-gray-700 mb-2">
                    Visi <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="about_vision" 
                    name="about_vision" 
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_vision') border-red-500 @enderror"
                    required
                >{{ old('about_vision', setting('about_vision', 'Menjadi wadah profesional utama bagi pengelola jurnal ilmiah di Indonesia untuk meningkatkan kualitas dan kredibilitas publikasi ilmiah nasional.')) }}</textarea>
                @error('about_vision')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Misi -->
            <div class="mb-6">
                <label for="about_mission" class="block text-sm font-medium text-gray-700 mb-2">
                    Misi <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="about_mission" 
                    name="about_mission" 
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_mission') border-red-500 @enderror"
                    required
                >{{ old('about_mission', setting('about_mission', "• Memfasilitasi pengembangan kompetensi pengelola jurnal ilmiah\n• Meningkatkan kualitas manajemen jurnal ilmiah di Indonesia\n• Membangun jaringan kolaborasi antar pengelola jurnal\n• Memberikan advokasi untuk kemajuan publikasi ilmiah nasional")) }}</textarea>
                @error('about_mission')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Gunakan bullet point (•) atau nomor untuk list</p>
            </div>

            <!-- Sejarah -->
            <div class="mb-6">
                <label for="about_history" class="block text-sm font-medium text-gray-700 mb-2">
                    Sejarah <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="about_history" 
                    name="about_history" 
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_history') border-red-500 @enderror"
                    required
                >{{ old('about_history', setting('about_history', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi (APJIKOM) didirikan sebagai wadah profesional bagi para pengelola jurnal ilmiah di bidang Ilmu Komunikasi. Organisasi ini lahir dari kebutuhan untuk meningkatkan kualitas pengelolaan jurnal ilmiah dan membangun standar profesional dalam publikasi ilmiah di Indonesia.')) }}</textarea>
                @error('about_history')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Berdiri -->
            <div class="mb-6">
                <label for="about_founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Berdiri <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="about_founded_year" 
                    name="about_founded_year" 
                    maxlength="4"
                    value="{{ old('about_founded_year', setting('about_founded_year', '2020')) }}"
                    class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_founded_year') border-red-500 @enderror"
                    required
                >
                @error('about_founded_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 mb-1">Informasi</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Konten ini akan ditampilkan di halaman <strong>Tentang Kami</strong></li>
                    <li>• Untuk mengelola <strong>Struktur Organisasi</strong>, gunakan menu "Struktur Organisasi"</li>
                    <li>• Statistik (Jumlah Anggota & Event) diambil otomatis dari database</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
