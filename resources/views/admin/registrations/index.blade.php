@extends('layouts.admin')

@section('title', 'Kelola Pendaftaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Pendaftaran Anggota</h1>
        <p class="text-gray-600">Kelola dan review pendaftaran anggota APJIKOM</p>
    </div>

    <!-- Tutorial Note -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-blue-800 mb-1">📚 Tutorial Penggunaan</h3>
                <p class="text-sm text-blue-700 mb-2">
                    Halaman ini untuk <strong>review pendaftaran baru</strong> yang masuk dari publik. 
                    Klik <strong>👁️ Lihat</strong> untuk review data → <strong>✅ Approve</strong> (otomatis jadi Member) atau <strong>❌ Reject</strong>.
                </p>
                <a href="{{ asset('TUTORIAL_ADMIN_MEMBER_REGISTRATION.md') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium underline">
                    📖 Baca Tutorial Lengkap →
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Pending</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Approved</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Rejected</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Individu</div>
            <div class="text-2xl font-bold text-purple-600">{{ $stats['individu'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border">
            <div class="text-sm text-gray-600 mb-1">Prodi</div>
            <div class="text-2xl font-bold text-purple-600">{{ $stats['prodi'] }}</div>
        </div>
    </div>

    <!-- Advanced Search & Filters -->
    <div class="bg-white rounded-lg shadow mb-6 border" id="searchFilterCard">
        <div class="p-4 border-b bg-gray-50 flex items-center justify-between cursor-pointer" onclick="toggleSearchFilter()">
            <h4 class="text-lg font-semibold text-gray-900">🔍 Pencarian & Filter</h4>
            <svg id="filterToggleIcon" class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div class="p-4" id="searchFilterContent">
            <form id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Nama, email, phone, institusi..."
                               class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Member Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Member</label>
                        <select id="has_member" name="has_member" class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                            <option value="">Semua</option>
                            <option value="yes" {{ request('has_member') == 'yes' ? 'selected' : '' }}>Sudah Jadi Member</option>
                            <option value="no" {{ request('has_member') == 'no' ? 'selected' : '' }}>Belum Jadi Member</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                            class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
                            class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort" name="sort" class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                        <select id="per_page" name="per_page" class="filter-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-600" id="recordInfo">
                        Menampilkan {{ $registrations->firstItem() ?? 0 }} - {{ $registrations->lastItem() ?? 0 }} dari {{ $registrations->total() }} pendaftaran
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" id="resetBtn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                            Reset
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#00629B] text-white rounded-md hover:bg-[#003A5D] flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Cari</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-lg shadow border overflow-hidden" id="tableContainer">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member Anggota</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            #{{ $registration->id }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($registration->type == 'individu')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    Individu
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    Prodi
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3" style="min-width: 250px; max-width: 350px;">
                            @if($registration->type == 'prodi' && $registration->institution)
                                <div class="text-sm font-medium text-gray-900">{{ $registration->institution }}</div>
                                <div class="text-xs text-gray-500">PIC: {{ $registration->full_name }}</div>
                            @else
                                <div class="text-sm font-medium text-gray-900">{{ $registration->full_name }}</div>
                                @if($registration->institution)
                                    <div class="text-xs text-gray-500">{{ $registration->institution }}</div>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $registration->email }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            {{ $registration->phone }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($registration->status == 'pending')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($registration->status == 'approved')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $user = \App\Models\User::where('email', $registration->email)->first();
                                $member = $user ? \App\Models\Member::where('user_id', $user->id)->first() : null;
                            @endphp
                            @if($member)
                                <a href="{{ route('admin.members.show', $member->id) }}" 
                                   class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 hover:bg-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $member->member_number }}
                                </a>
                            @elseif($registration->status === 'approved')
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Belum
                                </span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $registration->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.registrations.show', $registration->id) }}" 
                               class="text-purple-600 hover:text-purple-900 font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada data pendaftaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t" id="paginationContainer">
            @if($registrations->hasPages())
                {{ $registrations->links() }}
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Toggle Search Filter
function toggleSearchFilter() {
    const content = document.getElementById('searchFilterContent');
    const icon = document.getElementById('filterToggleIcon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'none';
        icon.style.transform = 'rotate(-90deg)';
    }
}

// jQuery AJAX Filter
$(document).ready(function() {
    let searchTimeout;
    
    // Bind pagination links on initial load
    bindPaginationLinks();
    
    // Auto-search on input (with debounce)
    $('#search').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadRegistrations();
        }, 500);
    });
    
    // Auto-filter on change
    $('.filter-input').not('#search').on('change', function() {
        loadRegistrations();
    });
    
    // Form submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadRegistrations();
    });
    
    // Reset button
    $('#resetBtn').on('click', function() {
        $('#filterForm')[0].reset();
        loadRegistrations();
    });
    
    // Function to load registrations
    function loadRegistrations(page = 1) {
        const formData = {
            search: $('#search').val(),
            status: $('#status').val(),
            has_member: $('#has_member').val(),
            date_from: $('#date_from').val(),
            date_to: $('#date_to').val(),
            sort: $('#sort').val(),
            per_page: $('#per_page').val(),
            page: page
        };
        
        // Show loading
        $('#tableBody').html('<tr><td colspan="9" class="px-4 py-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#00629B]"></div><div class="mt-2 text-gray-600">Memuat data...</div></td></tr>');
        
        $.ajax({
            url: '{{ route("admin.registrations.index") }}',
            type: 'GET',
            data: formData,
            dataType: 'html',
            success: function(response) {
                const $response = $(response);
                const tableBody = $response.find('#tableBody').html();
                const pagination = $response.find('#paginationContainer').html();
                const recordInfo = $response.find('#recordInfo').html();
                
                $('#tableBody').html(tableBody);
                $('#paginationContainer').html(pagination);
                $('#recordInfo').html(recordInfo);
                
                // Update pagination links to use AJAX
                bindPaginationLinks();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#tableBody').html('<tr><td colspan="9" class="px-4 py-8 text-center text-red-600">Terjadi kesalahan saat memuat data. Silakan coba lagi.</td></tr>');
            }
        });
    }
    
    // Bind pagination links
    function bindPaginationLinks() {
        $('#paginationContainer a').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const urlParams = new URLSearchParams(url.split('?')[1]);
                const page = urlParams.get('page') || 1;
                loadRegistrations(page);
                
                // Scroll to top of table
                $('html, body').animate({
                    scrollTop: $('#tableContainer').offset().top - 100
                }, 300);
            }
        });
    }
});
</script>
@endsection
