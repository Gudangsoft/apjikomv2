@extends('layouts.admin')

@section('page-title', 'Tambah Testimoni')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.testimonials.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Testimoni Baru</h3>
    
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Member <span class="text-red-500">*</span></label>
            <select id="member_id" name="member_id" required
                    class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('member_id') border-red-500 @enderror">
                <option value="">-- Pilih Member --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->user->name }} - {{ $member->member_number ?? 'Belum ada nomor' }} ({{ $member->institution_name ?? 'Institusi tidak tersedia' }})
                    </option>
                @endforeach
            </select>
            @error('member_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Pilih member yang akan memberikan testimoni</p>
        </div>

        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Pesan Testimoni <span class="text-red-500">*</span></label>
            <textarea id="content" name="content" rows="5" required
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Tuliskan testimoni dari member</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                <select id="rating" name="rating" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('rating') border-red-500 @enderror">
                    <option value="">-- Pilih Rating --</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                            {{ $i }} Bintang ⭐
                        </option>
                    @endfor
                </select>
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto (Opsional)</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('photo') border-red-500 @enderror">
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika ingin menggunakan foto dari profil member.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="flex items-center">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded text-purple-600 focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">
                        <span class="text-yellow-500">⭐</span> Tampilkan sebagai Featured
                    </span>
                </label>
            </div>
            
            <div class="flex items-center">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded text-purple-600 focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Aktifkan testimoni ini</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Simpan Testimoni
            </button>
        </div>
    </form>
</div>
@endsection
