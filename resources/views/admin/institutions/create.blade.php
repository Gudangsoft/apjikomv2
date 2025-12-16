@extends('layouts.admin')

@section('page-title', 'Tambah Instansi')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.institutions.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Instansi Baru</h1>
    </div>

    <form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Instansi *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('type') border-red-500 @enderror">
                    <option value="">Pilih Tipe</option>
                    <option value="Universitas" {{ old('type') == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                    <option value="Institut" {{ old('type') == 'Institut' ? 'selected' : '' }}>Institut</option>
                    <option value="Sekolah Tinggi" {{ old('type') == 'Sekolah Tinggi' ? 'selected' : '' }}>Sekolah Tinggi</option>
                    <option value="Politeknik" {{ old('type') == 'Politeknik' ? 'selected' : '' }}>Politeknik</option>
                    <option value="Akademi" {{ old('type') == 'Akademi' ? 'selected' : '' }}>Akademi</option>
                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Joined Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                <input type="date" name="joined_date" value="{{ old('joined_date', now()->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('joined_date') border-red-500 @enderror">
                @error('joined_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                <input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('city') border-red-500 @enderror">
                @error('city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Province -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                <input type="text" name="province" value="{{ old('province') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('province') border-red-500 @enderror">
                @error('province')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Postal Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('postal_code') border-red-500 @enderror">
                @error('postal_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('website') border-red-500 @enderror">
                @error('website')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Instansi</label>
                <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('logo') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.institutions.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
