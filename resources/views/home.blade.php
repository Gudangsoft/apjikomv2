@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
<!-- Slider Section -->
@if(isset($sliders) && $sliders->count() > 0)
<section class="relative w-full">
    <div class="slider-container relative overflow-hidden w-full" style="height: 100vh; max-height: 800px;">
        @foreach($sliders as $index => $slider)
        <div class="slider-item absolute inset-0 w-full h-full transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>
            </div>
            <div class="relative h-full w-full flex items-center">
                <div class="w-full px-4 md:px-8 lg:px-16">
                    <div class="max-w-4xl text-white">
                        @if($slider->title)
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp">{{ $slider->title }}</h1>
                        @endif
                        @if($slider->description)
                        <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-gray-200 animate-fadeInUp animation-delay-200">{{ $slider->description }}</p>
                        @endif
                        @if($slider->button_text && $slider->button_link)
                        <a href="{{ $slider->button_link }}" class="inline-block bg-white text-purple-600 px-10 py-4 rounded-lg font-semibold hover:bg-purple-50 transition text-lg animate-fadeInUp animation-delay-400">
                            {{ $slider->button_text }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    @if($sliders->count() > 1)
    <button onclick="previousSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full transition z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full transition z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    
    <!-- Indicators -->
    <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3 z-10">
        @foreach($sliders as $index => $slider)
        <button onclick="goToSlide({{ $index }})" class="slider-indicator w-3 h-3 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" data-indicator="{{ $index }}"></button>
        @endforeach
    </div>
    @endif
</section>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
    opacity: 0;
}

.animation-delay-400 {
    animation-delay: 0.4s;
    opacity: 0;
}
</style>

<script>
let currentSlide = 0;
const totalSlides = {{ $sliders->count() }};
let autoSlideInterval;

function showSlide(index) {
    const slides = document.querySelectorAll('.slider-item');
    const indicators = document.querySelectorAll('.slider-indicator');
    
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.remove('opacity-0');
            slide.classList.add('opacity-100');
        } else {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
        }
    });
    
    indicators.forEach((indicator, i) => {
        if (i === index) {
            indicator.classList.remove('bg-white/50');
            indicator.classList.add('bg-white');
        } else {
            indicator.classList.remove('bg-white');
            indicator.classList.add('bg-white/50');
        }
    });
    
    currentSlide = index;
}

function nextSlide() {
    const next = (currentSlide + 1) % totalSlides;
    showSlide(next);
    resetAutoSlide();
}

function previousSlide() {
    const prev = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(prev);
    resetAutoSlide();
}

function goToSlide(index) {
    showSlide(index);
    resetAutoSlide();
}

function startAutoSlide() {
    if (totalSlides > 1) {
        autoSlideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
}

function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
}

// Start auto slide on page load
document.addEventListener('DOMContentLoaded', () => {
    startAutoSlide();
});
</script>
@else
<!-- Default Hero Section if no sliders -->
<section class="hero-section text-white py-24">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-6">{{ $globalSiteName }}</h1>
            <p class="text-lg md:text-xl mb-8 text-purple-100">Meningkatkan kualitas publikasi ilmiah di bidang informatika dan komputer di Indonesia</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('registration.create') }}" class="bg-white text-purple-600 px-8 py-3 rounded font-semibold hover:bg-gray-100 transition">Bergabung Sekarang</a>
                <a href="{{ route('news.index') }}" class="border-2 border-white text-white px-8 py-3 rounded font-semibold hover:bg-white hover:text-purple-600 transition">Lihat Berita</a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
