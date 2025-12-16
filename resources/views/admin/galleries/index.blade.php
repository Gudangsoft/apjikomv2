@extends('layouts.admin')

@section('page-title', 'Kelola Galeri')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Galeri</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola foto, video dan dokumentasi kegiatan</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Media
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Media</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $galleries->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Foto</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $galleries->where('type', 'image')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Video</p>
                    <p class="text-2xl font-bold text-red-600">{{ $galleries->where('type', 'video')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Featured</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $galleries->where('is_featured', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Event</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $galleries->where('category', 'event')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        @if($galleries->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
            <div class="group relative bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                <!-- Featured Badge -->
                @if($gallery->is_featured)
                <div class="absolute top-2 right-2 z-10">
                    <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1 shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Featured
                    </span>
                </div>
                @endif

                <!-- Image -->
                <div class="relative h-48 overflow-hidden bg-gray-200">
                    @if($gallery->type === 'video')
                        <!-- Video Thumbnail with Play Button -->
                        <img src="{{ $gallery->youtube_thumbnail }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                        <span class="absolute bottom-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">
                            VIDEO
                        </span>
                    @else
                        <!-- Image -->
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $gallery->title }}</h3>
                    
                    @if($gallery->description)
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $gallery->description }}</p>
                    @endif

                    <div class="flex flex-wrap gap-2 mb-3">
                        @php
                            $categoryColors = [
                                'event' => 'bg-blue-100 text-blue-800',
                                'activity' => 'bg-green-100 text-green-800',
                                'member' => 'bg-purple-100 text-purple-800',
                                'other' => 'bg-gray-100 text-gray-800',
                            ];
                            $categoryLabels = [
                                'event' => 'Event',
                                'activity' => 'Kegiatan',
                                'member' => 'Member',
                                'other' => 'Lainnya',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $categoryColors[$gallery->category] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $categoryLabels[$gallery->category] ?? ucfirst($gallery->category) }}
                        </span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                            Urutan: {{ $gallery->order }}
                        </span>
                    </div>

                    @if($gallery->event)
                    <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ Str::limit($gallery->event->title, 30) }}
                    </p>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition text-center flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($galleries->hasPages())
        <div class="mt-6 pt-6 border-t border-gray-200">
            {{ $galleries->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-lg font-medium text-gray-900">Belum ada foto di galeri</p>
            <p class="text-sm text-gray-500 mt-1">Klik tombol "Tambah Foto" untuk menambahkan foto baru</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Galeri</h1>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Foto
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @forelse($galleries as $gallery)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">{{ Str::limit($gallery->title, 30) }}</h6>
                                @if($gallery->is_featured)
                                    <i class="bi bi-star-fill text-warning" title="Featured"></i>
                                @endif
                            </div>
                            @if($gallery->description)
                                <p class="card-text small text-muted">{{ Str::limit($gallery->description, 60) }}</p>
                            @endif
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-info">{{ ucfirst($gallery->category) }}</span>
                                <span class="badge bg-secondary">Urutan: {{ $gallery->order }}</span>
                            </div>
                            @if($gallery->event)
                                <p class="small text-muted mb-2">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $gallery->event->title }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-warning flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="flex-fill" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-images display-1 d-block mb-3"></i>
                        <p>Belum ada foto di galeri</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if($galleries->hasPages())
            <div class="mt-4">
                {{ $galleries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
