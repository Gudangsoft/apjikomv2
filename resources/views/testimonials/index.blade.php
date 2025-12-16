@extends('layouts.main')

@section('title', 'Testimoni Member')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Testimoni Member</h1>
            <p class="text-xl text-purple-100">Apa kata mereka tentang APJIKOM</p>
        </div>
    </div>
</div>

<!-- Testimonials Content -->
<div class="container mx-auto px-4 py-12">
    @if($featuredTestimonials->isNotEmpty())
    <!-- Featured Testimonials -->
    <div class="mb-12">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Testimoni Pilihan</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredTestimonials as $testimonial)
            <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-purple-200 relative transform hover:scale-105 transition duration-300">
                <!-- Star Badge -->
                <div class="absolute -top-4 -right-4 bg-gradient-to-r from-yellow-400 to-orange-400 text-white rounded-full p-3 shadow-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                
                <!-- Quote Icon -->
                <div class="text-purple-600 mb-4">
                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                
                <!-- Message -->
                <p class="text-gray-700 mb-6 leading-relaxed italic">
                    "{{ $testimonial->content }}"
                </p>
                
                <!-- Rating -->
                <div class="flex items-center justify-center mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial->rating)
                            <svg class="w-5 h-5 text-yellow-400 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                
                <!-- Member Info -->
                <div class="flex items-center justify-center pt-4 border-t border-gray-200">
                    @if($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->member ? $testimonial->member->user->name : 'Member' }}" 
                            class="w-14 h-14 rounded-full object-cover border-2 border-purple-200 mr-3">
                    @elseif($testimonial->member && $testimonial->member->photo)
                        <img src="{{ asset('storage/' . $testimonial->member->photo) }}" alt="{{ $testimonial->member->user->name }}" 
                            class="w-14 h-14 rounded-full object-cover border-2 border-purple-200 mr-3">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-400 to-indigo-400 flex items-center justify-center text-white font-bold text-xl mr-3 border-2 border-purple-200">
                            {{ $testimonial->member && $testimonial->member->user ? strtoupper(substr($testimonial->member->user->name, 0, 1)) : '?' }}
                        </div>
                    @endif
                    <div class="text-left">
                        <p class="font-bold text-gray-800">
                            {{ $testimonial->member && $testimonial->member->user ? $testimonial->member->user->name : 'Member Tidak Tersedia' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $testimonial->member ? $testimonial->member->institution_name : 'APJIKOM Member' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Testimonials -->
    <div>
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Semua Testimoni</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded"></div>
        </div>

        @if($testimonials->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl p-6 transition duration-300">
                <!-- Quote Icon -->
                <div class="text-indigo-600 mb-4">
                    <svg class="w-10 h-10 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                
                <!-- Message -->
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "{{ Str::limit($testimonial->content, 150) }}"
                </p>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial->rating)
                            <svg class="w-4 h-4 text-yellow-400 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                    <span class="ml-2 text-sm text-gray-600">({{ $testimonial->rating }}/5)</span>
                </div>
                
                <!-- Member Info -->
                <div class="flex items-center pt-4 border-t border-gray-200">
                    @if($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->member ? $testimonial->member->user->name : 'Member' }}" 
                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                    @elseif($testimonial->member && $testimonial->member->photo)
                        <img src="{{ asset('storage/' . $testimonial->member->photo) }}" alt="{{ $testimonial->member->user->name }}" 
                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-400 flex items-center justify-center text-white font-bold mr-3">
                            {{ $testimonial->member && $testimonial->member->user ? strtoupper(substr($testimonial->member->user->name, 0, 1)) : '?' }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $testimonial->member && $testimonial->member->user ? $testimonial->member->user->name : 'Member Tidak Tersedia' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $testimonial->member ? $testimonial->member->institution_name : 'Member' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($testimonials->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $testimonials->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Belum ada testimoni</p>
        </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="mt-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 md:p-12 text-center text-white shadow-xl">
        <h3 class="text-3xl font-bold mb-4">Ingin Berbagi Pengalaman Anda?</h3>
        <p class="text-lg text-purple-100 mb-6 max-w-2xl mx-auto">
            Bergabunglah dengan APJIKOM dan rasakan manfaatnya. Pengalaman Anda sangat berharga bagi kami!
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            @guest
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-white text-purple-600 rounded-lg hover:bg-gray-100 transition font-semibold shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Daftar Sekarang
            </a>
            @endguest
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition font-semibold border-2 border-white">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
</style>
@endpush
