@extends('layouts.admin')

@section('title', 'Tambah Template Kartu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.card-templates.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Template Kartu Anggota</h1>

        <form method="POST" action="{{ route('admin.card-templates.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Template <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror"
                       placeholder="Contoh: Template Kartu APJIKOM 2025">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Template Background <span class="text-red-500">*</span>
                </label>
                <input type="file" name="template_image" accept="image/*" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('template_image') border-red-500 @enderror"
                       onchange="previewTemplate(event)">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB. Rekomendasi: 1200x800px atau lebih besar</p>
                @error('template_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <div id="templatePreview" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img id="preview" src="" alt="Preview" class="max-w-2xl rounded shadow-lg">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi (Optional)
                </label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                          placeholder="Deskripsi singkat template ini...">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Aktifkan template ini</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Jika dicentang, template ini akan langsung digunakan untuk generate kartu</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.card-templates.index') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    Simpan Template
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewTemplate(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('templatePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
