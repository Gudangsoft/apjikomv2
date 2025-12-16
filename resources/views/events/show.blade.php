@extends('layouts.main')

@section('title', $event->title)

@section('content')
<!-- Event Hero Section -->
<section class="relative bg-gradient-to-br from-purple-600 via-purple-700 to-purple-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-purple-200">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('events.index') }}" class="hover:text-white">Agenda</a></li>
                    <li>/</li>
                    <li class="text-white">{{ Str::limit($event->title, 50) }}</li>
                </ol>
            </nav>
            
            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Date Card -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 text-center sticky top-24">
                        <div class="text-6xl font-bold text-purple-600 mb-2">
                            {{ $event->event_date->format('d') }}
                        </div>
                        <div class="text-lg font-semibold text-gray-700 uppercase mb-1">
                            {{ $event->event_date->format('F') }}
                        </div>
                        <div class="text-sm text-gray-500 mb-4">
                            {{ $event->event_date->format('Y') }}
                        </div>
                        
                        @if($event->event_time)
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center justify-center text-purple-600 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ date('H:i', strtotime($event->event_time)) }} WIB</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start text-gray-600 text-sm">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-left">{{ $event->location }}</span>
                        </div>
                        
                        @if($event->registration_link)
                        <div class="mt-6">
                            <a href="{{ $event->registration_link }}" target="_blank" 
                               class="block w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-bold transition-all hover:shadow-lg transform hover:scale-105">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Daftar Sekarang
                                </div>
                            </a>
                        </div>
                        @else
                        <!-- Event RSVP Buttons -->
                        @auth
                            @if($event->isUserRegistered(Auth::id()))
                                <div class="mt-6 space-y-3">
                                    <div class="bg-green-50 border-2 border-green-500 text-green-700 px-4 py-3 rounded-xl font-semibold text-center">
                                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Anda Sudah Terdaftar
                                    </div>
                                    <form action="{{ route('member.events.cancel', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Batalkan pendaftaran event ini?')"
                                                class="block w-full bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-xl font-semibold transition">
                                            Batalkan Pendaftaran
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mt-6">
                                    <form action="{{ route('member.events.register', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold transition-all hover:shadow-lg transform hover:scale-105">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Daftar Event Ini
                                            </div>
                                        </button>
                                    </form>
                                    <p class="text-xs text-center text-gray-600 mt-2">
                                        <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                        </svg>
                                        {{ $event->registered_count ?? 0 }} orang sudah terdaftar
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="mt-6">
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold transition-all hover:shadow-lg transform hover:scale-105 text-center">
                                    Login untuk Daftar
                                </a>
                            </div>
                        @endauth
                        @endif
                    </div>
                </div>
                
                <!-- Event Info -->
                <div class="md:col-span-2">
                    @if($event->category)
                    <div class="mb-4">
                        <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                            {{ $event->category->name }}
                        </span>
                    </div>
                    @endif
                    
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">{{ $event->title }}</h1>
                    
                    @if($event->image)
                    <div class="rounded-2xl overflow-hidden shadow-2xl mb-6">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                             class="w-full h-auto">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Content -->
<section class="py-16 bg-gradient-to-br from-purple-50 via-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-8">
                <h2 class="text-3xl font-bold mb-6 text-gray-900 flex items-center">
                    <span class="text-4xl mr-3">📋</span>
                    Tentang Kegiatan
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">{{ $event->description }}</p>
                </div>
            </div>
            
            <!-- Related Events -->
            @if($relatedEvents->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold mb-8 text-gray-900">Kegiatan Mendatang Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedEvents as $related)
                    <a href="{{ route('events.show', $related->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                            @if($related->image)
                            <div class="h-40 overflow-hidden">
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            @else
                            <div class="h-40 bg-gradient-to-br from-purple-500 to-purple-700"></div>
                            @endif
                            
                            <div class="p-5">
                                @if($related->category)
                                <span class="inline-flex items-center bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-semibold mb-2">
                                    {{ $related->category->name }}
                                </span>
                                @endif
                                
                                <div class="text-sm text-purple-600 font-semibold mb-2">
                                    {{ $related->event_date->format('d M Y') }}
                                    @if($related->event_time)
                                        • {{ date('H:i', strtotime($related->event_time)) }}
                                    @endif
                                </div>
                                
                                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition">
                                    {{ $related->title }}
                                </h3>
                                
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ Str::limit($related->location, 30) }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="text-center mt-8">
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-semibold transition-all hover:shadow-lg">
                        Lihat Semua Kegiatan
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
