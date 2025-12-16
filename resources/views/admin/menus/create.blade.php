@extends('layouts.admin')

@section('page-title', 'Tambah Menu')

@section('content')
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Tambah Menu Baru</h3>
    <p class="text-gray-600 mt-1">Sistem menu mendukung hingga 3 tingkat (Level 1, Level 2, Level 3)</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Menu *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('title') border-red-500 @enderror" 
                    required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Menu *</label>
                <select name="type" id="type" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('type') border-red-500 @enderror" 
                    required>
                    <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link (URL Custom)</option>
                    <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Halaman (Link ke halaman)</option>
                    <option value="dropdown" {{ old('type') == 'dropdown' ? 'selected' : '' }}>Dropdown (Menu dengan sub-menu)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Menu -->
            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Menu</label>
                <select name="parent_id" id="parent_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('parent_id') border-red-500 @enderror">
                    <option value="">Tidak ada (Level 1)</option>
                    @foreach($parentMenus as $parentMenu)
                        <option value="{{ $parentMenu->id }}" {{ old('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                            {{ $parentMenu->title }} (Level 1)
                        </option>
                        @foreach($parentMenu->children as $childMenu)
                            <option value="{{ $childMenu->id }}" {{ old('parent_id') == $childMenu->id ? 'selected' : '' }}>
                                &nbsp;&nbsp;└─ {{ $childMenu->title }} (Level 2)
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Maksimal 3 tingkat menu</p>
            </div>

            <!-- URL -->
            <div id="url-field" class="md:col-span-2">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL / Link</label>
                <input type="text" name="url" id="url" value="{{ old('url') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('url') border-red-500 @enderror"
                    placeholder="https://example.com atau /berita">
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Contoh: /berita, https://google.com</p>
            </div>

            <!-- Page -->
            <div id="page-field" class="md:col-span-2" style="display: none;">
                <label for="page_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Halaman</label>
                <select name="page_id" id="page_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('page_id') border-red-500 @enderror">
                    <option value="">-- Pilih Halaman --</option>
                    @foreach($pages as $page)
                        <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>
                            {{ $page->title }}
                        </option>
                    @endforeach
                </select>
                @error('page_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target -->
            <div>
                <label for="target" class="block text-sm font-medium text-gray-700 mb-2">Target *</label>
                <select name="target" id="target" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('target') border-red-500 @enderror" 
                    required>
                    <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>Same Tab (_self)</option>
                    <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>New Tab (_blank)</option>
                </select>
                @error('target')
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

            <!-- Icon -->
            <div class="md:col-span-2">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (Opsional)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#00629B] focus:border-[#00629B] @error('icon') border-red-500 @enderror"
                    placeholder="fa fa-home, bi bi-house, etc">
                @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Gunakan class icon seperti Font Awesome atau Bootstrap Icons</p>
            </div>

            <!-- Is Active -->
            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#00629B] shadow-sm focus:border-[#00629B] focus:ring focus:ring-[#00629B] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan menu</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-[#00629B] text-white rounded-lg hover:bg-[#003A5D]">
                Simpan Menu
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const urlField = document.getElementById('url-field');
    const pageField = document.getElementById('page-field');
    
    function toggleFields() {
        const type = typeSelect.value;
        
        if (type === 'page') {
            urlField.style.display = 'none';
            pageField.style.display = 'block';
            document.getElementById('url').removeAttribute('required');
            document.getElementById('page_id').setAttribute('required', 'required');
        } else if (type === 'dropdown') {
            urlField.style.display = 'none';
            pageField.style.display = 'none';
            document.getElementById('url').removeAttribute('required');
            document.getElementById('page_id').removeAttribute('required');
        } else {
            urlField.style.display = 'block';
            pageField.style.display = 'none';
            document.getElementById('url').setAttribute('required', 'required');
            document.getElementById('page_id').removeAttribute('required');
        }
    }
    
    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>
@endpush
@endsection
