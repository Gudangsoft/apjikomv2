@extends('layouts.admin')

@section('page-title', 'Edit Slider')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.sliders.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Slider</h1>
            <p class="text-gray-600 mt-1">Ubah informasi slider</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-6">
    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Slider</label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Opsional - Biarkan kosong jika tidak ingin menampilkan teks</p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('description') border-red-500 @enderror">{{ old('description', $slider->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Teks yang akan ditampilkan di bawah judul</p>
            </div>

            <!-- Current Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="h-48 w-full object-cover rounded-lg mb-4">
            </div>

            <!-- New Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('image') border-red-500 @enderror"
                    onchange="previewImage(this)">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG. Max 5MB</p>
                
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" class="h-48 w-full object-cover rounded-lg" src="" alt="Preview">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Button Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Teks Tombol</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('button_text') border-red-500 @enderror"
                        placeholder="Contoh: Bergabung Sekarang">
                    @error('button_text')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Link -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Tombol</label>
                    <input type="url" name="button_link" value="{{ old('button_link', $slider->button_link) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('button_link') border-red-500 @enderror"
                        placeholder="https://example.com">
                    @error('button_link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                    <input type="number" name="order" value="{{ old('order', $slider->order) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal ditampilkan</p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktifkan slider ini
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
            <a href="{{ route('admin.sliders.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Slider
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
