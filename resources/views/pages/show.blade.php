@extends('layouts.main')

@section('title', $page->meta_title ?? $page->title)

@section('content')
<!-- Page Header -->
<div class="apjikom-purple text-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="text-purple-100 text-lg">{{ $page->excerpt }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <article class="prose prose-lg max-w-none">
                    {!! nl2br(e($page->content)) !!}
                </article>
                
                <div class="mt-8 pt-6 border-t border-gray-200 text-sm text-gray-500">
                    <p>Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Links (Optional) -->
@if(false) <!-- Enable if you want to show related pages -->
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-6">Halaman Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Add related pages here -->
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('meta')
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
@endpush
