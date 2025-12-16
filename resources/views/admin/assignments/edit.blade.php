@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Penugasan</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi penugasan editor</p>
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

        <!-- Form -->
        <form action="{{ route('admin.assignments.update', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow-sm border p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Penugasan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $assignment->title) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $assignment->description) }}</textarea>
                </div>

                <!-- Assigned To -->
                <div>
                    <label for="assigned_to_user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ditugaskan Kepada <span class="text-red-500">*</span>
                    </label>
                    <select name="assigned_to_user_id" 
                            id="assigned_to_user_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to_user_id', $assignment->assigned_to_user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tenggat Waktu
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date" 
                           value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            required>
                        <option value="pending" {{ old('status', $assignment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $assignment->status) == 'in_progress' ? 'selected' : '' }}>Dikerjakan</option>
                        <option value="completed" {{ old('status', $assignment->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status', $assignment->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Current File -->
                @if($assignment->file_path)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">File Saat Ini</div>
                                <div class="text-xs text-gray-600">{{ basename($assignment->file_path) }}</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat File
                        </a>
                    </div>
                </div>
                @endif

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload File Surat Tugas {{ $assignment->file_path ? '(Opsional - Ganti file)' : '' }}
                    </label>
                    <input type="file" 
                           name="file" 
                           id="file" 
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, ZIP</p>
                </div>

                <!-- Google Drive Link -->
                <div>
                    <label for="google_drive_link" class="block text-sm font-semibold text-gray-700 mb-2">
                        Link Google Drive (Opsional)
                    </label>
                    <input type="url" 
                           name="google_drive_link" 
                           id="google_drive_link" 
                           value="{{ old('google_drive_link', $assignment->google_drive_link) }}"
                           placeholder="https://drive.google.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    Perbarui Penugasan
                </button>
                <a href="{{ route('admin.assignments.index') }}" 
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
