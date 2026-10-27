@extends('layouts.admin')

@section('page-title', 'Edit Kerjasama')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kerjasama</h1>
            <p class="text-gray-600 mt-1">{{ $cooperation->name }}</p>
        </div>
        <a href="{{ route('admin.cooperations.photos.index', $cooperation) }}"
           class="px-4 py-2 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Kelola Galeri Foto ({{ $cooperation->photos()->count() }})
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form action="{{ route('admin.cooperations.update', $cooperation) }}" method="POST" enctype="multipart/form-data">
            @include('admin.cooperations._form')
        </form>
    </div>
</div>
@endsection
