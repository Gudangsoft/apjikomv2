@extends('layouts.admin')

@section('title', 'Tambah Jurnal Ilmiah')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.journals.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Jurnal Ilmiah</h1>
            <p class="text-gray-600 mt-1">Tambahkan jurnal ilmiah baru ke sistem</p>
        </div>
    </div>

    <form action="{{ route('admin.journals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Dasar
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Judul Jurnal <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" placeholder="Masukkan judul jurnal" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Penulis <span class="text-red-600">*</span>
                            </label>
                            <textarea name="authors" rows="2" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('authors') border-red-500 @enderror" placeholder="Contoh: John Doe, Jane Smith, Ahmad Yani" required>{{ old('authors') }}</textarea>
                            @error('authors')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Abstrak <span class="text-red-600">*</span>
                            </label>
                            <textarea name="abstract" rows="5" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('abstract') border-red-500 @enderror" placeholder="Masukkan abstrak jurnal" required>{{ old('abstract') }}</textarea>
                            @error('abstract')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Kata Kunci
                            </label>
                            <input type="text" name="keywords" value="{{ old('keywords') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keywords') border-red-500 @enderror" placeholder="Pisahkan dengan koma (,)">
                            @error('keywords')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Publication Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detail Publikasi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Volume
                            </label>
                            <input type="text" name="volume" value="{{ old('volume') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('volume') border-red-500 @enderror" placeholder="Contoh: 1">
                            @error('volume')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Issue/Nomor
                            </label>
                            <input type="text" name="issue" value="{{ old('issue') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('issue') border-red-500 @enderror" placeholder="Contoh: 2">
                            @error('issue')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Tahun <span class="text-red-600">*</span>
                            </label>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('year') border-red-500 @enderror" required>
                            @error('year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Halaman
                            </label>
                            <input type="text" name="pages" value="{{ old('pages') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pages') border-red-500 @enderror" placeholder="Contoh: 1-10">
                            @error('pages')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                DOI
                            </label>
                            <input type="text" name="doi" value="{{ old('doi') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('doi') border-red-500 @enderror" placeholder="Contoh: 10.1000/xyz123">
                            @error('doi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="published_date" value="{{ old('published_date') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('published_date') border-red-500 @enderror">
                            @error('published_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-base font-bold text-gray-900 mb-2">
                                Kategori
                            </label>
                            <input type="text" name="category" value="{{ old('category') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror" placeholder="Contoh: Teknologi">
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Publikasikan Jurnal</p>
                                <p class="text-xs text-gray-600">Jurnal akan tampil di website</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Cover Image</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Cover (Max 2MB)
                        </label>
                        <input type="file" name="cover_image" accept="image/jpeg,image/png,image/jpg" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cover_image') border-red-500 @enderror">
                        <p class="text-xs text-gray-600 mt-1">Format: JPG, PNG (Rekomendasi: 400x600px)</p>
                        @error('cover_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- PDF File -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">File PDF</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload PDF (Max 10MB)
                        </label>
                        <input type="file" name="file" accept="application/pdf" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('file') border-red-500 @enderror">
                        <p class="text-xs text-gray-600 mt-1">Format: PDF only</p>
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold shadow-lg transition-all transform hover:scale-105">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Jurnal
                        </span>
                    </button>
                    
                    <a href="{{ route('admin.journals.index') }}" class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold text-center transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
