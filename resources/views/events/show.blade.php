@extends('layouts.main')

@section('title', $event->title)

@section('content')
<!-- Event Hero Section -->
<section class="relative bg-gradient-to-br from-purple-600 via-purple-700 to-purple-900 text-white overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-pink-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
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
                <!-- Date Card with enhanced styling -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 text-center sticky top-24 transform hover:scale-105 transition-all duration-300">
                        <!-- Decorative top bar -->
                        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-purple-500 via-pink-500 to-purple-500 rounded-t-2xl"></div>
                        
                        <div class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-2 animate-pulse">
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
                            <div class="flex items-center justify-center text-purple-600 mb-2 hover:text-purple-700 transition">
                                <svg class="w-5 h-5 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ date('H:i', strtotime($event->event_time)) }} WIB</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-start text-gray-600 text-sm bg-gray-50 p-3 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-left">{{ $event->location }}</span>
                        </div>
                        
                        @if($event->registration_link)
                        <div class="mt-6">
                            <a href="{{ $event->registration_link }}" target="_blank" 
                               class="block w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition-all hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 duration-300">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Daftar Sekarang
                                </div>
                            </a>
                        </div>
                        @else
                        <!-- Payment Info with Enhanced Design -->
                        @if($event->is_paid)
                        <div class="mt-4 p-5 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl shadow-inner">
                            <div class="flex items-center justify-center gap-2 text-blue-900 font-bold mb-3">
                                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg">Biaya Pendaftaran</span>
                            </div>
                            <div class="text-3xl font-black text-blue-900 mb-3 text-center bg-white py-3 rounded-lg shadow">
                                Rp {{ number_format($event->registration_fee, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-blue-800 space-y-2 bg-white/70 p-3 rounded-lg">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <strong>Bank:</strong> {{ $event->bank_name }}
                                </p>
                                <p class="flex items-center gap-2 font-mono bg-gray-100 px-2 py-1 rounded">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"></path>
                                    </svg>
                                    <strong>No. Rek:</strong> {{ $event->bank_account }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <strong>A/N:</strong> {{ $event->bank_account_name }}
                                </p>
                                @if($event->payment_contact)
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    <strong>Konfirmasi:</strong> {{ $event->payment_contact }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl shadow-md">
                            <div class="flex items-center justify-center gap-2 text-green-700 font-bold">
                                <span class="text-3xl animate-bounce">🆓</span>
                                <span class="text-lg">Event ini GRATIS</span>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Event RSVP Buttons -->
                        @auth
                            @php
                                $registration = $event->registrations()->where('user_id', Auth::id())->first();
                                $isPast = $event->event_date < now();
                            @endphp
                            
                            @if($registration && $registration->status !== 'cancelled')
                                <div class="mt-6 space-y-3">
                                    <div class="bg-green-50 border-2 border-green-500 text-green-700 px-4 py-3 rounded-xl font-semibold text-center">
                                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Anda Sudah Terdaftar
                                    </div>
                                    
                                    <!-- Download Certificate Button -->
                                    @if($registration->canDownloadCertificate())
                                        <a href="{{ route('member.events.certificate', $event) }}" 
                                           class="block w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-3 rounded-xl font-semibold transition-all text-center">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Download Sertifikat
                                        </a>
                                    @elseif($event->has_certificate && $isPast)
                                        @if($event->is_paid && $registration->payment_status !== 'verified')
                                            <div class="bg-yellow-50 border border-yellow-300 p-3 rounded-xl text-center">
                                                <span class="text-yellow-700 text-sm">⚠️ Sertifikat tersedia setelah pembayaran diverifikasi</span>
                                            </div>
                                        @endif
                                    @elseif($event->has_certificate && !$isPast)
                                        <div class="bg-blue-50 border border-blue-300 p-3 rounded-xl text-center">
                                            <span class="text-blue-700 text-sm">🎓 Sertifikat tersedia setelah event selesai</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Payment Upload for Paid Events -->
                                    @if($event->is_paid)
                                        @if($registration->payment_status === 'verified')
                                            <div class="bg-emerald-50 border border-emerald-300 p-3 rounded-xl text-center">
                                                <span class="text-emerald-700 font-semibold">✓ Pembayaran Terverifikasi</span>
                                            </div>
                                        @elseif($registration->payment_status === 'rejected')
                                            <div class="bg-red-50 border border-red-300 p-3 rounded-xl text-center">
                                                <span class="text-red-700 font-semibold">✗ Pembayaran Ditolak</span>
                                                @if($registration->payment_notes)
                                                <p class="text-xs text-red-600 mt-1">{{ $registration->payment_notes }}</p>
                                                @endif
                                            </div>
                                            <!-- Allow re-upload -->
                                            <form action="{{ route('member.events.upload-payment', $event) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <label class="block text-xs text-gray-600 mb-2">Upload ulang bukti pembayaran:</label>
                                                <input type="file" name="payment_proof" accept="image/*,.pdf" required
                                                       class="w-full text-xs border rounded-lg p-2 mb-2">
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-semibold">
                                                    Upload Bukti Bayar
                                                </button>
                                            </form>
                                        @elseif($registration->payment_proof)
                                            <div class="bg-yellow-50 border border-yellow-300 p-3 rounded-xl text-center">
                                                <span class="text-yellow-700 font-semibold">⏳ Menunggu Verifikasi</span>
                                                <a href="{{ asset('storage/' . $registration->payment_proof) }}" target="_blank" 
                                                   class="block text-xs text-blue-600 hover:underline mt-1">Lihat Bukti</a>
                                            </div>
                                        @else
                                            <form action="{{ route('member.events.upload-payment', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                                @csrf
                                                <label class="block text-xs text-gray-600 font-semibold">Upload Bukti Pembayaran:</label>
                                                <input type="file" name="payment_proof" accept="image/*,.pdf" required
                                                       class="w-full text-xs border rounded-lg p-2">
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-semibold">
                                                    Upload Bukti Bayar
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                    
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
                                    <form action="{{ route('member.events.register', $event) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        @if($event->is_paid)
                                        <div class="mb-3">
                                            <label class="block text-xs text-gray-600 font-semibold mb-1">Upload Bukti Pembayaran:</label>
                                            <input type="file" name="payment_proof" accept="image/*,.pdf"
                                                   class="w-full text-xs border rounded-lg p-2">
                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (max 2MB)</p>
                                        </div>
                                        @endif
                                        
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
                                    @if($event->has_certificate)
                                    <div class="mt-3 bg-purple-50 border border-purple-200 p-2 rounded-lg text-center">
                                        <span class="text-purple-700 text-xs font-semibold">
                                            🎓 Event ini menyediakan sertifikat
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="mt-6">
                                <a href="{{ route('member.login') }}" 
                                   class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold transition-all hover:shadow-lg transform hover:scale-105 text-center">
                                    Login untuk Daftar
                                </a>
                                @if($event->has_certificate)
                                <div class="mt-3 bg-purple-50 border border-purple-200 p-2 rounded-lg text-center">
                                    <span class="text-purple-700 text-xs font-semibold">
                                        🎓 Event ini menyediakan sertifikat
                                    </span>
                                </div>
                                @endif
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
            <!-- Description with Enhanced Design -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-8 border-t-4 border-purple-500 transform hover:shadow-2xl transition-all duration-300">
                <h2 class="text-3xl font-bold mb-6 text-gray-900 flex items-center">
                    <span class="text-4xl mr-3 animate-bounce">📋</span>
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Tentang Kegiatan</span>
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">{{ $event->description }}</p>
                </div>
                
                <!-- Additional Event Details in Cards -->
                @if($event->event_time || $event->location || $event->category)
                <div class="mt-8 grid md:grid-cols-3 gap-4">
                    @if($event->event_time)
                    <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <div class="bg-purple-500 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 font-semibold">Waktu</div>
                            <div class="text-sm font-bold text-gray-900">{{ date('H:i', strtotime($event->event_time)) }} WIB</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($event->location)
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="bg-blue-500 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 font-semibold">Lokasi</div>
                            <div class="text-sm font-bold text-gray-900">{{ Str::limit($event->location, 20) }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($event->category)
                    <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-xl border border-pink-200">
                        <div class="bg-pink-500 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 font-semibold">Kategori</div>
                            <div class="text-sm font-bold text-gray-900">{{ $event->category->name }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
            <!-- Related Events with Enhanced Design -->
            @if($relatedEvents->count() > 0)
            <div class="mt-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                        <span class="text-4xl mr-3">🎯</span>
                        Kegiatan Mendatang Lainnya
                    </h2>
                    <a href="{{ route('events.index') }}" 
                       class="hidden md:flex items-center text-purple-600 hover:text-purple-700 font-semibold group">
                        Lihat Semua
                        <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedEvents as $related)
                    <a href="{{ route('events.show', $related->slug) }}" class="group">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 h-full">
                            @if($related->image)
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <!-- Overlay gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            @else
                            <div class="h-48 bg-gradient-to-br from-purple-500 via-pink-500 to-purple-700 relative">
                                <div class="absolute inset-0 opacity-20">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full blur-2xl"></div>
                                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-300 rounded-full blur-2xl"></div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-3">
                                    @if($related->category)
                                    <span class="inline-flex items-center bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                        {{ $related->category->name }}
                                    </span>
                                    @endif
                                    
                                    @if(!$related->is_paid)
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">FREE</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center text-sm text-purple-600 font-semibold mb-2 bg-purple-50 px-2 py-1 rounded">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $related->event_date->format('d M Y') }}
                                    @if($related->event_time)
                                        • {{ date('H:i', strtotime($related->event_time)) }}
                                    @endif
                                </div>
                                
                                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-purple-600 transition leading-snug">
                                    {{ $related->title }}
                                </h3>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <p class="text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ Str::limit($related->location, 25) }}
                                    </p>
                                    <span class="text-purple-600 font-semibold group-hover:translate-x-1 transition-transform inline-block">→</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="text-center mt-8">
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-4 rounded-xl font-bold transition-all hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 duration-300">
                        Lihat Semua Kegiatan
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Add custom animations -->
<style>
@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom hover effects */
.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

/* Enhance card shadows on hover */
.shadow-lg {
    transition: box-shadow 0.3s ease-in-out;
}

.hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>

@endsection
