@extends('layouts.member')

@section('title', 'Detail Penugasan')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('member.dashboard') }}" class="hover:text-purple-600 transition">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('member.assignments.index') }}" class="hover:text-purple-600 transition">Penugasan Saya</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">Detail Penugasan</span>
        </nav>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $assignment->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Diberikan oleh <span class="font-medium text-gray-700">{{ $assignment->assignedBy->name }}</span>
                        · {{ $assignment->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                @php
                    $statusMap = [
                        'pending'     => ['label' => 'Pending',    'class' => 'bg-yellow-100 text-yellow-800'],
                        'in_progress' => ['label' => 'Dikerjakan', 'class' => 'bg-blue-100 text-blue-800'],
                        'completed'   => ['label' => 'Selesai',    'class' => 'bg-green-100 text-green-800'],
                        'cancelled'   => ['label' => 'Dibatalkan', 'class' => 'bg-gray-100 text-gray-800'],
                    ];
                    $s = $statusMap[$assignment->status] ?? ['label' => $assignment->status, 'class' => 'bg-gray-100 text-gray-800'];
                @endphp
                <span class="flex-shrink-0 px-3 py-1.5 text-sm font-semibold rounded-full {{ $s['class'] }}">
                    {{ $s['label'] }}
                </span>
            </div>

            <!-- Detail -->
            <div class="p-6 space-y-6">
                <!-- Deskripsi -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Deskripsi</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $assignment->description ?: '—' }}</div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($assignment->due_date)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Tenggat Waktu</p>
                        <div class="flex items-center gap-2 text-gray-800 font-medium">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $assignment->due_date->format('d M Y') }}
                            @if($assignment->due_date->isPast() && $assignment->status !== 'completed')
                                <span class="text-xs text-red-600 font-semibold">(Terlambat)</span>
                            @elseif($assignment->due_date->isToday())
                                <span class="text-xs text-orange-600 font-semibold">(Hari Ini)</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Ditugaskan Oleh</p>
                        <div class="flex items-center gap-2 text-gray-800 font-medium">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $assignment->assignedBy->name }}
                        </div>
                    </div>
                </div>

                <!-- File & Link -->
                @if($assignment->file_path || $assignment->google_drive_link)
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Dokumen & Referensi</h2>
                    <div class="flex flex-wrap gap-3">
                        @if($assignment->file_path)
                        <a href="{{ route('member.assignments.download', $assignment) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Surat Tugas
                        </a>
                        @endif
                        @if($assignment->google_drive_link)
                        <a href="{{ $assignment->google_drive_link }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                            </svg>
                            Buka Google Drive
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Update Status -->
                @if($assignment->status !== 'completed' && $assignment->status !== 'cancelled')
                <div class="border-t pt-6">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Perbarui Status</h2>
                    <form action="{{ route('member.assignments.update-status', $assignment) }}" method="POST" class="flex flex-wrap gap-3">
                        @csrf
                        @method('PATCH')
                        @if($assignment->status === 'pending')
                        <button type="submit" name="status" value="in_progress"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mulai Kerjakan
                        </button>
                        @endif
                        @if($assignment->status === 'in_progress')
                        <button type="submit" name="status" value="completed"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tandai Selesai
                        </button>
                        @endif
                    </form>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('member.assignments.index') }}" class="text-sm text-gray-500 hover:text-purple-600 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Penugasan
            </a>
        </div>
    </div>
</div>
@endsection