<section class="py-12 bg-white border-b">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 stats-card">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ format_stat_number($totalOrganizationMembers) }}</div>
                <div class="text-gray-600 text-sm">Anggota PT</div>
            </div>
            <div class="text-center p-6 stats-card">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ format_stat_number($totalIndividualMembers) }}</div>
                <div class="text-gray-600 text-sm">Anggota Individu</div>
            </div>
            <div class="text-center p-6 stats-card">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ format_stat_number($totalActiveMembers) }}</div>
                <div class="text-gray-600 text-sm">Anggota Aktif</div>
            </div>
            <div class="text-center p-6 stats-card">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ number_format($satisfactionRate) }}%</div>
                <div class="text-gray-600 text-sm">Tingkat Kepuasan</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 via-purple-50 to-gray-50 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-30 -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-30 -ml-48 -mb-48"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Image -->
            <div class="relative" data-aos="fade-right">
                <div class="relative">
                    <!-- Main Image Container with rounded corners -->
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        @if($aboutImage ?? null)
                        <img src="{{ asset('storage/' . $aboutImage) }}" 
                             alt="APJIKOM" 
                             class="w-full h-auto object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&h=600&fit=crop'">
                        @else
                        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&h=600&fit=crop" 
                             alt="APJIKOM" 
                             class="w-full h-auto object-cover">
                        @endif
                        
                        <!-- Overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent"></div>
                    </div>
                    
                    <!-- Logo Badge -->
                    <div class="absolute -top-6 -left-6 w-20 h-20 bg-cyan-500 rounded-2xl shadow-xl flex items-center justify-center transform rotate-12">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                        </svg>
                    </div>
                    
                    <!-- Stats Badge -->
                    <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-2xl shadow-2xl p-6 border-4 border-white">
                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-cyan-500">{{ $aboutStat1Number ?? '25' }}</div>
                                <div class="text-sm text-gray-600 font-medium">{!! nl2br(e($aboutStat1Label ?? 'Tahun<br>Berkiprah')) !!}</div>
                            </div>
                            <div class="h-16 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-purple-600">{{ $aboutStat2Number ?? '+68' }}</div>
                                <div class="text-sm text-gray-600 font-medium">{{ $aboutStat2Label ?? 'Penghargaan' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative dots -->
                <div class="absolute -top-4 -right-4 w-32 h-32 opacity-30">
                    <div class="grid grid-cols-4 gap-2">
                        @for($i = 0; $i < 16; $i++)
                        <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Side - Content -->
            <div class="lg:pl-8" data-aos="fade-left">
                <div class="mb-6">
                    <span class="text-cyan-500 font-bold text-sm uppercase tracking-wider">
                        {{ setting('about_tag', 'APJIKOM') }}
                    </span>
                    <x-section-heading 
                        setting-key="section_label_about" 
                        title="{{ setting('section_label_about', 'Asosiasi Pendidikan Tinggi Informatika dan Komputer') }}"
                        align="left"
                        class="mt-2"
                    />
                </div>
                
                @php
                    $aboutText = $aboutDescription ?? 'Asosiasi yang mewadahi perguruan tinggi di indonesia yang memiliki rumpun ilmu komputer. APTIKOM mempunyai tujuan untuk meningkatkan kualitas pendidikan, penelitian dan pengabdian kepada masyarakat di bidang teknologi informasi dan komputer.';
                    $textLength = mb_strlen($aboutText);
                    $showReadMore = $textLength > 200;
                @endphp
                
                <div class="text-gray-600 text-base leading-relaxed mb-8">
                    @if($showReadMore)
                        <div id="about-description-short" class="about-text">
                            {{ mb_substr($aboutText, 0, 200) }}...
                            <button onclick="toggleReadMore()" class="text-cyan-600 hover:text-cyan-700 font-semibold ml-1 inline-flex items-center gap-1">
                                Baca Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="about-description-full" class="about-text hidden">
                            {{ $aboutText }}
                            <button onclick="toggleReadMore()" class="text-cyan-600 hover:text-cyan-700 font-semibold ml-1 inline-flex items-center gap-1">
                                Tutup
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <p>{{ $aboutText }}</p>
                    @endif
                </div>

                <!-- Features List -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $aboutFeature1Title ?? 'Meningkatkan Kualitas Pendidikan' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $aboutFeature1Desc ?? 'Menekankan kerja sama antara perguruan tinggi, industri, dan pemerintah untuk mengembangkan publikasi ilmiah.' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $aboutFeature2Title ?? 'Memperkuat Kolaborasi Strategis' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $aboutFeature2Desc ?? 'Menekankan pengembangan dan penerapan teknologi terbaru dalam publikasi dan pengelolaan jurnal ilmiah.' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $aboutFeature3Title ?? 'Mengembangkan Standar Kurikulum' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $aboutFeature3Desc ?? 'Menekankan kontribusi nyata dalam publikasi, riset, dan pengabdian masyarakat melalui teknologi dan kolaborasi.' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Meningkatkan Kapasitas Anggota</h4>
                            <p class="text-gray-600 text-sm mt-1">Memberikan pelatihan dan pengembangan untuk meningkatkan kompetensi tenaga pendidik.</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="flex gap-4">
                    @php
                        $ctaLabel = $aboutCtaLabel ?? 'Bergabung Sekarang';
                        $ctaLink = $aboutCtaLink ?? route('register');
                        // Check if it's an external URL
                        $isExternal = filter_var($ctaLink, FILTER_VALIDATE_URL) !== false;
                        // If not external and doesn't start with /, add it
                        if (!$isExternal && !str_starts_with($ctaLink, '/')) {
                            $ctaLink = '/' . $ctaLink;
                        }
                    @endphp
                    <a href="{{ $ctaLink }}" 
                       @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                       class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span>{{ $ctaLabel }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured News -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Berita Terkini</h2>
            <a href="{{ route('news.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($featuredNews as $news)
            <article class="news-card bg-white rounded overflow-hidden">
                @if($news->image)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700"></div>
                @endif
                <div class="p-5">
                    <div class="flex items-center text-xs text-gray-500 mb-3">
                        <span class="bg-purple-50 text-purple-600 px-3 py-1 rounded-full font-medium mr-2">
                            {{ $news->category->name }}
                        </span>
                        <span>{{ $news->published_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-900 line-clamp-2">
                        <a href="{{ route('news.show', $news->slug) }}" class="hover:text-purple-600">
                            {{ $news->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($news->excerpt, 120) }}</p>
                    <a href="{{ route('news.show', $news->slug) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Baca Selengkapnya →</a>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-500">
                Belum ada berita tersedia.
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-16 bg-gradient-to-br from-purple-50 via-white to-blue-50 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <div class="text-purple-600 font-semibold text-sm mb-2 uppercase tracking-wide">📅 AGENDA</div>
                <h2 class="text-3xl font-bold text-gray-900">Kegiatan Mendatang</h2>
            </div>
            <a href="{{ route('events.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium text-sm transition-all hover:shadow-lg hover:scale-105">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($upcomingEvents as $event)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                <div class="flex">
                    <!-- Date Badge - More prominent -->
                    <div class="w-32 bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 flex flex-col items-center justify-center text-white p-6 relative">
                        <div class="absolute top-2 right-2 w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                        <div class="text-4xl font-bold mb-1">{{ $event->event_date->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider font-semibold mb-1">{{ $event->event_date->format('M') }}</div>
                        <div class="text-xs opacity-80">{{ $event->event_date->format('Y') }}</div>
                        @if($event->event_time)
                        <div class="mt-3 text-xs bg-white/20 px-2 py-1 rounded-full">
                            {{ date('H:i', strtotime($event->event_time)) }}
                        </div>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 p-6">
                        <!-- Category Badge -->
                        @if($event->category)
                        <div class="mb-3">
                            <span class="inline-flex items-center bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                {{ $event->category->name }}
                            </span>
                        </div>
                        @endif
                        
                        <h3 class="text-lg font-bold mb-3 text-gray-900 line-clamp-2 group-hover:text-purple-600 transition">
                            <a href="{{ route('events.show', $event->slug) }}">
                                {{ $event->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($event->description, 120) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium">{{ $event->location ?? 'TBA' }}</span>
                            </div>
                            
                            <a href="{{ route('events.show', $event->slug) }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center group-hover:translate-x-1 transition">
                                Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        
                        @if($event->registration_link)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ $event->registration_link }}" target="_blank" class="inline-flex items-center text-xs font-semibold text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-2 rounded-lg transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Daftar Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Kegiatan Terjadwal</h3>
                <p class="text-gray-500">Nantikan update kegiatan menarik dari APJIKOM</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-16 apjikom-purple text-white">
    <div class="container mx-auto px-4">
        <x-section-heading 
            setting-key="section_label_benefits" 
            title="Keuntungan Menjadi Anggota APJIKOM"
            align="center"
            :dark-mode="true"
        />
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-3">Koneksi Luas</h3>
                <p class="text-purple-100 text-sm">Jejaring perguruan tinggi, industri, pemerintah untuk kolaborasi publikasi ilmiah.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-3">Pengembangan & Sertifikasi</h3>
                <p class="text-purple-100 text-sm">Akses pelatihan pengelolaan jurnal dan sertifikasi profesional.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-3">Akses Kegiatan & Informasi</h3>
                <p class="text-purple-100 text-sm">Ikuti seminar, workshop, dan dapatkan update terbaru seputar publikasi ilmiah.</p>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('registration.create') }}" class="bg-white text-purple-600 px-8 py-3 rounded font-semibold hover:bg-gray-100 transition inline-block">Daftar Sekarang</a>
        </div>
    </div>
</section>

<!-- Featured Events Section -->
@if(isset($featuredEvents) && $featuredEvents->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <x-section-heading 
            setting-key="section_label_upcoming_events" 
            title="Ikuti terus Kegiatan Kami"
            align="center"
        />
        
        <div class="relative mt-8">
            <!-- Events Slider Container -->
            <div class="events-slider-container overflow-hidden">
                <div class="events-slider flex transition-transform duration-500 ease-in-out" id="eventsSlider">
                    @foreach($featuredEvents as $event)
                    <div class="event-slide flex-shrink-0 w-full md:w-1/2 lg:w-1/4 px-3">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 h-full">
                            <!-- Event Image -->
                            <div class="relative h-64 overflow-hidden">
                                @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" 
                                     alt="{{ $event->title }}" 
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                                
                                <!-- Event Badge -->
                                <div class="absolute top-3 right-3 bg-white px-3 py-1 rounded-full shadow-md">
                                    <span class="text-sm font-semibold text-gray-700">Event</span>
                                </div>
                            </div>
                            
                            <!-- Event Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                    {{ $event->title }}
                                </h3>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-start text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $event->event_date->format('d F Y') }}</span>
                                    </div>
                                    
                                    @if($event->event_time)
                                    <div class="flex items-start text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ date('H:i', strtotime($event->event_time)) }} WIB</span>
                                    </div>
                                    @endif
                                    
                                    <div class="flex items-start text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="line-clamp-2">{{ $event->location }}</span>
                                    </div>
                                </div>
                                
                                <!-- CTA Button -->
                                <a href="{{ route('events.show', $event->slug) }}" 
                                   class="inline-flex items-center justify-center w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                                    <span>Lihat Detail</span>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Navigation Arrows (hanya muncul jika lebih dari 4 events) -->
            @if($featuredEvents->count() > 4)
            <button onclick="slideEvents('prev')" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white hover:bg-gray-100 text-gray-800 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="slideEvents('next')" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white hover:bg-gray-100 text-gray-800 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            @endif
        </div>
        
        <!-- Link ke halaman semua events -->
        <div class="text-center mt-12">
            <a href="{{ route('events.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                <span>Lihat Semua Kegiatan</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<script>
let currentEventSlide = 0;
const totalEventSlides = {{ $featuredEvents->count() }};
const eventsPerView = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 768 ? 2 : 1);
const maxEventSlide = Math.max(0, totalEventSlides - eventsPerView);

function slideEvents(direction) {
    const slider = document.getElementById('eventsSlider');
    
    if (direction === 'next') {
        currentEventSlide = Math.min(currentEventSlide + 1, maxEventSlide);
    } else {
        currentEventSlide = Math.max(currentEventSlide - 1, 0);
    }
    
    const slideWidth = 100 / eventsPerView;
    slider.style.transform = `translateX(-${currentEventSlide * slideWidth}%)`;
}

// Auto slide setiap 5 detik
setInterval(() => {
    if (currentEventSlide >= maxEventSlide) {
        currentEventSlide = 0;
    } else {
        currentEventSlide++;
    }
    const slider = document.getElementById('eventsSlider');
    const slideWidth = 100 / eventsPerView;
    slider.style.transform = `translateX(-${currentEventSlide * slideWidth}%)`;
}, 5000);
</script>
@endif

<!-- Gallery Section -->
@if(isset($galleries) && $galleries->count() > 0)
<section class="py-20 bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <span class="inline-flex items-center justify-center editable-label cursor-pointer group" 
                      setting-key="section_label_gallery" 
                      data-default="Galeri Foto"
                      onclick="editSectionLabel(this)">
                    {{ setting('section_label_gallery', 'Galeri Foto') }}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <svg class="w-5 h-5 ml-2 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        @endif
                    @endauth
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Dokumentasi kegiatan dan event APJIKOM</p>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-2xl transition duration-300">
                <a href="{{ route('gallery.index') }}" class="block">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                        @if($gallery->type === 'video')
                            <!-- Video Thumbnail with Play Button -->
                            <img src="{{ $gallery->youtube_thumbnail }}" 
                                alt="{{ $gallery->title }}" 
                                class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <!-- Image -->
                            <img src="{{ asset('storage/' . $gallery->image) }}" 
                                alt="{{ $gallery->title }}" 
                                class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        @endif
                    </div>
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                        <div class="p-4 text-white w-full">
                            <h4 class="font-semibold text-sm mb-1">{{ Str::limit($gallery->title, 40) }}</h4>
                            <span class="text-xs bg-teal-500/80 px-2 py-1 rounded inline-block backdrop-blur-sm">
                                {{ $gallery->type === 'video' ? '📹 Video' : ucfirst($gallery->category) }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gallery.index') }}" 
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg hover:from-teal-700 hover:to-cyan-700 transition shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Lihat Semua Media
            </a>
        </div>
    </div>
</section>
@endif

<!-- FAQ & Testimonials Section -->
@if((isset($faqs) && $faqs->count() > 0) || (isset($testimonials) && $testimonials->count() > 0))
<section class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">FAQ & Testimoni</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Pertanyaan yang sering diajukan dan pengalaman member kami</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto">
            <!-- FAQ Column -->
            @if(isset($faqs) && $faqs->count() > 0)
            <div>
                <div class="mb-8">
                    <x-section-heading 
                        setting-key="section_label_faq" 
                        title="Pertanyaan yang Sering Diajukan"
                        subtitle="Temukan jawaban atas pertanyaan Anda"
                        align="left"
                    />
                </div>
                
                <div class="space-y-3">
                    @foreach($faqs as $index => $faq)
                    <div class="faq-card bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100">
                        <button onclick="toggleFaq({{ $index }})" 
                                class="faq-question w-full text-left px-6 py-4 flex items-start justify-between gap-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3 flex-1">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <h3 class="text-base font-semibold text-gray-900 pr-2">{{ $faq->question }}</h3>
                                </div>
                            </div>
                            <div class="flex-shrink-0 pt-0.5">
                                <svg class="faq-icon-{{ $index }} w-5 h-5 text-purple-600 transition-transform duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div id="faq-answer-{{ $index }}" 
                             class="faq-answer hidden px-6 pb-4 pt-1" 
                             style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out;">
                            <div class="ml-11 pr-8">
                                <p class="text-gray-700 leading-relaxed text-sm">{{ $faq->answer }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- View All FAQs Button -->
                <div class="text-center mt-8">
                    <a href="{{ route('faqs.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm">
                        <span>Lihat Semua FAQ</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
            
            <!-- Testimonials Column -->
            @if(isset($testimonials) && $testimonials->count() > 0)
            <div>
                <div class="mb-8">
                    <x-section-heading 
                        setting-key="section_label_testimonials" 
                        title="Testimoni Member"
                        subtitle="Apa kata mereka tentang APJIKOM"
                        align="left"
                    />
                </div>
                
                <div class="space-y-4">
                    @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="flex-shrink-0">
                                @if($testimonial->photo)
                                    <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                         alt="{{ $testimonial->member && $testimonial->member->user ? $testimonial->member->user->name : 'Member' }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-purple-200">
                                @elseif($testimonial->member && $testimonial->member->photo)
                                    <img src="{{ asset('storage/' . $testimonial->member->photo) }}" 
                                         alt="{{ $testimonial->member->user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-purple-200">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ $testimonial->member && $testimonial->member->user ? strtoupper(substr($testimonial->member->user->name, 0, 1)) : '?' }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-base">
                                    {{ $testimonial->member && $testimonial->member->user ? $testimonial->member->user->name : 'Member Tidak Tersedia' }}
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    {{ $testimonial->member && $testimonial->member->position ? $testimonial->member->position : 'Member APJIKOM' }}
                                </p>
                                @if($testimonial->member && $testimonial->member->institution_name)
                                <p class="text-gray-500 text-xs mt-0.5">{{ $testimonial->member->institution_name }}</p>
                                @endif
                            </div>
                            @if($testimonial->is_featured)
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-700 rounded-full text-xs font-medium">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Featured
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Star Rating -->
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        
                        <!-- Testimonial Text -->
                        <p class="text-gray-700 leading-relaxed text-sm italic">"{{ $testimonial->content }}"</p>
                    </div>
                    @endforeach
                </div>
                
                <!-- View All Testimonials Button -->
                <div class="text-center mt-8">
                    <a href="{{ route('testimonials.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm">
                        <span>Lihat Semua Testimoni</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
function toggleFaq(index) {
    const answer = document.getElementById(`faq-answer-${index}`);
    const icon = document.querySelector(`.faq-icon-${index}`);
    const card = answer.closest('.faq-card');
    
    if (answer.classList.contains('hidden')) {
        // Close all other FAQs
        document.querySelectorAll('.faq-answer').forEach((item, i) => {
            if (i !== index) {
                item.classList.add('hidden');
                item.style.maxHeight = '0';
                document.querySelector(`.faq-icon-${i}`)?.classList.remove('rotate-180');
                item.closest('.faq-card')?.classList.remove('ring-2', 'ring-purple-500');
            }
        });
        
        // Open clicked FAQ
        answer.classList.remove('hidden');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.classList.add('rotate-180');
        card.classList.add('ring-2', 'ring-purple-500');
    } else {
        // Close clicked FAQ
        answer.style.maxHeight = '0';
        setTimeout(() => {
            answer.classList.add('hidden');
        }, 400);
        icon.classList.remove('rotate-180');
        card.classList.remove('ring-2', 'ring-purple-500');
    }
}
</script>
@endif

<!-- Partners Section -->
@if(isset($partners) && $partners->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <x-section-heading 
                setting-key="section_label_partners" 
                title="Partner Kami"
                subtitle="Dipercaya oleh berbagai institusi terkemuka"
                align="center"
            />
        </div>
        
        <!-- Partners Slider -->
        <div class="relative overflow-hidden">
            <div class="swiper partnersSwiper">
                <div class="swiper-wrapper items-center">
                    @foreach($partners as $partner)
                    <div class="swiper-slide">
                        <div class="flex items-center justify-center p-6 h-32">
                            @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="block transition-transform hover:scale-110 duration-300">
                                    <img src="{{ $partner->logo_url }}" 
                                         alt="{{ $partner->name }}"
                                         class="max-w-full max-h-24 object-contain grayscale hover:grayscale-0 transition-all duration-300"
                                         title="{{ $partner->name }}">
                                </a>
                            @else
                                <img src="{{ $partner->logo_url }}" 
                                     alt="{{ $partner->name }}"
                                     class="max-w-full max-h-24 object-contain grayscale hover:grayscale-0 transition-all duration-300"
                                     title="{{ $partner->name }}">
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
        <x-section-heading 
            setting-key="section_label_cta" 
            title="Mari Bergabung dengan APJIKOM"
            align="center"
        />
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">Kembangkan jaringan, tingkatkan profesionalisme, dan majukan publikasi ilmiah Indonesia bersama kami.</p>
        <a href="{{ route('registration.create') }}" class="apjikom-purple text-white px-8 py-3 rounded font-semibold hover:bg-purple-700 transition inline-block">Bergabung Sekarang</a>
    </div>
</section>

<script>
function toggleReadMore() {
    const shortText = document.getElementById('about-description-short');
    const fullText = document.getElementById('about-description-full');
    
    if (shortText.classList.contains('hidden')) {
        shortText.classList.remove('hidden');
        fullText.classList.add('hidden');
    } else {
        shortText.classList.add('hidden');
        fullText.classList.remove('hidden');
    }
}
</script>
@endsection
