@extends('layouts.admin')

@section('page-title', 'Tambah Kegiatan')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Kegiatan Baru</h3>
    
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kegiatan *</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select name="category_id" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('category_id') border-red-500 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Kategori untuk mengelompokkan jenis kegiatan (opsional)</p>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Event *</label>
            <input type="file" name="image" accept="image/*" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('image') border-red-500 @enderror"
                   onchange="previewImage(event)">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB. Rekomendasi ukuran: 800x600px</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            
            <!-- Preview Image -->
            <div id="imagePreview" class="mt-3 hidden">
                <img id="preview" src="" alt="Preview" class="max-w-xs rounded shadow">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
            <textarea id="description" name="description" rows="6" required
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="event_date" value="{{ old('event_date') }}" required
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('event_date') border-red-500 @enderror">
                @error('event_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <input type="time" name="event_time" value="{{ old('event_time') }}"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
            </div>
        </div>
        
        <!-- Event Type -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pelaksanaan *</label>
            <div class="grid grid-cols-3 gap-4">
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 {{ old('event_type') == 'offline' || !old('event_type') ? 'border-purple-500 bg-purple-50' : '' }}">
                    <input type="radio" name="event_type" value="offline" {{ old('event_type', 'offline') == 'offline' ? 'checked' : '' }} 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Offline</span>
                </label>
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 {{ old('event_type') == 'online' ? 'border-purple-500 bg-purple-50' : '' }}">
                    <input type="radio" name="event_type" value="online" {{ old('event_type') == 'online' ? 'checked' : '' }} 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Online</span>
                </label>
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 {{ old('event_type') == 'hybrid' ? 'border-purple-500 bg-purple-50' : '' }}">
                    <input type="radio" name="event_type" value="hybrid" {{ old('event_type') == 'hybrid' ? 'checked' : '' }} 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Hybrid</span>
                </label>
            </div>
        </div>
        
        <!-- Location (for offline/hybrid) -->
        <div class="mb-6" id="locationField">
            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
            <input type="text" name="location" value="{{ old('location') }}"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('location') border-red-500 @enderror">
            @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Online Platform (for online/hybrid) -->
        <div class="mb-6 hidden" id="platformField">
            <label class="block text-sm font-medium text-gray-700 mb-2">Platform Online <span class="text-red-500">*</span></label>
            <input type="text" name="online_platform" value="{{ old('online_platform') }}"
                   placeholder="Contoh: Zoom, Google Meet, Microsoft Teams"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
            <p class="text-xs text-gray-500 mt-1">Platform yang digunakan untuk event online</p>
        </div>
        
        <!-- Registration Section -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">Pengaturan Pendaftaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="has_registration" value="1" {{ old('has_registration') ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded" onchange="toggleRegistrationFields()">
                        <span class="text-sm font-medium text-gray-700">Memerlukan Pendaftaran</span>
                    </label>
                </div>
                
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="has_certificate" value="1" {{ old('has_certificate') ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-700">Menyediakan Sertifikat</span>
                    </label>
                </div>
            </div>
            
            <div id="registrationDetails" class="space-y-4 {{ old('has_registration') ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Peserta</label>
                        <input type="number" name="participant_quota" value="{{ old('participant_quota') }}" min="1"
                               placeholder="Contoh: 100"
                               class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak terbatas</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Pendaftaran (Rp)</label>
                        <input type="number" name="registration_fee" value="{{ old('registration_fee') }}" min="0" step="0.01"
                               placeholder="0 untuk gratis"
                               class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Persyaratan Pendaftaran</label>
                    <textarea name="registration_requirements" rows="3"
                              class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]"
                              placeholder="Contoh: KTP, CV, Surat Rekomendasi">{{ old('registration_requirements') }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Link Pendaftaran</label>
            <input type="url" name="registration_link" value="{{ old('registration_link') }}"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] @error('registration_link') border-red-500 @enderror"
                   placeholder="https://example.com/register">
            <p class="text-xs text-gray-500 mt-1">URL lengkap untuk pendaftaran kegiatan (opsional)</p>
            @error('registration_link')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Event akan tampil di halaman publik</p>
            </div>
            
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Tampilkan di Homepage</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Event akan muncul di slider homepage</p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.events.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-[#00629B] text-white rounded hover:bg-[#003A5D]">
                Simpan Kegiatan
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
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

// Initialize TinyMCE
tinymce.init({
    selector: '#description',
    height: 400,
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

// Toggle event type fields
function toggleEventFields() {
    const eventType = document.querySelector('input[name="event_type"]:checked').value;
    const locationField = document.getElementById('locationField');
    const platformField = document.getElementById('platformField');
    const locationInput = document.querySelector('input[name="location"]');
    const platformInput = document.querySelector('input[name="online_platform"]');
    
    if (eventType === 'offline') {
        locationField.classList.remove('hidden');
        platformField.classList.add('hidden');
        locationInput.required = true;
        platformInput.required = false;
    } else if (eventType === 'online') {
        locationField.classList.add('hidden');
        platformField.classList.remove('hidden');
        locationInput.required = false;
        platformInput.required = true;
    } else { // hybrid
        locationField.classList.remove('hidden');
        platformField.classList.remove('hidden');
        locationInput.required = true;
        platformInput.required = true;
    }
}

// Toggle registration fields
function toggleRegistrationFields() {
    const hasRegistration = document.querySelector('input[name="has_registration"]').checked;
    const registrationDetails = document.getElementById('registrationDetails');
    
    if (hasRegistration) {
        registrationDetails.classList.remove('hidden');
    } else {
        registrationDetails.classList.add('hidden');
    }
}

// Initialize on page load
toggleEventFields();
toggleRegistrationFields();
</script>
@endsection