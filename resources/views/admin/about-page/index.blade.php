@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang Kami')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Halaman Tentang Kami</h1>
        <p class="text-gray-600 mt-1">Kelola konten visi, misi, dan sejarah APJIKOM</p>
    </div>

    <!-- Tutorial Note -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-blue-800 mb-1">📝 Cara Edit Halaman Tentang Kami</h3>
                <p class="text-sm text-blue-700 mb-2">
                    Ubah konten di form di bawah, lalu klik <strong>💾 Simpan Perubahan</strong> di bagian bawah. 
                    Preview di atas akan update otomatis saat Anda mengetik. Hasil akan tampil di halaman publik: <a href="{{ route('about.index') }}" target="_blank" class="underline font-medium">apjikom.or.id/tentang-kami</a>
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Preview Section -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-t-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-2" id="preview_title">{{ setting('about_page_title', 'Tentang APJIKOM') }}</h2>
            <p class="text-purple-100 border border-purple-300 inline-block px-6 py-2 rounded" id="preview_subtitle">{{ setting('about_page_subtitle', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia') }}</p>
        </div>
        <div class="bg-white rounded-b-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Preview Visi -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Visi</h3>
                    </div>
                    <p class="text-gray-700 text-sm" id="preview_vision">{{ setting('about_vision', 'Menjadi organisasi profesional yang terpercaya dalam meningkatkan kualitas dan kredibilitas jurnal ilmu komunikasi di Indonesia.') }}</p>
                </div>

                <!-- Preview Misi -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Misi</h3>
                    </div>
                    <ul class="space-y-2 text-sm" id="preview_mission">
                        @php
                            $missions = explode("\n", setting('about_mission', "• Meningkatkan kapasitas pengelola jurnal melalui pelatihan dan pendampingan\n• Memfasilitasi kolaborasi antar pengelola jurnal komunikasi\n• Mendukung akreditasi dan peningkatan kualitas jurnal\n• Membangun jejaring dengan organisasi profesi sejenis"));
                        @endphp
                        @foreach($missions as $mission)
                            @if(trim($mission))
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">{{ ltrim($mission, '•-* ') }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.about-page.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Header Section -->
            <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg border border-purple-200">
                <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"></path>
                    </svg>
                    Header Halaman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Judul Halaman -->
                    <div>
                        <label for="about_page_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Halaman <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="about_page_title" 
                            name="about_page_title" 
                            value="{{ old('about_page_title', setting('about_page_title', 'Tentang APJIKOM')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_page_title') border-red-500 @enderror"
                            required
                        >
                        @error('about_page_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label for="about_page_subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtitle <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="about_page_subtitle" 
                            name="about_page_subtitle" 
                            value="{{ old('about_page_subtitle', setting('about_page_subtitle', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_page_subtitle') border-red-500 @enderror"
                            required
                        >
                        @error('about_page_subtitle')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Visi -->
            <div class="mb-6">
                <label for="about_vision" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Visi <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea 
                    id="about_vision" 
                    name="about_vision" 
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_vision') border-red-500 @enderror"
                    required
                >{{ old('about_vision', setting('about_vision', 'Menjadi organisasi profesional yang terpercaya dalam meningkatkan kualitas dan kredibilitas jurnal ilmu komunikasi di Indonesia.')) }}</textarea>
                @error('about_vision')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Misi -->
            <div class="mb-6">
                <label for="about_mission" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Misi <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea 
                    id="about_mission" 
                    name="about_mission" 
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('about_mission') border-red-500 @enderror"
                    required
                >{{ old('about_mission', setting('about_mission', "• Meningkatkan kapasitas pengelola jurnal melalui pelatihan dan pendampingan\n• Memfasilitasi kolaborasi antar pengelola jurnal komunikasi\n• Mendukung akreditasi dan peningkatan kualitas jurnal\n• Membangun jejaring dengan organisasi profesi sejenis")) }}</textarea>
                @error('about_mission')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Gunakan bullet point (•) atau tanda (-) di awal setiap baris untuk membuat daftar misi. Satu misi per baris.</p>
            </div>

            <!-- Sejarah Section -->
            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Section Sejarah
                </h3>

                <!-- Judul Section Sejarah -->
                <div class="mb-4">
                    <label for="about_history_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Section Sejarah <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="about_history_title" 
                        name="about_history_title" 
                        value="{{ old('about_history_title', setting('about_history_title', 'Sejarah APJIKOM')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('about_history_title') border-red-500 @enderror"
                        required
                    >
                    @error('about_history_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Sejarah -->
                <div class="mb-4">
                    <label for="about_history" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Sejarah <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="about_history" 
                        name="about_history" 
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('about_history') border-red-500 @enderror"
                        required
                    >{{ old('about_history', setting('about_history', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi (APJIKOM) didirikan sebagai wadah profesional bagi para pengelola jurnal ilmiah di bidang Ilmu Komunikasi. Organisasi ini lahir dari kebutuhan untuk meningkatkan kualitas pengelolaan jurnal ilmiah dan membangun standar profesional dalam publikasi ilmiah di Indonesia.')) }}</textarea>
                    @error('about_history')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Tahun Berdiri -->
                    <div class="bg-white p-4 rounded-lg border">
                        <label for="about_founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Tahun Berdiri
                            </span>
                        </label>
                        <input 
                            type="text" 
                            id="about_founded_year" 
                            name="about_founded_year" 
                            maxlength="4"
                            value="{{ old('about_founded_year', setting('about_founded_year', '2020')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-center text-xl font-bold text-purple-600"
                            required
                        >
                        <input 
                            type="text" 
                            id="about_stat1_label" 
                            name="about_stat1_label" 
                            value="{{ old('about_stat1_label', setting('about_stat1_label', 'Tahun Berdiri')) }}"
                            class="w-full mt-2 px-3 py-1 border border-gray-200 rounded text-sm text-center text-gray-600"
                            placeholder="Label statistik"
                        >
                    </div>

                    <!-- Anggota Aktif -->
                    <div class="bg-white p-4 rounded-lg border">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                Anggota Aktif
                            </span>
                        </label>
                        <div class="text-center text-xl font-bold text-indigo-600 py-2 bg-indigo-50 rounded-lg">
                            {{ App\Models\Member::where('status', 'active')->count() }}+
                        </div>
                        <input 
                            type="text" 
                            id="about_stat2_label" 
                            name="about_stat2_label" 
                            value="{{ old('about_stat2_label', setting('about_stat2_label', 'Anggota Aktif')) }}"
                            class="w-full mt-2 px-3 py-1 border border-gray-200 rounded text-sm text-center text-gray-600"
                            placeholder="Label statistik"
                        >
                        <p class="text-xs text-gray-400 mt-1 text-center">Otomatis dari database</p>
                    </div>

                    <!-- Kegiatan -->
                    <div class="bg-white p-4 rounded-lg border">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Kegiatan
                            </span>
                        </label>
                        <div class="text-center text-xl font-bold text-blue-600 py-2 bg-blue-50 rounded-lg">
                            {{ App\Models\Event::count() }}+
                        </div>
                        <input 
                            type="text" 
                            id="about_stat3_label" 
                            name="about_stat3_label" 
                            value="{{ old('about_stat3_label', setting('about_stat3_label', 'Kegiatan')) }}"
                            class="w-full mt-2 px-3 py-1 border border-gray-200 rounded text-sm text-center text-gray-600"
                            placeholder="Label statistik"
                        >
                        <p class="text-xs text-gray-400 mt-1 text-center">Otomatis dari database</p>
                    </div>
                </div>
            </div>

            <!-- Struktur Organisasi Section -->
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Section Struktur Organisasi
                </h3>

                <div class="mb-4">
                    <label for="about_structure_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Section <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="about_structure_title" 
                        name="about_structure_title" 
                        value="{{ old('about_structure_title', setting('about_structure_title', 'Struktur Organisasi')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required
                    >
                </div>

                <div class="bg-white p-4 rounded-lg border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Data struktur organisasi dikelola di menu terpisah</p>
                            <p class="text-xs text-gray-400 mt-1">Klik tombol di samping untuk mengelola pengurus dan divisi</p>
                        </div>
                        <a href="{{ route('admin.organizational-structure.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Kelola Struktur
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mb-6 p-4 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    Section CTA (Call to Action)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Judul CTA -->
                    <div>
                        <label for="about_cta_title" class="block text-sm font-medium text-purple-100 mb-2">
                            Judul CTA <span class="text-red-300">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="about_cta_title" 
                            name="about_cta_title" 
                            value="{{ old('about_cta_title', setting('about_cta_title', 'Bergabung Bersama Kami')) }}"
                            class="w-full px-3 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-white bg-white/90"
                            required
                        >
                    </div>

                    <!-- Subtitle CTA -->
                    <div>
                        <label for="about_cta_subtitle" class="block text-sm font-medium text-purple-100 mb-2">
                            Subtitle CTA <span class="text-red-300">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="about_cta_subtitle" 
                            name="about_cta_subtitle" 
                            value="{{ old('about_cta_subtitle', setting('about_cta_subtitle', 'Jadilah bagian dari komunitas pengelola jurnal komunikasi terbesar di Indonesia')) }}"
                            class="w-full px-3 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-white bg-white/90"
                            required
                        >
                    </div>

                    <!-- Tombol Utama -->
                    <div>
                        <label for="about_cta_button1_text" class="block text-sm font-medium text-purple-100 mb-2">
                            Teks Tombol Utama
                        </label>
                        <input 
                            type="text" 
                            id="about_cta_button1_text" 
                            name="about_cta_button1_text" 
                            value="{{ old('about_cta_button1_text', setting('about_cta_button1_text', 'Daftar Sekarang')) }}"
                            class="w-full px-3 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-white bg-white/90"
                        >
                    </div>

                    <!-- Tombol Sekunder -->
                    <div>
                        <label for="about_cta_button2_text" class="block text-sm font-medium text-purple-100 mb-2">
                            Teks Tombol Sekunder
                        </label>
                        <input 
                            type="text" 
                            id="about_cta_button2_text" 
                            name="about_cta_button2_text" 
                            value="{{ old('about_cta_button2_text', setting('about_cta_button2_text', 'Lihat Layanan')) }}"
                            class="w-full px-3 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-white bg-white/90"
                        >
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('about.index') }}" target="_blank" class="px-6 py-2 border border-purple-300 text-purple-600 rounded-lg hover:bg-purple-50 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat Halaman
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
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
