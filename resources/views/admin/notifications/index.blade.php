@extends('layouts.admin')

@section('page-title', 'Notifikasi')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Semua Notifikasi</h2>
                <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Tandai Semua Dibaca
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="space-y-3">
                @forelse($notifications as $notification)
                    <div class="border rounded-lg p-4 {{ is_null($notification->read_at) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-semibold text-gray-900">{{ $notification->title }}</span>
                                    @if(is_null($notification->read_at))
                                        <span class="px-2 py-1 text-xs font-semibold bg-blue-500 text-white rounded-full">Baru</span>
                                    @endif
                                </div>
                                <p class="text-gray-700 text-sm mb-2">{{ $notification->message }}</p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span>User: {{ $notification->user->name }}</span>
                                    <span>•</span>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->read_at)
                                        <span>•</span>
                                        <span>Dibaca: {{ $notification->read_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada notifikasi</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
