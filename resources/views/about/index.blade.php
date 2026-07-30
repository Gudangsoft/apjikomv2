@extends('layouts.main')

@section('title', 'Tentang Kami')

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
            <span class="inline-block bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-widest mb-6">Profil Organisasi</span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">{{ setting('about_page_title', 'Tentang ' . site_name()) }}</h1>
            <p class="text-lg sm:text-xl text-purple-200 max-w-2xl mx-auto">{{ setting('about_page_subtitle', $globalSiteTagline) }}</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     VISI & MISI
════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Arah Kami</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Visi &amp; Misi</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            {{-- Visi --}}
            <div class="relative bg-white rounded-2xl shadow-sm border border-purple-100 p-8 overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-600 to-indigo-500 rounded-t-2xl"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Visi</h2>
                </div>
                <p class="text-gray-600 leading-relaxed text-base">
                    {{ setting('about_vision', 'Menjadi organisasi profesional yang terpercaya dalam meningkatkan kualitas dan kredibilitas jurnal informatika dan komputer di Indonesia.') }}
                </p>
            </div>

            {{-- Misi --}}
            <div class="relative bg-white rounded-2xl shadow-sm border border-indigo-100 p-8 overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-600 to-blue-500 rounded-t-2xl"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Misi</h2>
                </div>
                <ul class="space-y-3">
                    @php
                        $missionText = setting('about_mission', "• Meningkatkan kapasitas pengelola jurnal melalui pelatihan dan pendampingan\n• Memfasilitasi kolaborasi antar pengelola jurnal komunikasi\n• Mendukung akreditasi dan peningkatan kualitas jurnal\n• Membangun jejaring dengan organisasi profesi sejenis");
                        $missions = array_filter(array_map('trim', explode("\n", $missionText)));
                    @endphp
                    @foreach($missions as $mission)
                        @if($mission)
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-600 text-sm leading-relaxed">{{ ltrim($mission, '•-* ') }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     SEJARAH — true full-bleed split
════════════════════════════════════════════ --}}
<section class="overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-5" style="min-height:600px">

        {{-- left: dark panel full-height --}}
        <div class="lg:col-span-2 relative flex flex-col">
            @if(setting('about_history_image'))
                <img src="{{ asset('storage/' . setting('about_history_image')) }}"
                     alt="Sejarah {{ site_name() }}"
                     class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-purple-900/60"></div>
            @endif
            {{-- always show overlay graphic (shows alone when no image) --}}
            <div class="relative z-10 flex flex-col items-center justify-center flex-1 p-10
                        {{ setting('about_history_image') ? '' : 'bg-gradient-to-br from-purple-900 via-indigo-800 to-purple-900' }}">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,#fff 1.5px,transparent 1.5px);background-size:20px 20px;"></div>
                {{-- rings --}}
                <div class="absolute top-8 right-8 w-40 h-40 border border-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute top-14 right-14 w-24 h-24 border border-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute bottom-8 left-8 w-32 h-32 border border-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute bottom-14 left-14 w-16 h-16 border border-white/10 rounded-full pointer-events-none"></div>
                <div class="relative z-10 text-center select-none">
                    <div class="text-white/15 font-black leading-none" style="font-size:min(6rem,12vw);letter-spacing:-2px;">APJI<br>KOM</div>
                    <div class="w-16 h-px bg-white/30 mx-auto my-5"></div>
                    <span class="text-white/50 text-xs tracking-[0.3em] uppercase">Est. {{ setting('about_founded_year', '2025') }}</span>
                </div>
            </div>
        </div>

        {{-- right: title + text + stats stacked --}}
        <div class="lg:col-span-3 flex flex-col">

            {{-- title bar --}}
            <div class="bg-gray-50 border-b border-gray-100 px-10 md:px-14 py-10">
                <span class="inline-block bg-purple-100 text-purple-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-3">Perjalanan Kami</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ setting('about_history_title', 'Sejarah ' . site_name()) }}</h2>
            </div>

            {{-- quote text --}}
            <div class="flex-1 px-10 md:px-14 py-10 bg-white relative overflow-hidden">
                <div class="text-purple-100 select-none pointer-events-none absolute top-2 left-8 leading-none" style="font-size:8rem;font-family:Georgia,serif;line-height:0.7">&ldquo;</div>
                <div class="relative z-10">
                        <p class="text-gray-700 leading-8 text-[1.02rem] md:text-[1.07rem]">
                            {{ setting('about_history') ?? (site_name() . ' didirikan sebagai wadah bagi para pengelola jurnal ilmiah untuk saling berbagi pengalaman, pengetahuan, dan best practices dalam pengelolaan jurnal ilmiah.') }}
                        </p>

                        {{-- legal badge --}}
                        @if(setting('about_legal_number'))
                        <div class="mt-8 flex items-start gap-3 p-4 bg-purple-50 border border-purple-100 rounded-xl">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-purple-700 uppercase tracking-wide mb-0.5">Legalitas Hukum</p>
                                <p class="text-sm text-gray-600">{{ setting('about_legal_number') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="text-purple-50 select-none pointer-events-none absolute bottom-4 right-8 leading-none" style="font-size:8rem;font-family:Georgia,serif;line-height:0.7">&rdquo;</div>
                </div>

                {{-- stats bar --}}
                <div class="bg-gradient-to-r from-purple-900 via-purple-800 to-indigo-800 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:20px 20px;"></div>
                    <div class="grid grid-cols-3 divide-x divide-white/20 relative z-10 py-7">
                        <div class="text-center px-4">
                            <div class="text-2xl sm:text-3xl font-bold text-white">{{ setting('about_founded_year', '2025') }}</div>
                            <div class="text-white/60 text-xs mt-1 uppercase tracking-wide">{{ setting('about_stat1_label', 'Tahun Berkiprah') }}</div>
                        </div>
                        <div class="text-center px-4">
                            <div class="text-2xl sm:text-3xl font-bold text-white">{{ App\Models\Member::where('status', 'active')->count() }}+</div>
                            <div class="text-white/60 text-xs mt-1 uppercase tracking-wide">{{ setting('about_stat2_label', 'Anggota Aktif') }}</div>
                        </div>
                        <div class="text-center px-4">
                            <div class="text-2xl sm:text-3xl font-bold text-white">{{ App\Models\Event::count() }}+</div>
                            <div class="text-white/60 text-xs mt-1 uppercase tracking-wide">{{ setting('about_stat3_label', 'Kegiatan') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

{{-- ═══════════════════════════════════════════
     STRUKTUR ORGANISASI
════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Pengurus</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">{{ setting('about_structure_title', 'Struktur Organisasi') }}</h2>
            <div class="w-16 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded-full mb-4"></div>
            <p class="text-gray-500 max-w-xl mx-auto text-sm">Kepengurusan {{ site_name() }} Periode 2025–2030</p>
        </div>

        <div class="max-w-6xl mx-auto">

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
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Divisi</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach($divisions as $index => $division)
                    @php
                        $palettes = [
                            ['from-purple-500 to-purple-600', 'text-purple-600', 'bg-purple-50', 'border-purple-100'],
                            ['from-indigo-500 to-indigo-600', 'text-indigo-600', 'bg-indigo-50', 'border-indigo-100'],
                            ['from-blue-500 to-blue-600',   'text-blue-600',   'bg-blue-50',   'border-blue-100'],
                            ['from-cyan-500 to-cyan-600',   'text-cyan-600',   'bg-cyan-50',   'border-cyan-100'],
                            ['from-teal-500 to-teal-600',   'text-teal-600',   'bg-teal-50',   'border-teal-100'],
                            ['from-violet-500 to-violet-600','text-violet-600','bg-violet-50', 'border-violet-100'],
                        ];
                        [$grad, $textColor, $bgColor, $borderColor] = $palettes[$index % count($palettes)];
                    @endphp
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 {{ $borderColor }} hover:shadow-md transition-all duration-300 flex">
                        {{-- accent bar + icon --}}
                        <div class="w-1.5 bg-gradient-to-b {{ $grad }} flex-shrink-0"></div>
                        <div class="flex-1 p-5">
                            <div class="flex items-start gap-4">
                                @if($division->photo)
                                    <img src="{{ asset('storage/' . $division->photo) }}" alt="{{ $division->name }}"
                                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-gray-100">
                                @else
                                    <div class="w-12 h-12 rounded-xl {{ $bgColor }} flex items-center justify-center flex-shrink-0">
                                        <span class="{{ $textColor }} text-lg font-bold">{{ mb_substr($division->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="{{ $textColor }} text-sm font-bold uppercase tracking-wide mb-0.5">{{ $division->division_name }}</h4>
                                    <p class="text-gray-800 text-sm font-semibold mb-1">{{ $division->position }}: <span class="font-normal text-gray-600">{{ $division->name }}</span></p>
                                    @if($division->description)
                                        <p class="text-xs text-gray-500 leading-relaxed">{{ $division->description }}</p>
                                    @endif
                                </div>
                            </div>
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
                    <h3 class="text-lg font-bold text-gray-800">Divisi</h3>
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
