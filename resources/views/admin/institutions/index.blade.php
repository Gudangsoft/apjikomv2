@extends('layouts.admin')

@section('page-title', 'Data Instansi Member')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Instansi Member</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola data institusi yang menjadi anggota</p>
        </div>
        <a href="{{ route('admin.institutions.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Instansi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" placeholder="Cari instansi..." value="{{ request('search') }}" class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Tipe</option>
                <option value="Universitas" {{ request('type') == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                <option value="Institut" {{ request('type') == 'Institut' ? 'selected' : '' }}>Institut</option>
                <option value="Sekolah Tinggi" {{ request('type') == 'Sekolah Tinggi' ? 'selected' : '' }}>Sekolah Tinggi</option>
                <option value="Politeknik" {{ request('type') == 'Politeknik' ? 'selected' : '' }}>Politeknik</option>
                <option value="Akademi" {{ request('type') == 'Akademi' ? 'selected' : '' }}>Akademi</option>
                <option value="Lainnya" {{ request('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.institutions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Instansi</p>
                    <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Institution::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ \App\Models\Institution::where('is_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Member Terdaftar</p>
                    <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Member::whereNotNull('institution_id')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Bergabung Bulan Ini</p>
                    <p class="text-2xl font-bold text-orange-600">{{ \App\Models\Institution::whereMonth('joined_date', now()->month)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($institutions as $institution)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($institution->logo)
                                <img src="{{ asset('storage/' . $institution->logo) }}" alt="{{ $institution->name }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 font-bold mr-3">
                                    {{ strtoupper(substr($institution->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $institution->name }}</div>
                                @if($institution->joined_date)
                                    <div class="text-xs text-gray-500">Bergabung: {{ $institution->joined_date->format('d M Y') }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">{{ $institution->type }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $institution->city ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $institution->province ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($institution->email)
                            <div class="text-sm text-gray-900">{{ $institution->email }}</div>
                        @endif
                        @if($institution->phone)
                            <div class="text-xs text-gray-500">{{ $institution->phone }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                            {{ $institution->members_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($institution->is_active)
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Tidak Aktif</span>
                        @endif
                    </td>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="text-lg font-medium">Belum ada data instansi</p>
                        <p class="text-sm mt-1">Klik tombol "Tambah Instansi" untuk menambahkan data</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($institutions->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $institutions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
