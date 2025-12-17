@extends('layouts.main')

@section('title', 'Tentang Kami')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">{{ setting('about_page_title', 'Tentang APJIKOM') }}</h1>
            <p class="text-xl text-purple-100 border border-purple-300/50 inline-block px-6 py-2 rounded">{{ setting('about_page_subtitle', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia') }}</p>
        </div>
    </div>
</div>

<!-- Visi Misi Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Visi -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Visi</h2>
                </div>
                <p class="text-lg text-gray-700 leading-relaxed">
                    {{ setting('about_vision', 'Menjadi organisasi profesional yang terpercaya dalam meningkatkan kualitas dan kredibilitas jurnal ilmu komunikasi di Indonesia.') }}
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Misi</h2>
                </div>
                <ul class="space-y-3 text-gray-700">
                    @php
                        $missionText = setting('about_mission', "• Meningkatkan kapasitas pengelola jurnal melalui pelatihan dan pendampingan\n• Memfasilitasi kolaborasi antar pengelola jurnal komunikasi\n• Mendukung akreditasi dan peningkatan kualitas jurnal\n• Membangun jejaring dengan organisasi profesi sejenis");
                        $missions = array_filter(array_map('trim', explode("\n", $missionText)));
                    @endphp
                    @foreach($missions as $mission)
                        @if($mission)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ ltrim($mission, '•-* ') }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Sejarah Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ setting('about_history_title', 'Sejarah APJIKOM') }}</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded"></div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ setting('about_history', 'Asosiasi Pengelola Jurnal Ilmu Komunikasi Indonesia (APJIKOM) didirikan sebagai wadah bagi para pengelola jurnal ilmiah di bidang ilmu komunikasi untuk saling berbagi pengalaman, pengetahuan, dan best practices dalam pengelolaan jurnal ilmiah.') }}
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="text-center p-6 bg-purple-50 rounded-xl">
                            <div class="text-4xl font-bold text-purple-600 mb-2">{{ setting('about_founded_year', '2020') }}</div>
                            <div class="text-gray-600">{{ setting('about_stat1_label', 'Tahun Berdiri') }}</div>
                        </div>
                        <div class="text-center p-6 bg-indigo-50 rounded-xl">
                            <div class="text-4xl font-bold text-indigo-600 mb-2">{{ App\Models\Member::where('status', 'active')->count() }}+</div>
                            <div class="text-gray-600">{{ setting('about_stat2_label', 'Anggota Aktif') }}</div>
                        </div>
                        <div class="text-center p-6 bg-blue-50 rounded-xl">
                            <div class="text-4xl font-bold text-blue-600 mb-2">{{ App\Models\Event::count() }}+</div>
                            <div class="text-gray-600">{{ setting('about_stat3_label', 'Kegiatan') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Struktur Organisasi Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ setting('about_structure_title', 'Struktur Organisasi') }}</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded"></div>
        </div>

        <div class="max-w-6xl mx-auto">
            <!-- Leadership (Pengurus Inti) -->
            @if($leadership->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-{{ min($leadership->count(), 3) }} gap-6 mb-12">
                    @foreach($leadership as $person)
                        <div class="text-center">
                            @if($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                    {{ substr($person->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl px-6 py-4 shadow-lg">
                                <div class="text-sm font-semibold mb-1">{{ $person->position }}</div>
                                <div class="text-lg font-bold">{{ $person->name }}</div>
                            </div>
                            @if($person->description)
                                <p class="text-sm text-gray-600 mt-3">{{ $person->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Divisions (Divisi) -->
            @if($divisions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    @foreach($divisions as $index => $division)
                        @php
                            $colors = ['purple', 'indigo', 'blue', 'cyan', 'teal', 'green'];
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div class="bg-white border-2 border-{{ $color }}-200 rounded-xl p-6 hover:shadow-lg transition">
                            <div class="flex items-start gap-4">
                                @if($division->photo)
                                    <img src="{{ asset('storage/' . $division->photo) }}" alt="{{ $division->name }}" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-{{ $color }}-100 flex items-center justify-center text-{{ $color }}-600 text-xl font-bold">
                                        {{ substr($division->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-{{ $color }}-600 mb-1">{{ $division->division_name }}</h3>
                                    <p class="text-sm text-gray-700 font-semibold mb-1">{{ $division->position }}: {{ $division->name }}</p>
                                    @if($division->description)
                                        <p class="text-sm text-gray-600">{{ $division->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback jika belum ada data dari database -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="bg-white border-2 border-purple-200 rounded-xl p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-bold text-purple-600 mb-3">Divisi Pengembangan</h3>
                        <p class="text-gray-600">Bertanggung jawab atas pelatihan dan pengembangan kapasitas anggota</p>
                    </div>
                    <div class="bg-white border-2 border-indigo-200 rounded-xl p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-bold text-indigo-600 mb-3">Divisi Kerjasama</h3>
                        <p class="text-gray-600">Menjalin kemitraan dengan organisasi dan institusi terkait</p>
                    </div>
                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-bold text-blue-600 mb-3">Divisi Publikasi</h3>
                        <p class="text-gray-600">Mengelola publikasi dan komunikasi organisasi</p>
                    </div>
                    <div class="bg-white border-2 border-cyan-200 rounded-xl p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-bold text-cyan-600 mb-3">Divisi Akreditasi</h3>
                        <p class="text-gray-600">Membantu jurnal dalam proses akreditasi dan peningkatan kualitas</p>
                    </div>
                </div>
            @endif
                    <p class="text-gray-600">Mendampingi anggota dalam proses akreditasi jurnal</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">{{ setting('about_cta_title', 'Bergabung Bersama Kami') }}</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
            {{ setting('about_cta_subtitle', 'Jadilah bagian dari komunitas pengelola jurnal komunikasi terbesar di Indonesia') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('registration.create') }}" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                {{ setting('about_cta_button1_text', 'Daftar Sekarang') }}
            </a>
            <a href="{{ route('services.index') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ setting('about_cta_button2_text', 'Lihat Layanan') }}
            </a>
        </div>
    </div>
</section>
@endsection
