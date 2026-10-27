@extends('layouts.admin')

@section('page-title', 'Galeri Foto Kerjasama')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cooperations.index') }}" class="text-sm text-purple-600 hover:text-purple-800">&larr; Kembali ke Kelola Kerjasama</a>
    <h1 class="text-2xl font-bold text-gray-900 mt-2">Galeri Foto — {{ $cooperation->name }}</h1>
    <p class="text-gray-600 mt-1">Upload foto dokumentasi (mis. penandatanganan MoU/MoA) yang akan tampil di halaman publik kerjasama ini.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<!-- Upload Form -->
<div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
    <h2 class="font-semibold text-gray-900 mb-3">Upload Foto Baru</h2>
    <form action="{{ route('admin.cooperations.photos.store', $cooperation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="file" name="photos[]" multiple accept="image/*" required
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
            <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium whitespace-nowrap">
                Upload Foto
            </button>
        </div>
        <p class="text-xs text-gray-500 mt-2">Bisa pilih beberapa foto sekaligus. JPG, PNG, atau WebP — maksimal 4MB per foto.</p>
    </form>
</div>

<!-- Existing Photos -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="font-semibold text-gray-900 mb-4">Foto Galeri ({{ $photos->count() }})</h2>

    @if($photos->isEmpty())
    <div class="py-10 text-center text-gray-400 text-sm">
        Belum ada foto. Upload foto pertama lewat form di atas.
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($photos as $photo)
        <div class="group relative border border-gray-200 rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . $photo->photo) }}" alt="{{ $photo->caption ?? $cooperation->name }}"
                 class="w-full aspect-square object-cover">

            <form action="{{ route('admin.cooperations.photos.destroy', [$cooperation, $photo]) }}" method="POST"
                  onsubmit="return confirm('Hapus foto ini dari galeri?')"
                  class="absolute top-1.5 right-1.5">
                @csrf @method('DELETE')
                <button type="submit" class="w-7 h-7 flex items-center justify-center bg-red-600/90 hover:bg-red-700 text-white rounded-full shadow transition" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

            <form action="{{ route('admin.cooperations.photos.update', [$cooperation, $photo]) }}" method="POST" class="p-2 bg-gray-50 border-t">
                @csrf @method('PUT')
                <input type="text" name="caption" value="{{ $photo->caption }}" placeholder="Keterangan (opsional)"
                       class="w-full px-2 py-1 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-purple-400">
                <button type="submit" class="mt-1 w-full text-[11px] text-purple-600 hover:text-purple-800 font-medium">Simpan keterangan</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
