@extends('layouts.admin')

@section('page-title', 'Tambah Berita')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

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
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Berita Baru</h3>
    
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Thumbnail</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg" id="imageInput"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB. Rekomendasi ukuran: 1200x630px</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div id="imagePreview" class="mt-3 hidden">
                <img src="" alt="Preview" class="max-w-md rounded-lg border">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
            <textarea name="excerpt" rows="3"
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Ringkasan singkat berita (opsional)</p>
            @error('excerpt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
            <textarea id="content" name="content" rows="15" required
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                <input type="date" name="published_at" value="{{ old('published_at') }}"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                <p class="text-xs text-gray-500 mt-1">Kosongkan untuk publish sekarang</p>
            </div>
            
            <div class="flex items-end">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                           class="rounded text-[#00629B] focus:ring-[#00629B]">
                    <span class="text-sm font-medium text-gray-700">Publish Berita</span>
                </label>
            </div>
            
            <div class="flex items-end">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded text-[#00629B] focus:ring-[#00629B]">
                    <span class="text-sm font-medium text-gray-700">Berita Unggulan</span>
                </label>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-[#00629B] text-white rounded hover:bg-[#003A5D]">
                Simpan Berita
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

// Initialize TinyMCE
tinymce.init({
    selector: '#content',
    height: 500,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
        'anchor', 'searchreplace', 'visualblocks', 'code',
        'insertdatetime', 'media', 'table', 'wordcount'
    ],
    toolbar: 'blocks | bold italic underline strikethrough | forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image media table | removeformat code',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; font-size: 14px; line-height: 1.6; } img { max-width: 100%; height: auto; }',
    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;',
    file_picker_types: 'image',
    automatic_uploads: true,
    paste_data_images: true,
    images_reuse_filename: true,
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/admin/upload-image');
        
        xhr.upload.onprogress = function (e) {
            // Progress indicator
        };
        
        xhr.onload = function() {
            if (xhr.status === 403) {
                failure('HTTP Error: ' + xhr.status, { remove: true });
                return;
            }
            
            if (xhr.status < 200 || xhr.status >= 300) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            
            var json = JSON.parse(xhr.responseText);
            
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            
            success(json.location);
        };
        
        xhr.onerror = function () {
            failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('_token', '{{ csrf_token() }}');
        
        xhr.send(formData);
    },
    branding: false,
    promotion: false,
    statusbar: true,
    resize: true,
    contextmenu: 'link image table',
    quickbars_selection_toolbar: 'bold italic underline | forecolor backcolor | alignleft aligncenter alignright',
    quickbars_insert_toolbar: 'quickimage quicktable',
    object_resizing: true,
    extended_valid_elements: 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style]',
    convert_urls: false,
    remove_script_host: false,
    relative_urls: false
});

</script>
@endsection
