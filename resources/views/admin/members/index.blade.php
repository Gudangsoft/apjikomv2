@extends('layouts.admin')

@section('page-title', 'Kelola Members')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Manajemen Keanggotaan</h3>
            <p class="text-gray-600 mt-1">Kelola member aktif dan pendaftaran baru dalam satu halaman</p>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <!-- Pending Registrations -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer" onclick="switchTab('registrations')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-yellow-700 uppercase tracking-wide">Pending</p>
                    <p class="text-3xl font-bold text-yellow-900 mt-1">{{ $stats['pending_registrations'] }}</p>
                    <p class="text-xs text-yellow-600 mt-1">Menunggu approval</p>
                </div>
                <div class="bg-yellow-200 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Members -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer" onclick="switchTab('members')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-purple-700 uppercase tracking-wide">Member Aktif</p>
                    <p class="text-3xl font-bold text-purple-900 mt-1">{{ $members->total() }}</p>
                    <p class="text-xs text-purple-600 mt-1">Total anggota</p>
                </div>
                <div class="bg-purple-200 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Requests -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer" onclick="window.location.href='{{ route('admin.members.index', ['tab' => 'members', 'card_requested' => 1]) }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Request Kartu</p>
                    <p class="text-3xl font-bold text-blue-900 mt-1">{{ $stats['card_requests'] }}</p>
                    <p class="text-xs text-blue-600 mt-1">Permintaan baru</p>
                </div>
                <div class="bg-blue-200 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card Update Requests -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer" onclick="window.location.href='{{ route('admin.members.index', ['tab' => 'members', 'card_update_requested' => 1]) }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-green-700 uppercase tracking-wide">Update Kartu</p>
                    <p class="text-3xl font-bold text-green-900 mt-1">{{ $stats['card_update_requests'] }}</p>
                    <p class="text-xs text-green-600 mt-1">Permintaan update</p>
                </div>
                <div class="bg-green-200 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Tabs Navigation -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px" role="tablist">
            <button 
                onclick="switchTab('registrations')" 
                id="tab-registrations"
                class="tab-button {{ $tab === 'registrations' ? 'tab-active' : 'tab-inactive' }} flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 transition-colors"
                role="tab"
                aria-selected="{{ $tab === 'registrations' ? 'true' : 'false' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Pendaftaran Baru
                @if($stats['pending_registrations'] > 0)
                <span class="ml-2 px-2.5 py-0.5 text-xs font-bold rounded-full bg-red-100 text-red-700 animate-pulse">
                    {{ $stats['pending_registrations'] }} baru
                </span>
                @else
                <span class="ml-2 px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                    {{ $registrations->total() }}
                </span>
                @endif
            </button>

            <button 
                onclick="switchTab('members')" 
                id="tab-members"
                class="tab-button {{ $tab === 'members' ? 'tab-active' : 'tab-inactive' }} flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 transition-colors"
                role="tab"
                aria-selected="{{ $tab === 'members' ? 'true' : 'false' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Member Aktif
                <span class="ml-2 px-2.5 py-0.5 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                    {{ $members->total() }}
                </span>
            </button>
        </nav>
    </div>
</div>

<!-- Tab Content: Members -->
<div id="content-members" class="{{ $tab === 'members' ? 'block' : 'hidden' }}">
    @include('admin.members.partials.members-tab')
</div>

<!-- Tab Content: Registrations -->
<div id="content-registrations" class="{{ $tab === 'registrations' ? 'block' : 'hidden' }}">
    @include('admin.members.partials.registrations-tab')
</div>

@push('scripts')
<style>
.tab-active {
    color: #7c3aed;
    border-color: #7c3aed;
    background-color: #faf5ff;
}
.tab-inactive {
    color: #6b7280;
    border-color: transparent;
}
.tab-inactive:hover {
    color: #374151;
    border-color: #e5e7eb;
}
</style>

<script>
function switchTab(tab) {
    // Update URL with tab parameter
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    url.searchParams.delete('page'); // Reset pagination
    window.location = url;
}
</script>
@endpush
@endsection
