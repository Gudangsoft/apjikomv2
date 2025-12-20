@extends('layouts.admin')

@section('page-title', 'Kelola Members')

@section('content')
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Manajemen Keanggotaan</h3>
    <p class="text-gray-600 mt-1">Kelola member aktif dan pendaftaran baru dalam satu halaman</p>
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
