@extends('layouts.main')

@section('title', ($member->user->name ?? $member->institution_name) . ' - Direktori Anggota')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
            </a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('directory.index') }}" class="hover:text-blue-600 transition-colors">Direktori Anggota</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 font-medium">{{ $member->user->name ?? $member->institution_name }}</span>
        </nav>
    </div>
</div>

<!-- Profile Hero -->
<div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white py-12 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300 rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col items-center text-center gap-6">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
                <div class="w-48 h-48 rounded-full border-8 border-white shadow-2xl overflow-hidden bg-white">
                    @php
                        $photoUrl = null;
                        $photoPath = $member->user->photo ?? $member->photo;
                        
                        if ($photoPath) {
                            // Cek jika photo adalah full URL
                            if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
                                $photoUrl = $photoPath;
                            } else {
                                // Jika path dimulai dengan 'member-photos/', tambahkan storage/
                                if (strpos($photoPath, 'member-photos/') === 0) {
                                    $photoUrl = asset('storage/' . $photoPath);
                                } elseif (strpos($photoPath, 'storage/') === 0) {
                                    $photoUrl = asset($photoPath);
                                } else {
                                    $photoUrl = asset('storage/' . $photoPath);
                                }
                            }
                        }
                    @endphp
                    
                    @if($photoUrl)
                    <img src="{{ $photoUrl }}" 
                         alt="{{ $member->user->name ?? $member->institution_name }}" 
                         class="w-full h-full object-cover"
                         onerror="console.error('Failed to load image:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full hidden items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                        <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                    </div>
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                        <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                
                <!-- Member Type Badge - Dipindah ke bawah -->
                <div class="mt-4">
                    @if($member->member_type === 'individual')
                    <span class="inline-block px-4 py-2 bg-white text-blue-600 text-sm font-bold rounded-full shadow-lg">
                        👤 Anggota Perorangan
                    </span>
                    @else
                    <span class="inline-block px-4 py-2 bg-white text-purple-600 text-sm font-bold rounded-full shadow-lg">
                        🏢 Institusi
                    </span>
                    @endif
                </div>
            </div>
            
            <!-- Profile Info -->
            <div class="flex-1">
                <div class="flex flex-col items-center gap-3 mb-3">
                    <h1 class="text-4xl font-bold">{{ $member->user->name ?? $member->institution_name }}</h1>
                    <x-verified-badge :member="$member" size="lg" />
                </div>
                
                @if($member->position || $member->institution_name)
                <p class="text-xl text-blue-100 mb-4">
                    @if($member->position)
                    <span class="font-medium">{{ $member->position }}</span>
                    @endif
                    @if($member->position && $member->institution_name)
                    <span> · </span>
                    @endif
                    @if($member->institution_name)
                    <span>{{ $member->institution_name }}</span>
                    @endif
                </p>
                @endif
                
                <!-- Social Media Links -->
                @if($member->linkedin || $member->facebook || $member->twitter || $member->instagram)
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        LinkedIn
                    </a>
                    @endif
                    
                    @if($member->facebook)
                    <a href="{{ $member->facebook }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    @endif
                    
                    @if($member->twitter)
                    <a href="https://twitter.com/{{ ltrim($member->twitter, '@') }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Twitter
                    </a>
                    @endif
                    
                    @if($member->instagram)
                    <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Profile Content -->
<div class="py-12 bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Biography -->
                    @if($member->bio)
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Tentang
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! nl2br(e($member->bio)) !!}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Expertise -->
                    @if($member->expertise)
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Keahlian & Bidang
                        </h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach(explode(',', $member->expertise) as $skill)
                            <span class="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 text-gray-800 font-semibold rounded-lg">
                                {{ trim($skill) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- No Bio/Expertise Message -->
                    @if(!$member->bio && !$member->expertise)
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600">Anggota belum menambahkan informasi detail profil.</p>
                    </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Member Info Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Anggota</h3>
                        
                        <div class="space-y-4">
                            <!-- Member Number -->
                            @if($member->member_number)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">No. Anggota</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $member->member_number }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Join Date -->
                            @if($member->join_date)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Bergabung</p>
                                    <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($member->join_date)->format('d F Y') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Masa Berlaku -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Masa Berlaku</p>
                                    <p class="text-sm font-bold text-emerald-600">Seumur Hidup</p>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Status</p>
                                    <p class="text-sm font-bold text-green-600">Aktif</p>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            @if($member->email)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Email</p>
                                    <a href="mailto:{{ $member->email }}" class="text-sm font-bold text-purple-600 hover:underline break-all">
                                        {{ $member->email }}
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Website -->
                            @if($member->website)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Website</p>
                                    <a href="{{ $member->website }}" target="_blank" rel="noopener noreferrer" 
                                       class="text-sm font-bold text-orange-600 hover:underline break-all">
                                        {{ parse_url($member->website, PHP_URL_HOST) ?? $member->website }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Back to Directory Button -->
                    <a href="{{ route('directory.index') }}" 
                       class="block w-full text-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105">
                        ← Kembali ke Direktori
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
