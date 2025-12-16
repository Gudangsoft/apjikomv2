@extends('layouts.admin')

@section('page-title', 'Edit Changelog')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.changelog.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h3 class="text-2xl font-bold text-gray-900">Edit Changelog</h3>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.changelog.update', $changelog) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Version -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Version <span class="text-gray-500">(Opsional)</span>
                </label>
                <input type="text" name="version" value="{{ old('version', $changelog->version) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('version') border-red-500 @enderror"
                       placeholder="Contoh: 1.0.0, 2.3.1">
                @error('version')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Release Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Rilis <span class="text-red-500">*</span>
                </label>
                <input type="date" name="release_date" value="{{ old('release_date', $changelog->release_date->format('Y-m-d')) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('release_date') border-red-500 @enderror">
                @error('release_date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Update <span class="text-red-500">*</span>
                </label>
                <select name="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                    <option value="update" {{ old('type', $changelog->type) == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="feature" {{ old('type', $changelog->type) == 'feature' ? 'selected' : '' }}>Feature (Fitur Baru)</option>
                    <option value="bugfix" {{ old('type', $changelog->type) == 'bugfix' ? 'selected' : '' }}>Bugfix (Perbaikan Bug)</option>
                    <option value="security" {{ old('type', $changelog->type) == 'security' ? 'selected' : '' }}>Security (Keamanan)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Changes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Daftar Perubahan <span class="text-red-500">*</span>
                </label>
                <textarea name="changes" rows="10" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('changes') border-red-500 @enderror"
                          placeholder="Tuliskan perubahan per baris, contoh:&#10;- Menambahkan fitur upload foto member&#10;- Memperbaiki bug pada halaman registrasi&#10;- Meningkatkan performa loading halaman&#10;- Update security patch">{{ old('changes', $changelog->changes) }}</textarea>
                @error('changes')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    💡 Tips: Gunakan format list dengan tanda "-" atau nomor untuk memudahkan pembacaan
                </p>
            </div>

            <!-- Published Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" value="1" 
                       {{ old('is_published', $changelog->is_published) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_published" class="ml-2 block text-sm text-gray-700">
                    Publikasikan changelog ini
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.changelog.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-[#00629B] text-white rounded-lg hover:bg-[#003A5D]">
                Update Changelog
            </button>
        </div>
    </form>
</div>
@endsection
