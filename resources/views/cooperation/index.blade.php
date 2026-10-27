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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cooperations as $item)
            @php $coverPhoto = $item->photos->first(); @endphp
            <a href="{{ route('cooperation.show', $item) }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                <!-- Cover: foto galeri pertama, atau gradient placeholder -->
                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-purple-600 to-indigo-700">
                    @if($coverPhoto)
                        <img src="{{ asset('storage/' . $coverPhoto->photo) }}" alt="{{ $item->name }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-black/0"></div>
                    @else
                        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:16px 16px;"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-white/25 text-6xl font-black select-none">
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

                    <!-- Logo: badge mengambang di bawah kiri cover -->
                    <div class="absolute -bottom-6 left-5 w-14 h-14 rounded-xl bg-white shadow-md border border-gray-100 flex items-center justify-center overflow-hidden">
                        @if($item->logo)
                            <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo {{ $item->name }}" class="w-full h-full object-contain p-1.5">
                        @else
                            <span class="text-purple-600 font-bold">{{ mb_substr($item->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <div class="pt-9 pb-5 px-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-900 leading-snug group-hover:text-purple-600 transition-colors line-clamp-2">
                        {{ $item->name }}
                    </h3>
                    @if($item->category)
                    <p class="text-xs text-purple-600 font-medium mt-1">{{ $item->category }}</p>
                    @endif
                    <div class="flex items-center gap-1.5 mt-auto pt-3">
                        @if($item->hasMou())
                        <span class="px-2 py-0.5 text-[11px] font-semibold bg-green-50 text-green-700 rounded-full">MoU</span>
                        @endif
                        @if($item->hasMoa())
                        <span class="px-2 py-0.5 text-[11px] font-semibold bg-blue-50 text-blue-700 rounded-full">MoA</span>
                        @endif
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
