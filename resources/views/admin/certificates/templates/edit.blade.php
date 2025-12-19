@extends('layouts.admin')

@section('title', 'Edit Template Sertifikat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.certificate-templates.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Daftar Template</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-6 rounded-t-lg">
            <h1 class="text-2xl font-bold">Edit Template Sertifikat</h1>
            <p class="text-purple-100 mt-1">Perbarui template sertifikat</p>
        </div>

        <form method="POST" action="{{ route('admin.certificate-templates.update', $certificateTemplate) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
            @endif

            <div class="space-y-6">
                <!-- Nama Template -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Template <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $certificateTemplate->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Template Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Template Gambar Saat Ini
                    </label>
                    <img src="{{ asset('storage/' . $certificateTemplate->template_image) }}" 
                         alt="{{ $certificateTemplate->name }}"
                         class="max-w-md rounded-lg border">
                </div>

                <!-- New Template Image -->
                <div>
                    <label for="template_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti Template Gambar (Opsional)
                    </label>
                    <input type="file" 
                           name="template_image" 
                           id="template_image" 
                           accept="image/png,image/jpeg,image/jpg"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('template_image') border-red-500 @enderror"
                           onchange="previewImage(event)">
                    <p class="text-sm text-gray-500 mt-1">
                        Format: PNG, JPG, JPEG. Max 10MB. Rekomendasi ukuran: 1064x662px (landscape)
                    </p>
                    @error('template_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</p>
                        <img id="preview" src="" alt="Preview" class="max-w-md rounded-lg border">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $certificateTemplate->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $certificateTemplate->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                        Jadikan template aktif (akan menonaktifkan template lain)
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.certificate-templates.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                    Perbarui Template
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
