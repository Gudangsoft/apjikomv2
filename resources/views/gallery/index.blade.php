@extends('layouts.main')

@section('title', 'Gallery')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-teal-600 to-cyan-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Gallery</h1>
            <p class="text-xl text-teal-100">Dokumentasi foto dan video kegiatan APJIKOM</p>
        </div>
    </div>
</div>

<!-- Gallery Content -->
<div class="container mx-auto px-4 py-12">
    <!-- Filter Section -->
    <div class="mb-8">
        <!-- Type Filter -->
        <div class="flex flex-wrap justify-center gap-3 mb-4">
            <a href="{{ route('gallery.index') }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ !request('type') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                📁 Semua Media
            </a>
            <a href="{{ route('gallery.index', ['type' => 'image']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'image' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                🖼️ Foto
            </a>
            <a href="{{ route('gallery.index', ['type' => 'video']) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('type') == 'video' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                🎬 Video
            </a>
        </div>
        
        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('gallery.index', array_filter(['type' => request('type')])) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ !request('category') ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua Kategori
            </a>
            <a href="{{ route('gallery.index', array_filter(['type' => request('type'), 'category' => 'event'])) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('category') == 'event' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Event
            </a>
            <a href="{{ route('gallery.index', array_filter(['type' => request('type'), 'category' => 'activity'])) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('category') == 'activity' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Kegiatan
            </a>
            <a href="{{ route('gallery.index', array_filter(['type' => request('type'), 'category' => 'member'])) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('category') == 'member' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Member
            </a>
            <a href="{{ route('gallery.index', array_filter(['type' => request('type'), 'category' => 'other'])) }}" 
                class="px-6 py-2 rounded-full font-medium transition {{ request('category') == 'other' ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Lainnya
            </a>
        </div>
    </div>

    @if($featuredGalleries->isNotEmpty())
    <!-- Featured Gallery -->
    <div class="mb-12">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Media Pilihan</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-teal-600 to-cyan-600 mx-auto rounded"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredGalleries as $gallery)
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer gallery-item" 
                data-image="{{ $gallery->type === 'video' ? $gallery->youtube_thumbnail : asset('storage/' . $gallery->image) }}"
                data-title="{{ $gallery->title }}"
                data-description="{{ $gallery->description }}"
                data-type="{{ $gallery->type }}"
                data-youtube-id="{{ $gallery->youtube_id }}">
                
                <!-- Star Badge -->
                <div class="absolute top-4 right-4 z-10 bg-gradient-to-r from-yellow-400 to-orange-400 text-white rounded-full p-2 shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                
                <!-- Image/Video -->
                <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                    @if($gallery->type === 'video')
                        <img src="{{ $gallery->youtube_thumbnail }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                <svg class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    @endif
                </div>
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                    <div class="p-6 text-white w-full">
                        <h3 class="text-xl font-bold mb-2">{{ $gallery->title }}</h3>
                        @if($gallery->description)
                            <p class="text-sm text-gray-200 mb-2">{{ Str::limit($gallery->description, 80) }}</p>
                        @endif
                        @if($gallery->event)
                            <p class="text-xs text-teal-300">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>{{ $gallery->event->title }}
                            </p>
                        @endif
                        <div class="mt-3 flex items-center text-sm">
                            <span class="bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                                {{ ucfirst($gallery->category) }}
                            </span>
                            <span class="ml-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Gallery -->
    <div>
        @if(!$featuredGalleries->isNotEmpty())
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Semua Media</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-teal-600 to-cyan-600 mx-auto rounded"></div>
        </div>
        @endif

        @if($galleries->isNotEmpty())
        <!-- Masonry Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300 cursor-pointer gallery-item"
                data-image="{{ $gallery->type === 'video' ? $gallery->youtube_thumbnail : asset('storage/' . $gallery->image) }}"
                data-title="{{ $gallery->title }}"
                data-description="{{ $gallery->description }}"
                data-type="{{ $gallery->type }}"
                data-youtube-id="{{ $gallery->youtube_id }}">
                
                <!-- Image/Video -->
                <div class="bg-gray-200 relative">
                    @if($gallery->type === 'video')
                        <img src="{{ $gallery->youtube_thumbnail }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Video Badge -->
                        <div class="absolute bottom-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">
                            VIDEO
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                            alt="{{ $gallery->title }}" 
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                    @endif
                </div>
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                    <div class="p-4 text-white w-full">
                        <h4 class="font-semibold mb-1">{{ Str::limit($gallery->title, 40) }}</h4>
                        @if($gallery->event)
                            <p class="text-xs text-teal-300">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>{{ Str::limit($gallery->event->title, 30) }}
                            </p>
                        @endif
                        <span class="text-xs bg-white/20 px-2 py-1 rounded mt-2 inline-block backdrop-blur-sm">
                            {{ ucfirst($gallery->category) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $galleries->appends(['type' => request('type'), 'category' => request('category')])->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada foto di galeri</p>
            @if(request('category'))
            <a href="{{ route('gallery.index') }}" class="text-teal-600 hover:underline mt-2 inline-block">
                Lihat semua foto
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center p-4">
    <button id="closeLightbox" class="absolute top-6 right-6 text-white text-4xl hover:text-gray-300 transition z-10">
        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
    </button>
    
    <button id="prevImage" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white text-5xl hover:text-gray-300 transition z-10">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    
    <button id="nextImage" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white text-5xl hover:text-gray-300 transition z-10">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    
    <div class="max-w-6xl max-h-full flex flex-col items-center">
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
        <div id="lightboxVideo" class="hidden w-full max-w-4xl aspect-video">
            <iframe id="lightboxYoutubePlayer" width="100%" height="100%" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded-lg shadow-2xl"></iframe>
        </div>
        <div class="mt-6 text-white text-center max-w-2xl">
            <h3 id="lightboxTitle" class="text-2xl font-bold mb-2"></h3>
            <p id="lightboxDescription" class="text-gray-300"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxVideo = document.getElementById('lightboxVideo');
    const lightboxYoutubePlayer = document.getElementById('lightboxYoutubePlayer');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxDescription = document.getElementById('lightboxDescription');
    const closeLightbox = document.getElementById('closeLightbox');
    const prevImage = document.getElementById('prevImage');
    const nextImage = document.getElementById('nextImage');
    
    let currentIndex = 0;
    let allItems = [];
    
    // Build items array
    galleryItems.forEach((item, index) => {
        allItems.push({
            src: item.dataset.image,
            title: item.dataset.title,
            description: item.dataset.description,
            type: item.dataset.type || 'image',
            youtubeId: item.dataset.youtubeId
        });
        
        item.addEventListener('click', function() {
            currentIndex = index;
            openLightbox();
        });
    });
    
    function openLightbox() {
        const item = allItems[currentIndex];
        
        if (item.type === 'video' && item.youtubeId) {
            // Show video, hide image
            lightboxImage.classList.add('hidden');
            lightboxVideo.classList.remove('hidden');
            lightboxYoutubePlayer.src = `https://www.youtube.com/embed/${item.youtubeId}?autoplay=1`;
        } else {
            // Show image, hide video
            lightboxVideo.classList.add('hidden');
            lightboxImage.classList.remove('hidden');
            lightboxImage.src = item.src;
            lightboxYoutubePlayer.src = ''; // Stop video
        }
        
        lightboxTitle.textContent = item.title;
        lightboxDescription.textContent = item.description || '';
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightboxFn() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        lightboxYoutubePlayer.src = ''; // Stop video when closing
        document.body.style.overflow = 'auto';
    }
    
    closeLightbox.addEventListener('click', closeLightboxFn);
    
    // Close on background click
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightboxFn();
        }
    });
    
    // Navigation
    prevImage.addEventListener('click', function(e) {
        e.stopPropagation();
        currentIndex = (currentIndex - 1 + allItems.length) % allItems.length;
        openLightbox();
    });
    
    nextImage.addEventListener('click', function(e) {
        e.stopPropagation();
        currentIndex = (currentIndex + 1) % allItems.length;
        openLightbox();
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                closeLightboxFn();
            } else if (e.key === 'ArrowLeft') {
                currentIndex = (currentIndex - 1 + allImages.length) % allImages.length;
                openLightbox();
            } else if (e.key === 'ArrowRight') {
                currentIndex = (currentIndex + 1) % allImages.length;
                openLightbox();
            }
        }
    });
});
</script>
@endpush
