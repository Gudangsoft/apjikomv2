@extends('layouts.main')

@section('title', $cooperation->name)

@section('content')
<!-- Page Header -->
<section class="bg-purple-600 text-white py-8 md:py-12">
    <div class="container mx-auto px-4">
        <a href="{{ route('cooperation.index') }}" class="inline-flex items-center gap-1.5 text-purple-200 hover:text-white text-sm mb-3 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Kerjasama
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold">{{ $cooperation->name }}</h1>
        @if($cooperation->category)
        <p class="text-sm sm:text-lg text-purple-100 mt-1">{{ $cooperation->category }}</p>
        @endif
    </div>
</section>

<!-- Detail -->
<section class="py-10 sm:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header: logo + name -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 p-6 sm:p-8 border-b border-gray-100">
                    <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($cooperation->logo)
                            <img src="{{ asset('storage/' . $cooperation->logo) }}" alt="{{ $cooperation->name }}" class="w-full h-full object-contain p-2">
                        @else
                            <span class="text-purple-600 font-bold text-4xl">{{ mb_substr($cooperation->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="text-center sm:text-left min-w-0">
                        <h2 class="text-xl font-bold text-gray-900">{{ $cooperation->name }}</h2>
                        @if($cooperation->category)
                        <p class="text-sm text-purple-600 font-medium mt-1">{{ $cooperation->category }}</p>
                        @endif
                        @if($cooperation->website)
                        <a href="{{ clean_website_url($cooperation->website) ?? '#' }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-purple-600 mt-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            {{ $cooperation->website }}
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Dokumen MoU / MoA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 border-b border-gray-100">
                    <div class="p-6 sm:p-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Memorandum of Understanding (MoU)</p>
                        @if($cooperation->hasMou())
                        <a href="{{ asset('storage/' . $cooperation->mou_file) }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-sm font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Dokumen MoU
                        </a>
                        @if($cooperation->mou_date)
                        <p class="text-xs text-gray-400 mt-2">Ditandatangani: {{ $cooperation->mou_date->format('d F Y') }}</p>
                        @endif
                        @else
                        <p class="text-sm text-gray-400">— Belum tersedia —</p>
                        @endif
                    </div>
                    <div class="p-6 sm:p-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Memorandum of Agreement (MoA)</p>
                        @if($cooperation->hasMoa())
                        <a href="{{ asset('storage/' . $cooperation->moa_file) }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Dokumen MoA
                        </a>
                        @if($cooperation->moa_date)
                        <p class="text-xs text-gray-400 mt-2">Ditandatangani: {{ $cooperation->moa_date->format('d F Y') }}</p>
                        @endif
                        @else
                        <p class="text-sm text-gray-400">— Belum tersedia —</p>
                        @endif
                    </div>
                </div>

                <!-- Deskripsi & Galeri Foto -->
                @php $hasDescription = (bool) $cooperation->description; $hasPhotos = $cooperation->photos->isNotEmpty(); @endphp
                @if($hasDescription || $hasPhotos)
                <div class="grid grid-cols-1 {{ ($hasDescription && $hasPhotos) ? 'sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100' : '' }}">
                    @if($hasDescription)
                    <div class="p-6 sm:p-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Lingkup Kerjasama</p>
                        <p class="text-gray-700 leading-relaxed text-sm sm:text-base whitespace-pre-line">{{ $cooperation->description }}</p>
                    </div>
                    @endif

                    @if($hasPhotos)
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Galeri Foto</h3>
                        </div>
                        <div class="grid grid-cols-2 {{ $hasDescription ? '' : 'sm:grid-cols-3' }} gap-3">
                            @foreach($cooperation->photos as $i => $photo)
                            <button type="button" onclick="openGalleryLightbox({{ $i }})"
                                    class="group relative aspect-square rounded-xl overflow-hidden border border-gray-100">
                                <img src="{{ asset('storage/' . $photo->photo) }}" alt="{{ $photo->caption ?? $cooperation->name }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10h-6M10 7v6"></path>
                                    </svg>
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('cooperation.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-800 font-medium text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Lihat Mitra Kerjasama Lainnya
                </a>
            </div>
        </div>
    </div>
</section>

@if($cooperation->photos->isNotEmpty())
<!-- Lightbox Galeri Foto -->
@php
    $galleryPhotos = $cooperation->photos->map(fn ($p) => [
        'url' => asset('storage/' . $p->photo),
        'caption' => $p->caption,
    ]);
@endphp
<div id="galleryLightbox" class="fixed inset-0 hidden items-center justify-center p-4 bg-black/90" style="z-index: 1100;">
    <button type="button" onclick="closeGalleryLightbox()"
            class="absolute top-4 right-4 z-10 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center backdrop-blur-sm transition">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    @if($galleryPhotos->count() > 1)
    <button type="button" onclick="navigateGalleryLightbox(-1)" class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2">
        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button type="button" onclick="navigateGalleryLightbox(1)" class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2">
        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    @endif

    <div class="max-w-4xl max-h-[85vh] flex flex-col items-center">
        <img id="galleryLightboxImg" src="" alt="" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl">
        <p id="galleryLightboxCaption" class="text-white/80 text-sm mt-4 text-center max-w-xl"></p>
    </div>
</div>

<script>
const galleryPhotos = @json($galleryPhotos);
let galleryIndex = 0;

function openGalleryLightbox(index) {
    galleryIndex = index;
    renderGalleryLightbox();
    const modal = document.getElementById('galleryLightbox');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeGalleryLightbox() {
    const modal = document.getElementById('galleryLightbox');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function navigateGalleryLightbox(step) {
    galleryIndex = (galleryIndex + step + galleryPhotos.length) % galleryPhotos.length;
    renderGalleryLightbox();
}
function renderGalleryLightbox() {
    const photo = galleryPhotos[galleryIndex];
    document.getElementById('galleryLightboxImg').src = photo.url;
    document.getElementById('galleryLightboxCaption').textContent = photo.caption || '';
}
document.addEventListener('keydown', function (e) {
    const modal = document.getElementById('galleryLightbox');
    if (modal.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeGalleryLightbox();
    if (e.key === 'ArrowLeft') navigateGalleryLightbox(-1);
    if (e.key === 'ArrowRight') navigateGalleryLightbox(1);
});
</script>
@endif
@endsection
