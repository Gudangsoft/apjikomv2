@extends('layouts.admin')

@section('page-title', 'Tambah Kerjasama')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Kerjasama</h1>
        <p class="text-gray-600 mt-1">Tambahkan mitra kerjasama (MoU/MoA) baru</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form action="{{ route('admin.cooperations.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.cooperations._form')
        </form>
    </div>
</div>
@endsection
