@extends('layouts.admin')

@section('title', 'Migration Helper')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-green-800">{!! session('success') !!}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-6 mb-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-red-800">{!! session('error') !!}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Warning Card -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Migration Helper</h3>
                    <p class="text-yellow-700 text-sm">
                        Tool ini akan menjalankan migration untuk membuat tabel baru di database.
                        Gunakan dengan hati-hati!
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Jalankan Migration</h2>
            <p class="text-gray-600 mb-6">
                Klik tombol di bawah untuk menjalankan migration database. 
                Ini akan membuat tabel <code class="bg-gray-100 px-2 py-1 rounded text-sm">partners</code> 
                dan tabel lain yang belum ada.
            </p>

            <!-- Migration Status -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-900 mb-2">Yang akan dijalankan:</h3>
                <ul class="list-disc list-inside text-blue-800 text-sm space-y-1">
                    <li>Migration: create_partners_table</li>
                    <li>Dan migration pending lainnya</li>
                </ul>
            </div>

            <!-- Action Button -->
            <form action="{{ route('admin.run-migration') }}" method="POST">
                @csrf
                <div class="flex items-center space-x-4">
                    <button type="submit" 
                            onclick="return confirm('Yakin ingin menjalankan migration?')"
                            class="px-6 py-3 bg-[#00629B] hover:bg-[#003A5D] text-white rounded-lg transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        <span>Jalankan Migration Sekarang</span>
                    </button>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-gray-50 rounded-lg p-6">
            <h3 class="font-semibold text-gray-900 mb-3">Alternatif via Terminal:</h3>
            <div class="bg-gray-900 text-gray-100 p-4 rounded font-mono text-sm">
                <code>php artisan migrate</code>
            </div>
            <p class="text-gray-600 text-sm mt-3">
                Atau buka terminal baru (karena server sedang running) dan jalankan command di atas.
            </p>
        </div>
    </div>
</div>
@endsection
