@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.assignments.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Buat Penugasan Baru</h1>
            <p class="text-gray-600 mt-2">Tugaskan file/link Google Drive kepada editor jurnal</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.assignments.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-lg shadow-sm border p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Penugasan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Contoh: Review Artikel Jurnal Volume 1 No. 2">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                              placeholder="Jelaskan detail penugasan...">{{ old('description') }}</textarea>
                </div>

                <!-- Assigned To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tugaskan Kepada <span class="text-red-500">*</span></label>
                    <select name="assigned_to_user_id" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">-- Pilih Editor --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to_user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tenggat Waktu</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                    <input type="file" name="file"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 10MB</p>
                </div>

                <!-- Google Drive Link -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Drive</label>
                    <input type="url" name="google_drive_link" value="{{ old('google_drive_link') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           placeholder="https://drive.google.com/...">
                    <p class="text-xs text-gray-500 mt-1">Alternatif untuk file besar</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.assignments.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Buat Penugasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
