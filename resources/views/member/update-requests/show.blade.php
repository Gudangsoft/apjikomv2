@extends('layouts.member')

@section('title', 'Detail Request Update')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('member.dashboard') }}" class="hover:text-purple-600 transition">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('member.update-requests.index') }}" class="hover:text-purple-600 transition">Request Update</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-700 font-medium truncate max-w-xs">{{ $updateRequest->title }}</span>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b dark:border-gray-700 flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $updateRequest->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Dikirim {{ $updateRequest->created_at->format('d M Y, H:i') }}
                    · {{ $updateRequest->created_at->diffForHumans() }}
                </p>
            </div>
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                @php
                    $priorityMap = [
                        'urgent' => ['label' => 'Urgent', 'class' => 'bg-red-100 text-red-800'],
                        'high'   => ['label' => 'High',   'class' => 'bg-orange-100 text-orange-800'],
                        'medium' => ['label' => 'Medium', 'class' => 'bg-yellow-100 text-yellow-800'],
                        'low'    => ['label' => 'Low',    'class' => 'bg-gray-100 text-gray-800'],
                    ];
                    $statusMap = [
                        'pending'     => ['label' => 'Pending',      'class' => 'bg-yellow-100 text-yellow-800'],
                        'in_progress' => ['label' => 'Dalam Proses', 'class' => 'bg-blue-100 text-blue-800'],
                        'completed'   => ['label' => 'Selesai',      'class' => 'bg-green-100 text-green-800'],
                        'rejected'    => ['label' => 'Ditolak',      'class' => 'bg-red-100 text-red-800'],
                    ];
                    $p = $priorityMap[$updateRequest->priority] ?? ['label' => $updateRequest->priority, 'class' => 'bg-gray-100 text-gray-800'];
                    $s = $statusMap[$updateRequest->status]   ?? ['label' => $updateRequest->status,   'class' => 'bg-gray-100 text-gray-800'];
                @endphp
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $p['class'] }}">{{ $p['label'] }}</span>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <!-- Deskripsi -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Deskripsi Request</h2>
                <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    {{ $updateRequest->description }}
                </div>
            </div>

            <!-- Catatan Admin -->
            @if($updateRequest->admin_notes)
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">Catatan dari Admin</p>
                </div>
                <p class="text-sm text-blue-700 dark:text-blue-400 leading-relaxed">{{ $updateRequest->admin_notes }}</p>
            </div>
            @endif

            <!-- Status Timeline -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">Progres Status</h2>
                @php
                    $steps = [
                        ['key' => 'pending',     'label' => 'Dikirim',     'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'in_progress', 'label' => 'Dalam Proses','icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'completed',   'label' => 'Selesai',     'icon' => 'M5 13l4 4L19 7'],
                    ];
                    $statusOrder = ['pending' => 0, 'in_progress' => 1, 'completed' => 2, 'rejected' => 2];
                    $currentOrder = $statusOrder[$updateRequest->status] ?? 0;
                @endphp
                <div class="flex items-center">
                    @foreach($steps as $i => $step)
                        @php
                            $stepOrder = $statusOrder[$step['key']] ?? $i;
                            $isDone = $currentOrder >= $stepOrder;
                            $isRejected = $updateRequest->status === 'rejected' && $i === 2;
                        @endphp
                        <div class="flex flex-col items-center {{ $i < count($steps)-1 ? 'flex-1' : '' }}">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                {{ $isRejected ? 'bg-red-100 text-red-600' : ($isDone ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400') }}">
                                @if($isRejected)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                                @endif
                            </div>
                            <p class="text-xs mt-1 font-medium
                                {{ $isRejected ? 'text-red-600' : ($isDone ? 'text-green-600' : 'text-gray-400') }}">
                                {{ $isRejected ? 'Ditolak' : $step['label'] }}
                            </p>
                        </div>
                        @if($i < count($steps)-1)
                        <div class="flex-1 h-0.5 mb-5 {{ $currentOrder > $stepOrder ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('member.update-requests.index') }}" class="text-sm text-gray-500 hover:text-purple-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Request
        </a>
    </div>
</div>
@endsection
