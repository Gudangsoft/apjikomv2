@extends('layouts.main')

@section('title', 'Layanan Kami')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-teal-600 to-cyan-700 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Layanan & Program</h1>
            <p class="text-xl text-teal-100">Berbagai layanan profesional untuk mendukung pengembangan jurnal ilmiah Anda</p>
        </div>
    </div>
</div>

<!-- Services Grid -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            
            @if($services->count() > 0)
                @foreach($services as $service)
                    @php
                        $colorMap = [
                            'blue' => ['from' => 'blue-500', 'to' => 'blue-600', 'text' => 'blue-600'],
                            'purple' => ['from' => 'purple-500', 'to' => 'purple-600', 'text' => 'purple-600'],
                            'green' => ['from' => 'green-500', 'to' => 'green-600', 'text' => 'green-600'],
                            'orange' => ['from' => 'orange-500', 'to' => 'orange-600', 'text' => 'orange-600'],
                            'red' => ['from' => 'red-500', 'to' => 'red-600', 'text' => 'red-600'],
                            'teal' => ['from' => 'teal-500', 'to' => 'teal-600', 'text' => 'teal-600'],
                            'indigo' => ['from' => 'indigo-500', 'to' => 'indigo-600', 'text' => 'indigo-600'],
                        ];
                        $colors = $colorMap[$service->color] ?? $colorMap['blue'];
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 group">
                        <div class="bg-gradient-to-r from-{{ $colors['from'] }} to-{{ $colors['to'] }} p-6">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                                @if($service->icon)
                                    <i class="{{ $service->icon }} text-3xl text-{{ $colors['text'] }}"></i>
                                @else
                                    <svg class="w-8 h-8 text-{{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-white">{{ $service->title }}</h3>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 mb-6 leading-relaxed">
                                {{ $service->description }}
                            </p>
                            
                            @if($service->features && count($service->features) > 0)
                                <ul class="space-y-3 mb-6">
                                    @foreach($service->features as $feature)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-{{ $colors['text'] }} mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-700">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            
                            @if($service->cta_text && $service->cta_link)
                                <a href="{{ $service->cta_link }}" class="inline-flex items-center text-{{ $colors['text'] }} font-semibold hover:opacity-80">
                                    {{ $service->cta_text }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback jika belum ada data -->
                <!-- Konsultasi Jurnal -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 group">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Konsultasi Jurnal</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Dapatkan bimbingan dan konsultasi dari para ahli untuk meningkatkan kualitas pengelolaan jurnal ilmiah Anda.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Konsultasi sistem editorial</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Pengembangan website jurnal</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Strategi publikasi dan promosi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Optimalisasi proses review</span>
                        </li>
                    </ul>
                    <a href="#contact" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700">
                        Hubungi Kami
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pelatihan -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 group">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Pelatihan Pengelolaan Jurnal</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Program pelatihan komprehensif untuk meningkatkan kompetensi tim pengelola jurnal Anda.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Workshop pengelolaan jurnal digital</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Pelatihan OJS (Open Journal Systems)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Manajemen proses peer review</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Etika publikasi ilmiah</span>
                        </li>
                    </ul>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700">
                        Lihat Jadwal Pelatihan
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pendampingan Akreditasi -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 group">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Pendampingan Akreditasi</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Layanan pendampingan menyeluruh untuk proses akreditasi jurnal di ARJUNA/SINTA.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Persiapan dokumen akreditasi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Review compliance standar akreditasi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Konsultasi peningkatan SINTA</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Monitoring pasca akreditasi</span>
                        </li>
                    </ul>
                    <a href="#contact" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700">
                        Konsultasi Akreditasi
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Workshop & Webinar -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 group">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Workshop & Webinar</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Program workshop dan webinar rutin dengan narasumber ahli dari dalam dan luar negeri.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Webinar nasional dan internasional</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Workshop teknis pengelolaan jurnal</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Seminar tren publikasi ilmiah</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-orange-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Sertifikat peserta</span>
                        </li>
                    </ul>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700">
                        Lihat Event Mendatang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="contact" class="py-20 bg-gradient-to-r from-teal-600 to-cyan-700 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Tertarik dengan Layanan Kami?</h2>
        <p class="text-xl text-teal-100 mb-8 max-w-2xl mx-auto">
            Hubungi kami untuk informasi lebih lanjut dan konsultasi gratis
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(setting('contact_phone'))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_phone')) }}" target="_blank" class="px-8 py-4 bg-white text-teal-600 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi via WhatsApp
            </a>
            @endif
            @if(setting('contact_email'))
            <a href="mailto:{{ setting('contact_email') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-teal-600 transition inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Email Kami
            </a>
            @endif
        </div>
    </div>
</section>
@endsection
