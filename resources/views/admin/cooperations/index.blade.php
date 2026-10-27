@extends('layouts.admin')

@section('page-title', 'Kelola Kerjasama')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Kerjasama (MoU/MoA)</h1>
        <p class="text-gray-600 mt-1">Kelola daftar mitra kerjasama beserta dokumen MoU/MoA yang tampil di /kerjasama</p>
    </div>
    <a href="{{ route('admin.cooperations.create') }}"
       class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition flex items-center gap-2 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kerjasama
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
@endif

<!-- Search -->
<form method="GET" class="mb-6">
    <div class="flex gap-2 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau bidang kerjasama..."
               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-400">
        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm">Cari</button>
        @if(request('search'))
        <a href="{{ route('admin.cooperations.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">Reset</a>
        @endif
    </div>
</form>

<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    @if($cooperations->isEmpty())
    <div class="p-10 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <p class="font-medium">Belum ada data kerjasama</p>
        <p class="mt-1 text-sm">Klik "Tambah Kerjasama" untuk menambahkan mitra baru.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">Logo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama / Bidang</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-24">MoU</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-24">MoA</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-20">Foto</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-20">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($cooperations as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                            @if($item->logo)
                                <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->name }}" class="w-full h-full object-contain p-1">
                            @else
                                <span class="text-purple-600 font-bold text-sm">{{ mb_substr($item->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-900">{{ $item->name }}</p>
                        @if($item->category)
                        <p class="text-xs text-gray-500">{{ $item->category }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($item->hasMou())
                            <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✓ Ada</span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($item->hasMoa())
                            <span class="px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">✓ Ada</span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.cooperations.photos.index', $item) }}"
                           class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $item->photos_count > 0 ? 'bg-purple-100 text-purple-700 hover:bg-purple-200' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }} transition">
                            {{ $item->photos_count }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($item->is_active)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('cooperation.show', $item) }}" target="_blank" class="text-gray-500 hover:text-gray-800 text-sm">Lihat</a>
                            <a href="{{ route('admin.cooperations.photos.index', $item) }}" class="text-blue-600 hover:text-blue-900 text-sm">Galeri</a>
                            <a href="{{ route('admin.cooperations.edit', $item) }}" class="text-purple-600 hover:text-purple-900 text-sm">Edit</a>
                            <form action="{{ route('admin.cooperations.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Hapus kerjasama dengan {{ addslashes($item->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@if($cooperations->hasPages())
<div class="mt-6">
    {{ $cooperations->links() }}
</div>
@endif
@endsection
