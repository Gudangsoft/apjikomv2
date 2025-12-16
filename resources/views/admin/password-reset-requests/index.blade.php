@extends('layouts.admin')

@section('page-title', 'Permintaan Reset Password')

@section('content')
<div class="max-w-7xl">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Permintaan Reset Password</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola permintaan reset password dari member</p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-yellow-600 uppercase">Pending</p>
                        <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $requests->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-green-600 uppercase">Disetujui</p>
                        <p class="text-2xl font-bold text-green-700 mt-1">{{ $requests->where('status', 'approved')->count() }}</p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-red-600 uppercase">Ditolak</p>
                        <p class="text-2xl font-bold text-red-700 mt-1">{{ $requests->where('status', 'rejected')->count() }}</p>
                    </div>
                    <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="flex gap-3">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-[#00629B] hover:bg-[#004b75] text-white rounded-lg transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.password-reset-requests.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                Reset
            </a>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
        <div class="flex">
            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
        <div class="flex">
            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Requests List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @forelse($requests as $request)
        <div class="border-b border-gray-200 p-6 hover:bg-gray-50 transition-colors">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex-shrink-0">
                            @if($request->user->photo)
                            <img src="{{ asset('storage/' . $request->user->photo) }}" 
                                 alt="{{ $request->user->name }}" 
                                 class="h-14 w-14 rounded-full object-cover border-2 border-gray-200">
                            @else
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-xl border-2 border-orange-200">
                                {{ strtoupper(substr($request->user->name, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $request->user->name }}</h3>
                                @if($request->user->member_number)
                                <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 rounded">
                                    {{ $request->user->member_number }}
                                </span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $request->user->email }}
                                </p>
                                @if($request->user->phone)
                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $request->user->phone }}
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        @if($request->status === 'pending')
                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pending
                            </span>
                        @elseif($request->status === 'approved')
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Disetujui
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Ditolak
                            </span>
                        @endif
                    </div>
                    
                    <div class="ml-17">
                        <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-4 mb-3">
                            <p class="text-xs font-semibold text-blue-700 mb-2 uppercase flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Alasan Permintaan
                            </p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $request->reason }}</p>
                        </div>
                        
                        <div class="flex items-center gap-4 text-xs text-gray-500 flex-wrap">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Dibuat: {{ $request->created_at->format('d M Y H:i') }}
                            </span>
                            
                            @if($request->approved_at)
                            <span class="flex items-center gap-1 {{ $request->status === 'approved' ? 'text-green-600' : 'text-red-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Diproses: {{ $request->approved_at->format('d M Y H:i') }}
                                @if($request->approvedBy)
                                    <span class="font-medium">oleh {{ $request->approvedBy->name }}</span>
                                @endif
                            </span>
                            @endif
                            
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $request->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($request->status === 'pending')
                <div class="flex flex-col gap-2 ml-4 flex-shrink-0">
                    <form action="{{ route('admin.password-reset-requests.approve', $request->id) }}" method="POST" 
                        onsubmit="return confirm('⚠️ KONFIRMASI RESET PASSWORD\n\nApakah Anda yakin ingin mereset password untuk:\n\nNama: {{ $request->user->name }}\nEmail: {{ $request->user->email }}\n\nPassword akan direset ke: @apjikom.oke\n\nMember akan menerima notifikasi dengan password baru.')">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-semibold shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Setujui & Reset Password
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.password-reset-requests.reject', $request->id) }}" method="POST" 
                        onsubmit="return confirm('Tolak permintaan reset password dari {{ $request->user->name }}?\n\nMember akan menerima notifikasi bahwa permintaan ditolak.')">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-semibold shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Permintaan
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Tidak ada permintaan reset password</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
    <div class="mt-6">
        {{ $requests->links() }}
    </div>
    @endif

    <!-- Info Note -->
    <div class="mt-6 space-y-4">
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Password Default:</strong> Saat menyetujui permintaan reset, password akan direset ke: <code class="px-2 py-0.5 bg-blue-100 rounded font-mono">@apjikom.oke</code>. 
                        Member akan menerima notifikasi dengan password baru dan saran untuk segera mengubahnya.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        <strong>Peringatan Keamanan:</strong> Pastikan untuk memverifikasi identitas member sebelum menyetujui permintaan reset password. 
                        Jika ada kecurigaan atau permintaan terlihat mencurigakan, hubungi member langsung untuk konfirmasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
