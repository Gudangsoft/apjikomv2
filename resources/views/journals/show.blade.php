@extends('layouts.main')

@section('title', $journal->title)

@section('content')
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('journals.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium mb-6 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Jurnal
            </a>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white p-8">
                    @if($journal->category)
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full mb-4">
                        {{ $journal->category }}
                    </span>
                    @endif
                    
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">{{ $journal->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-blue-100">
                        @if($journal->volume || $journal->issue)
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Volume {{ $journal->volume }}@if($journal->issue), Nomor {{ $journal->issue }}@endif
                        </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tahun {{ $journal->year }}
                        </span>
                        @if($journal->pages)
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Halaman {{ $journal->pages }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Authors -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Penulis
                            </h2>
                            <p class="text-gray-700 leading-relaxed">{{ $journal->authors }}</p>
                        </div>

                        <!-- Abstract -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Abstrak
                            </h2>
                            <div class="text-gray-700 leading-relaxed text-justify">
                                {{ $journal->abstract }}
                            </div>
                        </div>

                        <!-- Keywords -->
                        @if($journal->keywords)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kata Kunci
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $journal->keywords) as $keyword)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- DOI -->
                        @if($journal->doi)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                DOI
                            </h2>
                            <p class="text-blue-600 font-mono">{{ $journal->doi }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Cover Image -->
                        @if($journal->cover_image)
                        <div class="bg-gray-100 rounded-xl p-4">
                            <img src="{{ Storage::url($journal->cover_image) }}" 
                                 alt="{{ $journal->title }}" 
                                 class="w-full rounded-lg shadow-lg">
                        </div>
                        @endif

                        <!-- Statistics -->
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                </svg>
                                Statistik
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Views
                                    </span>
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($journal->views) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Downloads
                                    </span>
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($journal->downloads) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Download Button -->
                        @if($journal->file_path)
                        <a href="{{ route('journals.download', $journal) }}" 
                           class="flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download PDF
                        </a>
                        @endif

                        <!-- Publication Info -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="font-bold text-gray-900 mb-4">Informasi Publikasi</h3>
                            <div class="space-y-2 text-sm">
                                @if($journal->published_date)
                                <div>
                                    <span class="text-gray-600">Tanggal Publikasi:</span>
                                    <span class="block font-semibold text-gray-900 mt-1">{{ $journal->published_date->format('d F Y') }}</span>
                                </div>
                                @endif
                                <div>
                                    <span class="text-gray-600">Tahun:</span>
                                    <span class="block font-semibold text-gray-900 mt-1">{{ $journal->year }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
