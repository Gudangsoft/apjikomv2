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
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ setting('about_page_title', 'Tentang ' . site_name()) }}</h1>
            <p class="text-base sm:text-xl text-purple-200 max-w-2xl mx-auto">{{ setting('about_page_subtitle', $globalSiteTagline) }}</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     VISI & MISI
════════════════════════════════════════════ --}}
<section id="visi-misi" class="py-20 bg-gray-50 scroll-mt-24">
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
<section id="sejarah" class="overflow-hidden scroll-mt-24">
    <div class="grid grid-cols-1 lg:grid-cols-5 lg:min-h-[600px]">

        {{-- left: dark panel full-height --}}
        <div class="lg:col-span-2 relative flex flex-col min-h-[220px] sm:min-h-[300px]">
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
                        <p class="text-gray-700 leading-8 text-[1.02rem] md:text-[1.07rem] text-justify hyphens-auto [text-align-last:left]" lang="id">
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
