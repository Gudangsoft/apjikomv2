@extends('layouts.member')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Penugasan Saya</h1>
            <p class="text-gray-600 mt-2">Daftar penugasan sebagai editor jurnal</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Assignments List -->
        <div class="grid gap-6">
            @forelse($assignments as $assignment)
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $assignment->title }}</h3>
                        <p class="text-gray-600 mb-3">{{ $assignment->description }}</p>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Dari: {{ $assignment->assignedBy->name }}
                            </div>
                            @if($assignment->due_date)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tenggat: {{ $assignment->due_date->format('d M Y') }}
                            </div>
                            @endif
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $assignment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div>
                        @if($assignment->status == 'pending')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($assignment->status == 'in_progress')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Dikerjakan</span>
                        @elseif($assignment->status == 'completed')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if($assignment->file_path)
                    <a href="{{ route('member.assignments.download', $assignment) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Surat Tugas
                    </a>
                    @endif
                    @if($assignment->google_drive_link)
                    <a href="{{ $assignment->google_drive_link }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                        </svg>
                        Buka Google Drive
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada penugasan</p>
            </div>
            @endforelse
        </div>

        @if($assignments->hasPages())
        <div class="mt-6">
            {{ $assignments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
