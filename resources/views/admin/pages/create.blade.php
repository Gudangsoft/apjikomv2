@extends('layouts.admin')

@section('page-title', 'Tambah Halaman')

@section('content')
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Tambah Halaman Baru</h3>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('title') border-red-500 @enderror" 
                    required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="md:col-span-2">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('slug') border-red-500 @enderror"
                    placeholder="Kosongkan untuk generate otomatis">
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Contoh: tentang-kami, visi-misi, struktur-organisasi</p>
            </div>

            <!-- Content -->
            <div class="md:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten</label>
                <textarea name="content" id="content" rows="10" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="md:col-span-2">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                <textarea name="excerpt" id="excerpt" rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Title -->
            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title (SEO)</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('meta_title') border-red-500 @enderror">
                @error('meta_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('order') border-red-500 @enderror" 
                    min="0">
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Description -->
            <div class="md:col-span-2">
                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description (SEO)</label>
                <textarea name="meta_description" id="meta_description" rows="2" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('meta_description') border-red-500 @enderror">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Keywords -->
            <div class="md:col-span-2">
                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords (SEO)</label>
                <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('meta_keywords') border-red-500 @enderror"
                    placeholder="keyword1, keyword2, keyword3">
                @error('meta_keywords')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Published -->
            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#00629B] shadow-sm focus:border-[#00629B] focus:ring focus:ring-[#00629B] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Publikasikan halaman</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-[#00629B] text-white rounded-lg hover:bg-[#003A5D]">
                Simpan Halaman
            </button>
        </div>
    </form>
</div>
@endsection
