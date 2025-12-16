@extends('layouts.main')

@section('title', 'Divisi Jurnal')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Divisi Jurnal</h1>
            <p class="text-xl text-blue-100">Berbagai divisi dan fokus penelitian jurnal ilmiah {{ site_name() }}</p>
        </div>
    </div>
</div>

<!-- Divisions Grid -->
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($divisions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @foreach($divisions as $division)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <!-- Cover Image -->
                <div class="relative h-56 bg-gradient-to-br from-blue-100 to-purple-100">
                    @if($division->cover)
                    <img src="{{ asset('storage/' . $division->cover) }}" 
                         alt="{{ $division->division }}" 
                         class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Order Badge -->
                    @if($division->order)
                    <div class="absolute top-3 left-3">
                        <span class="inline-block w-10 h-10 bg-blue-600 text-white text-sm font-bold rounded-full shadow-lg flex items-center justify-center">
                            {{ $division->order }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Division Name -->
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ $division->division }}
                    </h3>

                    <!-- Main Focus -->
                    <div class="mb-4">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Fokus Utama</p>
                                <p class="text-sm text-gray-700">{{ $division->main_focus }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Journal Potential -->
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Potensi Jurnal</p>
                                <p class="text-sm text-gray-700">{{ $division->journal_potential }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Badge -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Divisi</h3>
            <p class="text-gray-600">Divisi jurnal akan segera tersedia.</p>
        </div>
        @endif
    </div>
</div>

<!-- Info Section -->
<div class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tentang Divisi Jurnal</h2>
            <p class="text-lg text-gray-600 mb-6">
                Setiap divisi jurnal memiliki fokus penelitian yang spesifik dan potensi publikasi yang berbeda. 
                Divisi-divisi ini membantu mengorganisir dan mengkategorikan berbagai bidang penelitian dalam 
                komunitas ilmiah kami.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Terorganisir</h3>
                    <p class="text-sm text-gray-600">Divisi yang terstruktur dengan baik</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Fokus Jelas</h3>
                    <p class="text-sm text-gray-600">Setiap divisi memiliki fokus spesifik</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Potensi Tinggi</h3>
                    <p class="text-sm text-gray-600">Peluang publikasi yang luas</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
