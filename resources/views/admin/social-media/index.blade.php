@extends('layouts.admin')

@section('title', 'Kelola Media Sosial')

@section('content')
<div class="container-fluid px-4">
    <!-- Header dengan Gradient & Breadcrumbs -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm mb-2" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center text-purple-100">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </li>
                        <li class="flex items-center text-white font-semibold">
                            <span>Media Sosial</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Kelola Media Sosial
                </h1>
                <p class="text-purple-100 mt-1">Atur tautan media sosial yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.social-media.create') }}" class="bg-white text-purple-700 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 flex items-center space-x-2 hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Media Sosial</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($socialMedia->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Media Sosial</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan akun media sosial organisasi Anda</p>
            <a href="{{ route('admin.social-media.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Media Sosial Pertama
            </a>
        </div>
    @else
        <!-- Info Box: Drag & Drop -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-800 font-medium">Tips: Atur Urutan Tampilan</p>
                    <p class="text-blue-700 text-sm mt-1">Drag & drop icon <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg> untuk mengubah urutan tampilan media sosial di website</p>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Media Sosial</h3>
                            <p class="text-sm text-gray-600">Total: {{ $socialMedia->count() }} platform</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg border border-gray-200">
                        Aktif: <span class="font-bold text-green-600">{{ $socialMedia->where('is_active', true)->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-20">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                    <span>Order</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Icon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Platform</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">URL & Note</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable" class="bg-white divide-y divide-gray-200">
                        @foreach($socialMedia as $item)
                            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 transition-colors cursor-move group">
                                <!-- Order & Drag Handle -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="handle cursor-move text-gray-400 group-hover:text-purple-600 transition-colors">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-lg font-bold text-gray-600">{{ $item->order }}</span>
                                    </div>
                                </td>

                                <!-- Icon -->
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        @php
                                            $platformName = strtolower($item->name);
                                        @endphp
                                        
                                        @if(str_contains($platformName, 'facebook'))
                                            <div class="w-14 h-14 rounded-xl bg-[#1877F2] flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'instagram'))
                                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'twitter') || str_contains($platformName, 'x'))
                                            <div class="w-14 h-14 rounded-xl bg-black flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'youtube'))
                                            <div class="w-14 h-14 rounded-xl bg-[#FF0000] flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'linkedin'))
                                            <div class="w-14 h-14 rounded-xl bg-[#0A66C2] flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'tiktok'))
                                            <div class="w-14 h-14 rounded-xl bg-black flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'whatsapp'))
                                            <div class="w-14 h-14 rounded-xl bg-[#25D366] flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                </svg>
                                            </div>
                                        @elseif(str_contains($platformName, 'telegram'))
                                            <div class="w-14 h-14 rounded-xl bg-[#26A5E4] flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Platform Name -->
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-800 text-lg">{{ $item->name }}</div>
                                </td>

                                <!-- URL & Note -->
                                <td class="px-6 py-5">
                                    <div class="space-y-2">
                                        <a href="{{ $item->url }}" target="_blank" class="flex items-center space-x-2 text-purple-600 hover:text-purple-800 font-medium text-sm group/link">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            <span class="group-hover/link:underline">{{ Str::limit($item->url, 45) }}</span>
                                        </a>
                                        @if($item->note)
                                            <div class="flex items-start space-x-2 text-gray-600 text-sm">
                                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                <span>{{ $item->note }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm italic">Tidak ada catatan</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        @if($item->is_active)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.social-media.edit', $item) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                           title="Edit">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.social-media.destroy', $item) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                                    title="Hapus">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Script untuk Sortable -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        @if(!$socialMedia->isEmpty())
        // Sortable untuk drag & drop reorder
        const sortable = new Sortable(document.getElementById('sortable'), {
            handle: '.handle',
            animation: 200,
            ghostClass: 'bg-purple-100',
            dragClass: 'opacity-50',
            onStart: function(evt) {
                evt.item.classList.add('shadow-2xl', 'scale-105');
            },
            onEnd: function(evt) {
                evt.item.classList.remove('shadow-2xl', 'scale-105');
                
                // Get all rows and their IDs
                const rows = document.querySelectorAll('#sortable tr');
                const orders = {};
                
                rows.forEach((row, index) => {
                    orders[row.dataset.id] = index + 1;
                });
                
                // Send AJAX request to update order
                fetch('{{ route('admin.social-media.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Show success notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                        notification.innerHTML = `
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Urutan berhasil diperbarui!</span>
                            </div>
                        `;
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.remove();
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memperbarui urutan. Silakan coba lagi.');
                    location.reload();
                });
            }
        });
        @endif

        // Auto hide success message
        setTimeout(function() {
            const successAlert = document.querySelector('.animate-fade-in');
            if(successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
@endsection
