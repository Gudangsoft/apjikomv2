@extends('layouts.admin')

@section('page-title', 'Edit Kerjasama')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Kerjasama</h1>
        <p class="text-gray-600 mt-1">{{ $cooperation->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form action="{{ route('admin.cooperations.update', $cooperation) }}" method="POST" enctype="multipart/form-data">
            @include('admin.cooperations._form')
        </form>
    </div>
</div>
@endsection
