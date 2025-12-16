@extends('layouts.admin')

@section('page-title', 'Tambah Media Galeri')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.galleries.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Media Galeri</h3>
    
    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Type Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Tipe Media <span class="text-red-500">*</span></label>
            <div class="flex gap-4">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="type" value="image" {{ old('type', 'image') == 'image' ? 'checked' : '' }} 
                           class="text-purple-600 focus:ring-purple-500" onchange="toggleMediaType()">
                    <span class="text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Gambar/Foto
                    </span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="type" value="video" {{ old('type') == 'video' ? 'checked' : '' }}
                           class="text-purple-600 focus:ring-purple-500" onchange="toggleMediaType()">
                    <span class="text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Video YouTube
                    </span>
                </label>
            </div>
        </div>

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="255" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload (shown when type=image) -->
        <div id="imageField" class="mb-6" style="display: {{ old('type', 'image') == 'image' ? 'block' : 'none' }}">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar <span class="text-red-500">*</span></label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 5MB</p>
        </div>

        <!-- YouTube URL (shown when type=video) -->
        <div id="videoField" class="mb-6" style="display: {{ old('type') == 'video' ? 'block' : 'none' }}">
            <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">URL YouTube <span class="text-red-500">*</span></label>
            <input type="url" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..."
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('youtube_url') border-red-500 @enderror">
            @error('youtube_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Masukkan URL video YouTube (contoh: https://www.youtube.com/watch?v=xxxxx atau https://youtu.be/xxxxx)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="category" name="category" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('category') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="activity" {{ old('category') == 'activity' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="member" {{ old('category') == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">Event (Opsional)</label>
                <select id="event_id" name="event_id"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('event_id') border-red-500 @enderror">
                    <option value="">-- Tidak terkait event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} ({{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('event_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('order') border-red-500 @enderror">
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Angka lebih kecil ditampilkan lebih dulu</p>
            </div>

            <div class="flex items-center">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded text-purple-600 focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">
                        <span class="text-yellow-500">⭐</span> Tampilkan sebagai Featured
                    </span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Simpan Media
            </button>
        </div>
    </form>
</div>

<script>
function toggleMediaType() {
    const imageRadio = document.querySelector('input[name="type"][value="image"]');
    const imageField = document.getElementById('imageField');
    const videoField = document.getElementById('videoField');
    const imageInput = document.getElementById('image');
    const videoInput = document.getElementById('youtube_url');
    
    if (imageRadio.checked) {
        imageField.style.display = 'block';
        videoField.style.display = 'none';
        imageInput.required = true;
        videoInput.required = false;
    } else {
        imageField.style.display = 'none';
        videoField.style.display = 'block';
        imageInput.required = false;
        videoInput.required = true;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleMediaType();
});
</script>
@endsection
