@extends('layouts.main')

@section('title', 'Kerjasama')

@section('content')
<!-- Page Header -->
<section class="bg-purple-600 text-white py-8 md:py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Kerjasama</h1>
        <p class="text-sm sm:text-lg text-purple-100">Mitra kerjasama (MoU/MoA) {{ $globalSiteName }} dengan berbagai institusi</p>
    </div>
</section>

<!-- Cooperation List -->
<section class="py-10 sm:py-16 bg-gray-50">
    <div class="container mx-auto px-4">

        <!-- Search -->
        <form method="GET" action="{{ route('cooperation.index') }}" class="max-w-xl mx-auto mb-10">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama institusi atau bidang kerjasama..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-400 focus:border-transparent">
                <button type="submit" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition">
                    Cari
                </button>
                @if(request('search'))
                <a href="{{ route('cooperation.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <p class="text-sm text-gray-500 mb-6 text-center">
            Menampilkan {{ $cooperations->count() }} dari {{ $cooperations->total() }} mitra kerjasama
        </p>

        @if($cooperations->count())
        @php
            $coverGradients = [
                'from-purple-600 via-indigo-600 to-blue-600',
                'from-indigo-600 via-purple-600 to-fuchsia-600',
                'from-blue-600 via-indigo-600 to-purple-700',
                'from-violet-600 via-purple-600 to-indigo-700',
                'from-fuchsia-600 via-purple-600 to-indigo-600',
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
            @foreach($cooperations as $item)
            @php
                $coverPhoto = $item->photos->first();
                $gradient = $coverGradients[crc32($item->name) % count($coverGradients)];
            @endphp
            <a href="{{ route('cooperation.show', $item) }}"
               class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                <!-- Cover: foto galeri pertama, atau gradient placeholder -->
                <div class="relative aspect-video overflow-hidden rounded-t-2xl bg-gradient-to-br {{ $gradient }}">
                    @if($coverPhoto)
                        <img src="{{ asset('storage/' . $coverPhoto->photo) }}" alt="{{ $item->name }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/5 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 opacity-[0.07]" style="background-image:radial-gradient(circle,#fff 1.5px,transparent 1.5px);background-size:18px 18px;"></div>
                        <div class="absolute -right-4 -bottom-6 text-white/10 group-hover:text-white/15 transition-colors">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3L2 9v1h20V9L12 3zm-7 9v7H4v1h16v-1h-1v-7h-2v7h-3v-7h-2v7H9v-7H7v7H6v-7H5zm1 0h12v7H6v-7z"></path>
                            </svg>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center text-white/30 text-6xl font-black select-none drop-shadow-sm">
                            {{ mb_substr($item->name, 0, 1) }}
                        </div>
                    @endif

                    @if($item->photos_count > 0)
                    <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2 py-1 bg-black/50 backdrop-blur-sm text-white text-[11px] font-medium rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $item->photos_count }}
                    </span>
                    @endif
                </div>

                <!-- Logo: ditarik naik dengan margin negatif agar tidak terpotong oleh overflow cover -->
                <div class="px-5 -mt-7 relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-white shadow-md ring-4 ring-white border border-gray-100 flex items-center justify-center overflow-hidden">
                        @if($item->logo)
                            <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo {{ $item->name }}" class="w-full h-full object-contain p-1.5">
                        @else
                            <span class="text-purple-600 font-bold text-lg">{{ mb_substr($item->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <div class="pt-3 pb-5 px-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-900 leading-snug group-hover:text-purple-600 transition-colors line-clamp-2">
                        {{ $item->name }}
                    </h3>
                    @if($item->category)
                    <p class="text-xs text-purple-600 font-medium mt-1">{{ $item->category }}</p>
                    @endif
                    <div class="flex items-center justify-between gap-1.5 mt-auto pt-3">
                        <div class="flex items-center gap-1.5">
                            @if($item->hasMou())
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold bg-green-50 text-green-700 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                MoU
                            </span>
                            @endif
                            @if($item->hasMoa())
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold bg-blue-50 text-blue-700 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                MoA
                            </span>
                            @endif
                        </div>
                        <span class="inline-flex items-center gap-1 text-purple-600 text-xs font-semibold opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($cooperations->hasPages())
        <div class="mt-10">
            {{ $cooperations->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <p class="text-gray-500">
                @if(request('search'))
                    Tidak ada mitra kerjasama yang cocok dengan pencarian "{{ request('search') }}".
                @else
                    Belum ada data kerjasama tersedia.
                @endif
            </p>
        </div>
        @endif
    </div>
</section>
@endsection
