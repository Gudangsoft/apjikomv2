@extends('layouts.main')

@section('title', 'Berita')

@section('content')
<!-- Page Header -->
<section class="bg-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Berita APJIKOM</h1>
        <p class="text-lg text-purple-100">Informasi terkini seputar informatika dan komputer</p>
    </div>
</section>

<!-- News List -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($news as $article)
                    <article class="news-card bg-white rounded overflow-hidden">
                        @if($article->image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700"></div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <span class="bg-purple-50 text-purple-600 px-3 py-1 rounded-full font-medium mr-2">
                                    {{ $article->category->name }}
                                </span>
                                <span>{{ $article->published_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-lg font-bold mb-2 text-gray-900 line-clamp-2">
                                <a href="{{ route('news.show', $article->slug) }}" class="hover:text-purple-600">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($article->excerpt, 150) }}</p>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('news.show', $article->slug) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                    Baca Selengkapnya →
                                </a>
                                <span class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $article->views }}
                                </span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-2 text-center py-12 text-gray-500">
                        Belum ada berita tersedia.
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($news->hasPages())
                <div class="mt-8">
                    {{ $news->links() }}
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <aside class="w-full md:w-80">
                <!-- Categories -->
                <div class="bg-white rounded shadow-sm p-6 mb-6 border">
                    <h3 class="text-lg font-bold mb-4 text-gray-900">Kategori</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('news.index') }}" class="flex justify-between items-center text-sm text-gray-700 hover:text-purple-600 {{ !request('category') ? 'text-purple-600 font-medium' : '' }}">
                                <span>Semua</span>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $totalNews }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('news.index', ['category' => $cat->slug]) }}" 
                               class="flex justify-between items-center text-sm text-gray-700 hover:text-purple-600 {{ request('category') == $cat->slug ? 'text-purple-600 font-medium' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $cat->news_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Latest News -->
                <div class="bg-white rounded shadow-sm p-6 border">
                    <h3 class="text-lg font-bold mb-4 text-gray-900">Berita Terbaru</h3>
                    <ul class="space-y-4">
                        @foreach($latestNews as $latest)
                        <li class="pb-4 border-b last:border-0 last:pb-0">
                            <a href="{{ route('news.show', $latest->slug) }}" class="block hover:text-purple-600">
                                <h4 class="font-medium mb-1 text-sm">{{ Str::limit($latest->title, 60) }}</h4>
                                <p class="text-xs text-gray-500">{{ $latest->published_at->format('d M Y') }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
