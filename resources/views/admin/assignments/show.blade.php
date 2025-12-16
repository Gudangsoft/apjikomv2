@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Penugasan</h1>
                <p class="text-gray-600 mt-2">Informasi lengkap penugasan editor</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.assignments.edit', $assignment) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.assignments.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Assignment Details -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-8 text-white">
                <h2 class="text-2xl font-bold mb-2">{{ $assignment->title }}</h2>
                <div class="flex items-center gap-2">
                    @if($assignment->status == 'pending')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-400 text-yellow-900">Pending</span>
                    @elseif($assignment->status == 'in_progress')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-400 text-blue-900">Dikerjakan</span>
                    @elseif($assignment->status == 'completed')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-400 text-green-900">Selesai</span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-400 text-gray-900">Dibatalkan</span>
                    @endif
                    <span class="text-sm opacity-90">• Dibuat {{ $assignment->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6 space-y-6">
                <!-- Description -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $assignment->description ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <!-- Assignment Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Assigned To -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Ditugaskan Kepada</h3>
                        <div class="flex items-center gap-3 bg-blue-50 rounded-lg p-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($assignment->assignedTo->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $assignment->assignedTo->name }}</div>
                                <div class="text-sm text-gray-600">{{ $assignment->assignedTo->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Assigned By -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Ditugaskan Oleh</h3>
                        <div class="flex items-center gap-3 bg-purple-50 rounded-lg p-4">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($assignment->assignedBy->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $assignment->assignedBy->name }}</div>
                                <div class="text-sm text-gray-600">{{ $assignment->assignedBy->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Due Date -->
                @if($assignment->due_date)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Tenggat Waktu</h3>
                    <div class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ $assignment->due_date->format('d F Y') }}</span>
                        @if($assignment->due_date->isPast() && $assignment->status != 'completed')
                            <span class="ml-2 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded">Terlambat</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Files and Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">File & Link</h3>
                    <div class="flex flex-wrap gap-3">
                        @if($assignment->file_path)
                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Surat Tugas
                        </a>
                        @endif
                        @if($assignment->google_drive_link)
                        <a href="{{ $assignment->google_drive_link }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                            </svg>
                            Buka Google Drive
                        </a>
                        @endif
                        @if(!$assignment->file_path && !$assignment->google_drive_link)
                        <div class="text-gray-500 italic">Tidak ada file atau link yang dilampirkan</div>
                        @endif
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="border-t pt-4">
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Dibuat:</span> {{ $assignment->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.assignments.edit', $assignment) }}" 
               class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-center">
                Edit Penugasan
            </a>
            <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" class="flex-1" 
                  onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    Hapus Penugasan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
