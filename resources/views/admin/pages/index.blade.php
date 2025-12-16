@extends('layouts.admin')

@section('page-title', 'Kelola Halaman')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-2xl font-bold text-gray-900">Daftar Halaman</h3>
    <a href="{{ route('admin.pages.create') }}" class="bg-[#00629B] text-white px-4 py-2 rounded hover:bg-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Halaman</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($pages as $page)
            <tr>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $page->title }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-500">{{ $page->slug }}</div>
                </td>
                <td class="px-6 py-4">
                    @if($page->is_published)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Published
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Draft
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $page->order }}
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="text-[#00629B] hover:text-[#003A5D]">Edit</a>
                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Belum ada halaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
