@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')
<!-- Birthday Greeting Component -->
@include('components.birthday-greeting')

<div class="space-y-6">
    <!-- First Login Welcome Message -->
    @if(session('first_login'))
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold text-blue-800">
                    🎉 Selamat Datang di APJIKOM!
                </h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2">Terima kasih telah bergabung. Password default Anda adalah <strong>password123</strong></p>
                    <p class="font-medium">Untuk keamanan, segera:</p>
                    <ol class="list-decimal list-inside space-y-1 ml-2 mt-1">
                        <li>Lengkapi profil dan upload foto Anda</li>
                        <li>Ubah password default ke password yang lebih aman</li>
                        <li>Pastikan data kontak Anda benar</li>
                    </ol>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('member.profile') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                        Lengkapi Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Incomplete Alert -->
    @if(isset($needsProfileUpdate) && $needsProfileUpdate)
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold text-orange-800">
                    Lengkapi Profil Anda untuk Kartu Anggota (KTA)
                </h3>
                <div class="mt-2 text-sm text-orange-700">
                    <p class="mb-2">Data profil Anda belum lengkap. Silakan lengkapi:</p>
                    <ul class="list-disc list-inside space-y-1 ml-2">
                        @foreach($missingItems as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-3 font-medium">
                        Data lengkap diperlukan untuk pembuatan Kartu Tanda Anggota (KTA) yang valid.
                    </p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('member.profile') }}" 
                       class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Lengkapi Profil Sekarang
                    </a>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 flex-shrink-0 text-orange-400 hover:text-orange-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Welcome Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl card-shadow p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-center sm:text-left">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm sm:text-base">No. Anggota: <span class="font-semibold text-purple-600">{{ $member->member_number ?? 'Belum ada' }}</span></p>
            </div>
            <div class="w-16 h-16 sm:w-20 sm:h-20 gradient-purple rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Anggota -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Status Keanggotaan</h3>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ ucfirst($member->status) }}</p>
            <p class="text-sm text-gray-500 mt-1">Member sejak {{ $member->created_at->format('d M Y') }}</p>
        </div>

        <!-- Masa Berlaku -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Masa Berlaku</h3>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            @if(true)
                <p class="text-2xl font-bold text-green-600">Seumur Hidup</p>
                @php
                    $daysLeft = 999999; // Lifetime membership
                @endphp
                @if($daysLeft > 0)
                    <p class="text-sm text-gray-500 mt-1">{{ $daysLeft }} hari lagi</p>
                @else
                    <p class="text-sm text-red-500 mt-1">Sudah berakhir</p>
                @endif
            @else
                <p class="text-gray-500">Belum diatur</p>
            @endif
        </div>

        <!-- Kartu Anggota -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Kartu Anggota</h3>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
            @if($member->member_card)
                <p class="text-2xl font-bold text-green-600">Tersedia</p>
                <a href="{{ route('member.card') }}" class="text-sm text-purple-600 hover:text-purple-800 mt-1 inline-block">
                    Lihat kartu →
                </a>
            @else
                <p class="text-2xl font-bold text-orange-600">Belum Ada</p>
                <p class="text-sm text-gray-500 mt-1">Hubungi admin</p>
            @endif
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl card-shadow p-6 text-white">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold">Ikuti Media Sosial Kami :</h3>
                <p class="text-purple-100 mt-1">Tetap terhubung dengan update terbaru dari APJIKOM</p>
            </div>
        </div>
        
        @php
            $socialMedia = \App\Models\SocialMedia::where('is_active', true)
                ->orderBy('order')
                ->get();
        @endphp

        @if($socialMedia->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($socialMedia as $social)
            <a href="{{ $social->url }}" 
               target="_blank"
               class="bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl p-4 transition-all duration-300 hover:scale-105 group">
                <div class="flex flex-col items-center space-y-3">
                    @php
                        $platformName = strtolower($social->name);
                    @endphp
                    
                    @if(str_contains($platformName, 'facebook'))
                        <div class="w-16 h-16 rounded-xl bg-[#1877F2] flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'instagram'))
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'twitter') || str_contains($platformName, 'x'))
                        <div class="w-16 h-16 rounded-xl bg-black flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'youtube'))
                        <div class="w-16 h-16 rounded-xl bg-[#FF0000] flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-11 h-11 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'linkedin'))
                        <div class="w-16 h-16 rounded-xl bg-[#0A66C2] flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'tiktok'))
                        <div class="w-16 h-16 rounded-xl bg-black flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'whatsapp'))
                        <div class="w-16 h-16 rounded-xl bg-[#25D366] flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                    @elseif(str_contains($platformName, 'telegram'))
                        <div class="w-16 h-16 rounded-xl bg-[#26A5E4] flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-16 h-16 rounded-xl bg-white flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-10 h-10 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="text-center">
                        <p class="font-semibold text-white text-sm">{{ $social->name }}</p>
                        @if($social->note)
                        <p class="text-xs text-purple-100 mt-1 line-clamp-2">{{ $social->note }}</p>
                        @endif
                    </div>
                    <svg class="w-5 h-5 text-white/70 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-white/70">Belum ada media sosial yang tersedia</p>
        </div>
        @endif
    </div>

    <!-- Member Card Preview -->
    @if($member->member_card)
    <div class="bg-white rounded-xl card-shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Kartu Anggota Anda</h3>
        <div class="max-w-2xl mx-auto">
            <img src="{{ Storage::url($member->member_card) }}" 
                 alt="Kartu Anggota" 
                 class="w-full rounded-lg shadow-lg">
            <div class="mt-4 text-center">
                <a href="{{ route('member.card') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Kartu
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profile Info -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Profil</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Institusi</span>
                    <span class="font-medium text-gray-800">{{ $member->institution_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email</span>
                    <span class="font-medium text-gray-800">{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kontak</span>
                    <span class="font-medium text-gray-800">{{ $member->phone ?? '-' }}</span>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                @if($member->cv_file)
                <a href="{{ asset('storage/' . $member->cv_file) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Lihat CV Saya
                </a>
                @endif
                <a href="{{ route('member.profile') }}" 
                   class="block text-purple-600 hover:text-purple-800 font-medium">
                    Lihat Detail Profil →
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Menu Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('member.profile') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Edit Profil</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('member.card') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Download Kartu</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('news.index') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Lihat Berita</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('events.index') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Lihat Event</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['total_members'] ?? 0 }}</p>
            <p class="text-blue-100 text-sm mt-1">Total Anggota Aktif</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['total_news'] ?? 0 }}</p>
            <p class="text-green-100 text-sm mt-1">Berita Tersedia</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['upcoming_events'] ?? 0 }}</p>
            <p class="text-purple-100 text-sm mt-1">Event Mendatang</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['total_journals'] ?? 0 }}</p>
            <p class="text-orange-100 text-sm mt-1">Jurnal Ilmiah</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Member Growth Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">📈 Pertumbuhan Anggota</h3>
                <span class="text-xs text-gray-500">6 Bulan Terakhir</span>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="memberGrowthChart"></canvas>
            </div>
        </div>

        <!-- Activity Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">📊 Ringkasan Konten</h3>
                <span class="text-xs text-gray-500">Total Publikasi</span>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Recent News -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Berita Terbaru</h3>
                <a href="{{ route('news.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentNews ?? [] as $news)
                    <a href="{{ route('news.show', $news) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2">{{ $news->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $news->published_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada berita</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Event Mendatang</h3>
                <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($upcomingEvents ?? [] as $event)
                    <a href="{{ route('events.show', $event) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2">{{ $event->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada event</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Journals -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Jurnal Terbaru</h3>
                <a href="{{ route('journals.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentJournals ?? [] as $journal)
                    <a href="{{ route('journals.show', $journal) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2">{{ $journal->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $journal->published_date->format('Y') }} - Vol. {{ $journal->volume }}</p>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada jurnal</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Member Growth Chart
    const memberGrowthCtx = document.getElementById('memberGrowthChart').getContext('2d');
    new Chart(memberGrowthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(($memberGrowth ?? collect())->pluck('month')->map(function($m) {
                return \Carbon\Carbon::parse($m)->format('M Y');
            })) !!},
            datasets: [{
                label: 'Anggota Baru',
                data: {!! json_encode(($memberGrowth ?? collect())->pluck('count')) !!},
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(99, 102, 241)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Activity Overview Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'doughnut',
        data: {
            labels: ['Berita', 'Event', 'Jurnal'],
            datasets: [{
                data: [
                    {{ $stats['total_news'] ?? 0 }},
                    {{ $stats['total_events'] ?? 0 }},
                    {{ $stats['total_journals'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(168, 85, 247)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 10
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
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
@endsection
