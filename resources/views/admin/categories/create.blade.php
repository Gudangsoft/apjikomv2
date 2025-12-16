@extends('layouts.admin')

@section('page-title', 'Tambah Kategori')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Kategori Baru</h3>
    
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Deskripsi singkat kategori (opsional)</p>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-[#00629B] text-white rounded hover:bg-[#003A5D]">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
