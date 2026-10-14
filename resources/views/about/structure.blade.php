@extends('layouts.main')

@section('title', 'Struktur Organisasi')

@section('content')

{{-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ --}}
<div class="relative bg-gradient-to-br from-purple-900 via-purple-700 to-indigo-700 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:28px 28px;"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <span class="inline-block bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-widest mb-6">Profile</span>
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ setting('about_structure_title', 'Struktur Organisasi') }}</h1>
            <p class="text-base sm:text-xl text-purple-200 max-w-2xl mx-auto">Kepengurusan {{ site_name() }} Periode 2025–2030</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     STRUKTUR ORGANISASI
════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">

            {{-- ── Dewan Eksekutif ── --}}
            @if($executives->count() > 0)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Dewan Eksekutif</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-{{ min($executives->count(), 3) }} gap-5">
                    @foreach($executives as $person)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                        {{-- photo area --}}
                        <div class="relative bg-gradient-to-br from-amber-500 to-orange-600 pt-8 pb-4 flex flex-col items-center">
                            <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:16px 16px;"></div>
                            @if($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                     class="relative z-10 w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="relative z-10 w-24 h-24 rounded-full border-4 border-white shadow-lg bg-white/20 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ mb_substr($person->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        {{-- info --}}
                        <div class="flex-1 p-5 flex flex-col text-center">
                            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wide mb-1">{{ $person->position }}</p>
                            <h4 class="text-sm md:text-base font-bold text-gray-900 leading-snug mb-2">{{ $person->name }}</h4>
                            @if($person->description)
                                <p class="text-xs text-gray-500 leading-relaxed mt-auto">{{ $person->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Leadership ── --}}
            @if($leadership->count() > 0)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Pengurus Inti</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-{{ min($leadership->count(), 3) }} gap-5">
                    @foreach($leadership as $i => $person)
                    @php
                        $isFirst = $i === 0;
                        $featured = $person->position && (stripos($person->position, 'Ketua Umum') !== false);
                    @endphp
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
                        {{-- photo area --}}
                        <div class="relative bg-gradient-to-br from-purple-600 to-indigo-700 pt-8 pb-4 flex flex-col items-center">
                            <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:16px 16px;"></div>
                            @if($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                     class="relative z-10 w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="relative z-10 w-24 h-24 rounded-full border-4 border-white shadow-lg bg-white/20 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ mb_substr($person->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        {{-- info --}}
                        <div class="flex-1 p-5 flex flex-col text-center">
                            <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-1">{{ $person->position }}</p>
                            <h4 class="text-sm md:text-base font-bold text-gray-900 leading-snug mb-2">{{ $person->name }}</h4>
                            @if($person->description)
                                <p class="text-xs text-gray-500 leading-relaxed mt-auto">{{ $person->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Divisions ── --}}
            @if($divisions->count() > 0)
            @php
            $divisionGroups = $divisions->groupBy('division_name');
            $palettes = [
                ['from-purple-600 to-purple-700', 'text-purple-600', 'bg-purple-50'],
                ['from-indigo-600 to-indigo-700', 'text-indigo-600', 'bg-indigo-50'],
                ['from-blue-600 to-blue-700',     'text-blue-600',   'bg-blue-50'],
                ['from-cyan-600 to-cyan-700',     'text-cyan-600',   'bg-cyan-50'],
                ['from-teal-600 to-teal-700',     'text-teal-600',   'bg-teal-50'],
                ['from-violet-600 to-violet-700', 'text-violet-600', 'bg-violet-50'],
            ];
            @endphp
            <div>
                <div class="space-y-5">
                @foreach($divisionGroups as $bidangName => $members)
                @php [$grad, $textColor, $bgColor] = $palettes[$loop->index % count($palettes)]; @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Bidang header --}}
                    <div class="flex items-center gap-3 px-6 py-3 bg-gradient-to-r {{ $grad }}">
                        <svg class="w-4 h-4 text-white/80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h4 class="text-white font-bold tracking-wide text-sm uppercase">{{ $bidangName ?: 'Bidang Lainnya' }}</h4>
                        <span class="ml-auto text-white/70 text-xs font-medium">{{ $members->count() }} anggota</span>
                    </div>
                    {{-- Member list: 2-column grid on desktop --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 divide-gray-100">
                        @foreach($members as $i => $member)
                        <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100 last:border-b-0 sm:border-b
                                    {{ $i % 2 === 0 && $members->count() > 1 ? 'sm:border-r' : '' }} hover:bg-gray-50 transition-colors">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                     class="w-11 h-11 rounded-full object-cover flex-shrink-0 border-2 border-gray-100">
                            @else
                                <div class="w-11 h-11 rounded-full {{ $bgColor }} flex items-center justify-center flex-shrink-0">
                                    <span class="{{ $textColor }} font-bold">{{ mb_substr($member->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="{{ $textColor }} text-xs font-semibold uppercase tracking-wide">{{ $member->position }}</p>
                                <p class="text-gray-800 text-sm font-medium leading-snug">{{ $member->name }}</p>
                                @if($member->institusi)
                                <p class="text-gray-400 text-xs truncate">{{ $member->institusi }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        {{-- pad to even if odd count --}}
                        @if($members->count() % 2 !== 0)
                        <div class="hidden sm:block"></div>
                        @endif
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            @else
            {{-- fallback placeholder divisions --}}
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Bidang</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
                @php
                $fallbackDivisions = [
                    ['Divisi Pengembangan', 'Bertanggung jawab atas pelatihan dan pengembangan kapasitas anggota', 'from-purple-500 to-purple-600', 'text-purple-600', 'bg-purple-50'],
                    ['Divisi Kerjasama',    'Menjalin kemitraan dengan organisasi dan institusi terkait',           'from-indigo-500 to-indigo-600', 'text-indigo-600', 'bg-indigo-50'],
                    ['Divisi Publikasi',    'Mengelola publikasi dan komunikasi organisasi',                         'from-blue-500 to-blue-600',   'text-blue-600',   'bg-blue-50'],
                    ['Divisi Akreditasi',   'Membantu jurnal dalam proses akreditasi dan peningkatan kualitas',     'from-cyan-500 to-cyan-600',   'text-cyan-600',   'bg-cyan-50'],
                ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach($fallbackDivisions as [$name, $desc, $grad, $textColor, $bgColor])
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition flex">
                        <div class="w-1.5 bg-gradient-to-b {{ $grad }} flex-shrink-0"></div>
                        <div class="flex-1 p-5 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl {{ $bgColor }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 {{ $textColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="{{ $textColor }} font-bold text-sm mb-1">{{ $name }}</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CTA
════════════════════════════════════════════ --}}
<section class="relative py-20 bg-gradient-to-br from-purple-900 via-purple-700 to-indigo-700 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:28px 28px;"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold mb-4">{{ setting('about_cta_title', 'Bergabung Bersama Kami') }}</h2>
        <p class="text-purple-200 text-base sm:text-lg mb-10 max-w-2xl mx-auto">
            {{ setting('about_cta_subtitle', 'Jadilah bagian dari komunitas pengelola jurnal terbesar di Indonesia') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('registration.create') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-purple-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                {{ setting('about_cta_button1_text', 'Daftar Sekarang') }}
            </a>
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ setting('about_cta_button2_text', 'Lihat Layanan') }}
            </a>
        </div>
    </div>
</section>

@endsection
