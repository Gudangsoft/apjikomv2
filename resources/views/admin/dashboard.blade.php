@extends('layouts.admin')

@section('page-title', 'Dashboard')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-[#00629B] to-[#003A5D] rounded-lg shadow-lg p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6 lg:mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 sm:mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-xs sm:text-sm text-blue-100">Kelola konten website APJIKOM dengan mudah</p>
        </div>
        <div class="hidden md:block">
            <svg class="w-16 h-16 lg:w-24 lg:h-24 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-400 p-6 mb-6 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm text-green-800">{!! session('success') !!}</p>
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
        <div class="flex-1">
            <p class="text-sm text-red-800 mb-3">{!! session('error') !!}</p>
            @if(str_contains(session('error'), 'belum ada') || str_contains(session('error'), 'migration'))
            <a href="{{ route('admin.run-migration') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Jalankan Migration
            </a>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Migration Alert (Only show if error exists) -->
@if(session('error') && str_contains(session('error'), 'migration'))
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-lg">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-medium text-yellow-800">Setup Database Diperlukan</h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p>Table slider belum ada di database. Klik tombol di bawah untuk menjalankan migration secara otomatis.</p>
            </div>
            <div class="mt-4">
                <a href="/admin/run-migration" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                   onclick="return confirm('Apakah Anda yakin ingin menjalankan migration?')">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Jalankan Migration Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6 lg:mb-8">
    <!-- Total News -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 sm:p-5 lg:p-6 border-l-4 border-[#00629B]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Berita</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_news'] }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded">{{ $stats['published_news'] }} Published</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Events -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Kegiatan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_events'] }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded">{{ $stats['upcoming_events'] }} Mendatang</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Members -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Members</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded">{{ $stats['active_members'] }} Aktif</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Pending Members -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Pending Approval</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_members'] }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded">Perlu Review</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Member Type Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Institution Members -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Anggota PT</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($membersByType['institution'] ?? 0) }}{{ ($membersByType['institution'] ?? 0) >= 1000 ? '+' : '' }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded">Institusi</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Individual Members -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Anggota Bergabung</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($membersByType['individual'] ?? 0) }}{{ ($membersByType['individual'] ?? 0) >= 1000 ? '+' : '' }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Perorangan</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Active Members -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Anggota Aktif</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['active_members']) }}{{ $stats['active_members'] >= 1000 ? '+' : '' }}</p>
                <div class="mt-2 flex items-center">
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded">Status Aktif</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Satisfaction Rate -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-pink-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Tingkat Kepuasan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $satisfactionRate }}%</p>
                <div class="mt-2 flex items-center">
                    <a href="{{ route('admin.settings.index') }}" class="text-xs font-medium text-pink-600 bg-pink-50 px-2 py-1 rounded hover:bg-pink-100 transition-colors">Edit</a>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-pink-50 to-pink-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Registrations -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Total Pendaftaran</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_registrations'] }}</h3>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Registrations -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Menunggu Persetujuan</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['pending_registrations'] }}</h3>
                    @if($stats['pending_registrations'] > 0)
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">Perlu Review</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Approved Registrations -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Pendaftaran Disetujui</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['approved_registrations'] }}</h3>
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Aktif</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.news.create') }}" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-[#00629B] hover:bg-blue-50 transition-all">
            <div class="w-12 h-12 bg-[#00629B] rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-[#00629B]">Tambah Berita</span>
        </a>
        
        <a href="{{ route('admin.events.create') }}" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition-all">
            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-purple-500">Tambah Kegiatan</span>
        </a>
        
        <a href="{{ route('admin.categories.create') }}" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-indigo-500 hover:bg-indigo-50 transition-all">
            <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-500">Tambah Kategori</span>
        </a>
        
        <a href="{{ route('home') }}" target="_blank" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-green-500 hover:bg-green-50 transition-all">
            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-green-500">Lihat Website</span>
        </a>
    </div>
</div>

<!-- Recent Activities -->
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
            <span class="text-sm text-gray-500">Last 10 activities</span>
        </div>
        
        <div class="space-y-4">
            @php
                $activities = \App\Models\ActivityLog::with('user')
                    ->latest()
                    ->limit(10)
                    ->get();
            @endphp
            
            @forelse($activities as $activity)
            <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="flex-shrink-0 mt-1">
                    @if($activity->type == 'registration')
                        <span class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </span>
                    @elseif($activity->type == 'post')
                        <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </span>
                    @elseif($activity->type == 'auth')
                        <span class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                    @else
                        <span class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-800 font-medium">{{ $activity->description }}</p>
                    <div class="flex items-center space-x-2 mt-1">
                        @if($activity->user)
                            <p class="text-xs text-gray-500">by {{ $activity->user->name }}</p>
                            <span class="text-gray-300">•</span>
                        @endif
                        <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded">
                        {{ ucfirst($activity->action) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Belum ada aktivitas</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Analytics & Insights -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Analytics & Insights</h2>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">Last 6 Months</span>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Member Growth Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Member Growth Trend</h3>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">
                        +{{ $recentMemberCount ?? 0 }} this week
                    </span>
                </div>
            </div>
            <canvas id="memberGrowthChart" height="250"></canvas>
        </div>

        <!-- Member Status Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Status Distribution</h3>
            <canvas id="statusDistributionChart" height="250"></canvas>
        </div>

        <!-- Member Type Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Type Distribution</h3>
            <canvas id="typeDistributionChart" height="250"></canvas>
        </div>

        <!-- Top Institutions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 5 Institutions</h3>
            <canvas id="topInstitutionsChart" height="250"></canvas>
        </div>

        <!-- Registration Trend -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Registration Trend</h3>
            <canvas id="registrationTrendChart" height="250"></canvas>
        </div>

        <!-- Event Registrations Status -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event RSVP Status</h3>
            <canvas id="eventRegsChart" height="250"></canvas>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-800 mb-1">Total Journals</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $stats['total_journals'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border-2 border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-800 mb-1">Event Registrations</p>
                    <p class="text-3xl font-bold text-purple-900">{{ $stats['total_event_registrations'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border-2 border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-800 mb-1">Cards Pending</p>
                    <p class="text-3xl font-bold text-yellow-900">{{ $cardsPending ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-500 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent News -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#00629B] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Berita Terbaru</h3>
                </div>
                <a href="{{ route('admin.news.index') }}" class="text-sm text-[#00629B] hover:text-[#003A5D] font-medium">Lihat Semua →</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recent_news as $news)
                <div class="flex items-start space-x-3 pb-4 border-b last:border-0 hover:bg-gray-50 p-3 rounded-lg transition">
                    <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full {{ $news->is_published ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $news->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $news->category->name }} • {{ $news->published_at?->format('d M Y') ?? 'Draft' }}</p>
                    </div>
                    <a href="{{ route('admin.news.edit', $news) }}" class="text-[#00629B] hover:text-[#003A5D]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Belum ada berita</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Pending Members -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Member Pending</h3>
                </div>
                <a href="{{ route('admin.members.index') }}" class="text-sm text-[#00629B] hover:text-[#003A5D] font-medium">Lihat Semua →</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($pending_members as $member)
                <div class="flex items-center justify-between pb-4 border-b last:border-0 hover:bg-gray-50 p-3 rounded-lg transition">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $member->user->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ ucfirst($member->member_type) }} • {{ $member->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('admin.members.approve', $member) }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Approve">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.members.reject', $member) }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Reject">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Tidak ada member yang menunggu approval</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Pending Registrations & Stats -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Pending Registrations -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gradient-to-r from-purple-50 to-white">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Pendaftaran Pending</h3>
                        @if($stats['pending_registrations'] > 0)
                            <span class="text-xs text-yellow-600 font-medium">{{ $stats['pending_registrations'] }} menunggu review</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Lihat Semua →</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($pending_registrations as $registration)
                <div class="flex items-start justify-between pb-4 border-b last:border-0 hover:bg-gray-50 p-3 rounded-lg transition">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded {{ $registration->type == 'individu' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($registration->type) }}
                            </span>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ $registration->full_name }}</p>
                        @if($registration->type == 'prodi')
                            <p class="text-xs text-gray-600">{{ $registration->institution }}</p>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $registration->email }} • {{ $registration->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <a href="{{ route('admin.registrations.show', $registration) }}" class="ml-3 px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white text-xs font-medium rounded-lg transition">
                        Review
                    </a>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Tidak ada pendaftaran yang menunggu review</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Registration Stats -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Statistik Pendaftaran</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Individu Stats -->
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Pendaftaran Individu</p>
                            <p class="text-xs text-gray-500">Rp 250.000/tahun</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">
                        {{ \App\Models\Registration::where('type', 'individu')->count() }}
                    </span>
                </div>

                <!-- Prodi Stats -->
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Pendaftaran Prodi</p>
                            <p class="text-xs text-gray-500">Rp 750.000/tahun</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-green-600">
                        {{ \App\Models\Registration::where('type', 'prodi')->count() }}
                    </span>
                </div>

                <!-- Status Breakdown -->
                <div class="pt-4 border-t">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Status Breakdown</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Pending</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded">
                                {{ $stats['pending_registrations'] }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Approved</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">
                                {{ $stats['approved_registrations'] }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Rejected</span>
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">
                                {{ \App\Models\Registration::where('status', 'rejected')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Events -->
<div class="bg-white rounded-xl shadow-sm mt-6 overflow-hidden">
    <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Kegiatan Mendatang</h3>
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-[#00629B] hover:text-[#003A5D] font-medium">Lihat Semua →</a>
        </div>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($recent_events as $event)
            <div class="group border-2 rounded-lg p-4 hover:border-[#00629B] hover:shadow-md transition-all bg-gradient-to-br from-white to-gray-50">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm text-gray-900 mb-2 group-hover:text-[#00629B] transition">{{ Str::limit($event->title, 50) }}</h4>
                        <div class="flex items-center text-xs text-gray-500 space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $event->event_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 space-x-2 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span>{{ Str::limit($event->location, 30) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-[#00629B] hover:text-[#003A5D] opacity-0 group-hover:opacity-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm text-gray-500">Belum ada kegiatan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart colors
    const colors = {
        primary: '#00629B',
        secondary: '#003A5D',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        info: '#3B82F6',
        purple: '#8B5CF6',
        pink: '#EC4899',
        indigo: '#6366F1'
    };

    // Member Growth Chart
    const memberGrowthData = @json($memberGrowth);
    const memberGrowthCtx = document.getElementById('memberGrowthChart');
    if (memberGrowthCtx) {
        new Chart(memberGrowthCtx, {
            type: 'line',
            data: {
                labels: memberGrowthData.map(item => {
                    const [year, month] = item.month.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
                }),
                datasets: [{
                    label: 'New Members',
                    data: memberGrowthData.map(item => item.count),
                    borderColor: colors.primary,
                    backgroundColor: colors.primary + '20',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Member Status Distribution Chart
    const membersByStatus = @json($membersByStatus);
    const statusCtx = document.getElementById('statusDistributionChart');
    if (statusCtx && membersByStatus && Object.keys(membersByStatus).length > 0) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(membersByStatus).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
                datasets: [{
                    data: Object.values(membersByStatus),
                    backgroundColor: [
                        colors.success,
                        colors.warning,
                        colors.danger
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
    }

    // Member Type Distribution Chart
    const membersByType = @json($membersByType);
    const typeCtx = document.getElementById('typeDistributionChart');
    if (typeCtx && membersByType && Object.keys(membersByType).length > 0) {
        new Chart(typeCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(membersByType).map(type => type === 'individual' ? 'Individual' : 'Institution'),
                datasets: [{
                    data: Object.values(membersByType),
                    backgroundColor: [
                        colors.info,
                        colors.success
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
    }

    // Top Institutions Chart
    const topInstitutions = @json($topInstitutions);
    const institutionsCtx = document.getElementById('topInstitutionsChart');
    if (institutionsCtx && topInstitutions && topInstitutions.length > 0) {
        new Chart(institutionsCtx, {
            type: 'bar',
            data: {
                labels: topInstitutions.map(item => {
                    const name = item.institution_name;
                    return name.length > 30 ? name.substring(0, 30) + '...' : name;
                }),
                datasets: [{
                    label: 'Members',
                    data: topInstitutions.map(item => item.count),
                    backgroundColor: colors.indigo,
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            title: function(context) {
                                const index = context[0].dataIndex;
                                return topInstitutions[index].institution_name;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Registration Trend Chart
    const registrationTrend = @json($registrationTrend);
    const registrationCtx = document.getElementById('registrationTrendChart');
    if (registrationCtx && registrationTrend) {
        new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: registrationTrend.map(item => {
                    const [year, month] = item.month.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
                }),
                datasets: [{
                    label: 'Registrations',
                    data: registrationTrend.map(item => item.count),
                    borderColor: colors.purple,
                    backgroundColor: colors.purple + '20',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: colors.purple,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Event Registrations Status Chart
    const eventRegsByStatus = @json($eventRegsByStatus);
    const eventRegsCtx = document.getElementById('eventRegsChart');
    if (eventRegsCtx && eventRegsByStatus && Object.keys(eventRegsByStatus).length > 0) {
        new Chart(eventRegsCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(eventRegsByStatus).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
                datasets: [{
                    data: Object.values(eventRegsByStatus),
                    backgroundColor: [
                        colors.info,
                        colors.success,
                        colors.danger
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
    }
});
</script>
@endpush
