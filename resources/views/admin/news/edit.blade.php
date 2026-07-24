@extends('layouts.admin')

@section('page-title', 'Edit Berita')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.news.index') }}" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Berita</h3>

    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" id="newsForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('title') border-red-500 @enderror">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Thumbnail</label>
            @if($news->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="Current thumbnail" class="max-w-md rounded-lg border">
                    <p class="text-sm text-gray-600 mt-2">Gambar saat ini. Upload gambar baru untuk mengganti.</p>
                </div>
            @endif
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg" id="imageInput"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('image') border-red-500 @enderror">
            <x-image-hint dimensions="1200×630" ratio="16:9" max-size="2MB" formats="JPG, PNG" note="Kosongkan jika tidak ingin mengubah thumbnail." />
            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            <div id="imagePreview" class="mt-3 hidden">
                <p class="text-sm font-medium text-gray-700 mb-2">Preview gambar baru:</p>
                <img src="" alt="Preview" class="max-w-md rounded-lg border">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
            <textarea name="excerpt" rows="3"
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $news->excerpt) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Ringkasan singkat berita (opsional)</p>
            @error('excerpt')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Rich Text Editor --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
            @error('content')<p class="text-red-500 text-sm mb-2">{{ $message }}</p>@enderror

            <div id="quill-wrapper" class="quill-wrapper">
                <div id="quill-editor"></div>
            </div>
            <textarea id="content" name="content" class="hidden">{{ old('content', $news->content) }}</textarea>

            <div class="flex justify-between items-center mt-1">
                <p class="text-xs text-gray-400">Gunakan toolbar di atas untuk memformat teks</p>
                <p class="text-xs text-gray-400"><span id="wordCounter">0</span> kata</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                <input type="date" name="published_at" value="{{ old('published_at', $news->published_at?->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
            </div>
            <div class="flex items-end">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                           class="rounded text-[#00629B] focus:ring-[#00629B]">
                    <span class="text-sm font-medium text-gray-700">Publish Berita</span>
                </label>
            </div>
            <div class="flex items-end">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                           class="rounded text-[#00629B] focus:ring-[#00629B]">
                    <span class="text-sm font-medium text-gray-700">Berita Unggulan</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-[#00629B] text-white rounded hover:bg-[#003A5D]">Update Berita</button>
        </div>
    </form>
</div>

@include('admin.news.partials.editor-scripts', ['initialContent' => old('content', $news->content)])

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('imagePreview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
