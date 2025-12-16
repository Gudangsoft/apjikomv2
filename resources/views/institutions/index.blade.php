@extends('layouts.main')

@section('title', 'Anggota Institusi')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Anggota Institusi</h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Institusi pendidikan tinggi yang telah bergabung dengan APJIKOM</p>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-12 border-b">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $institutions->total() }}</div>
                <div class="text-gray-600">Total Institusi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">{{ $universities }}</div>
                <div class="text-gray-600">Universitas</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-pink-600 mb-2">{{ $institutes }}</div>
                <div class="text-gray-600">Institut</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $others }}</div>
                <div class="text-gray-600">Lainnya</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('institutions.index') }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ !request('type') && !request('province') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm' }}">
                Semua
            </a>
            <a href="{{ route('institutions.index', ['type' => 'Universitas']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'Universitas' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm' }}">
                Universitas
            </a>
            <a href="{{ route('institutions.index', ['type' => 'Institut']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'Institut' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm' }}">
                Institut
            </a>
            <a href="{{ route('institutions.index', ['type' => 'Sekolah Tinggi']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'Sekolah Tinggi' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm' }}">
                Sekolah Tinggi
            </a>
            <a href="{{ route('institutions.index', ['type' => 'Politeknik']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'Politeknik' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm' }}">
                Politeknik
            </a>
        </div>

        <!-- Province Filter -->
        <div class="mt-6 max-w-md mx-auto">
            <form method="GET" class="flex gap-2">
                <input type="hidden" name="type" value="{{ request('type') }}">
                <select name="province" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white" onchange="this.form.submit()">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>

<!-- Institutions Grid -->
<div class="container mx-auto px-4 py-12">
    @if($institutions->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($institutions as $institution)
        <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition duration-300 overflow-hidden group">
            <!-- Header with Logo -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative z-10 flex items-center justify-center">
                    @if($institution->logo)
                        <img src="{{ asset('storage/' . $institution->logo) }}" 
                            alt="{{ $institution->name }}" 
                            class="w-24 h-24 object-contain bg-white rounded-lg p-2 shadow-lg">
                    @else
                        <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Institution Type Badge -->
                <div class="mb-3">
                    @php
                        $typeColors = [
                            'Universitas' => 'bg-blue-100 text-blue-800',
                            'Institut' => 'bg-purple-100 text-purple-800',
                            'Sekolah Tinggi' => 'bg-pink-100 text-pink-800',
                            'Politeknik' => 'bg-green-100 text-green-800',
                            'Akademi' => 'bg-yellow-100 text-yellow-800',
                        ];
                    @endphp
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $typeColors[$institution->type] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $institution->type }}
                    </span>
                </div>

                <!-- Name -->
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-indigo-600 transition">
                    {{ $institution->name }}
                </h3>

                <!-- Location -->
                <div class="flex items-start text-gray-600 mb-2">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm">{{ $institution->city }}, {{ $institution->province }}</span>
                </div>

                <!-- Members Count -->
                @if($institution->members_count > 0)
                <div class="flex items-center text-gray-600 mb-4">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ $institution->members_count }} Member</span>
                </div>
                @endif

                <!-- Contact Info -->
                <div class="pt-4 border-t border-gray-100 space-y-2">
                    @if($institution->phone)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ $institution->phone }}</span>
                    </div>
                    @endif

                    @if($institution->email)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="truncate">{{ $institution->email }}</span>
                    </div>
                    @endif

                    @if($institution->website)
                    <div class="flex items-center text-sm text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <a href="{{ $institution->website }}" target="_blank" class="hover:underline truncate">
                            Website
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Joined Date -->
                @if($institution->joined_date)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Bergabung sejak
                        </span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($institution->joined_date)->format('d M Y') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($institutions->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $institutions->appends(['type' => request('type'), 'province' => request('province')])->links() }}
    </div>
    @endif
    @else
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <p class="text-xl text-gray-600 mb-2">Tidak ada institusi yang ditemukan</p>
        <p class="text-gray-500 mb-6">Coba filter lain atau lihat semua institusi</p>
        @if(request('type') || request('province'))
        <a href="{{ route('institutions.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset Filter
        </a>
        @endif
    </div>
    @endif
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Bergabung dengan Kami?</h2>
        <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
            Daftarkan institusi Anda dan jadilah bagian dari jaringan perguruan tinggi komunikasi terbaik di Indonesia
        </p>
        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition font-semibold shadow-xl text-lg">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Daftar Sekarang
        </a>
    </div>
</div>
@endsection
