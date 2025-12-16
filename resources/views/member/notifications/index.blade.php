@extends('layouts.member')

@section('title', 'Notifikasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifikasi</h1>
                <p class="text-gray-600 mt-1">Lihat semua notifikasi dan pembaruan Anda</p>
            </div>
            
            @if($notifications->where('read_at', null)->count() > 0)
                <form action="{{ route('member.notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="bg-white rounded-xl shadow-sm border {{ $notification->isUnread() ? 'border-blue-200 bg-blue-50/30' : 'border-gray-200' }} hover:shadow-md transition-all duration-200">
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                @php
                                    $colorClasses = [
                                        'blue' => 'bg-blue-100 text-blue-600',
                                        'green' => 'bg-green-100 text-green-600',
                                        'yellow' => 'bg-yellow-100 text-yellow-600',
                                        'red' => 'bg-red-100 text-red-600',
                                        'purple' => 'bg-purple-100 text-purple-600',
                                    ];
                                    $colorClass = $colorClasses[$notification->color] ?? $colorClasses['blue'];
                                @endphp
                                <div class="w-12 h-12 rounded-xl {{ $colorClass }} flex items-center justify-center">
                                    @if($notification->icon == 'check-circle')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($notification->icon == 'refresh')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    @elseif($notification->icon == 'exclamation')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($notification->icon == 'calendar')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @elseif($notification->icon == 'book')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <h3 class="text-base font-semibold text-gray-900">
                                        {{ $notification->title }}
                                        @if($notification->isUnread())
                                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full ml-2"></span>
                                        @endif
                                    </h3>
                                    <span class="text-xs text-gray-500 whitespace-nowrap">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ $notification->message }}
                                </p>

                                <!-- Actions -->
                                <div class="flex items-center gap-2">
                                    @if($notification->action_url)
                                        <form action="{{ route('member.notifications.read', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-1.5 bg-{{ $notification->color }}-600 hover:bg-{{ $notification->color }}-700 text-white text-xs font-medium rounded-lg transition">
                                                {{ $notification->action_text }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($notification->isUnread())
                                        <form action="{{ route('member.notifications.read', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-gray-600 hover:text-gray-900 text-xs font-medium transition">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('member.notifications.destroy', $notification->id) }}" method="POST" class="inline ml-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" onclick="return confirm('Hapus notifikasi ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Notifikasi</h3>
                    <p class="text-gray-600">Anda belum memiliki notifikasi saat ini</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
