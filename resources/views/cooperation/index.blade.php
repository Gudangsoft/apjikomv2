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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($cooperations as $item)
            <a href="{{ route('cooperation.show', $item) }}"
               class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-start gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($item->logo)
                        <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->name }}" class="w-full h-full object-contain p-1.5">
                    @else
                        <span class="text-purple-600 font-bold text-xl">{{ mb_substr($item->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-bold text-gray-900 leading-snug group-hover:text-purple-600 transition-colors line-clamp-2">
                        {{ $item->name }}
                    </h3>
                    @if($item->category)
                    <p class="text-xs text-purple-600 font-medium mt-1">{{ $item->category }}</p>
                    @endif
                    <div class="flex items-center gap-1.5 mt-3">
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
