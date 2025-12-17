@extends('layouts.admin')

@section('page-title', 'Kelola Members')

@section('content')
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Daftar Members</h3>
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
                Halaman ini untuk <strong>mengelola member aktif</strong> yang sudah di-approve. 
                Gunakan <strong>✏️ Edit</strong> untuk update data member atau ubah status ACTIVE/INACTIVE.
            </p>
            <a href="{{ asset('TUTORIAL_ADMIN_MEMBER_REGISTRATION.md') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium underline">
                📖 Baca Tutorial Lengkap →
            </a>
        </div>
    </div>
</div>

<!-- New Members Alert -->
@php
    $newMembers = \App\Models\Member::where(function($query) {
        $query->whereNull('member_card')
              ->where('card_requested', true);
    })->orWhere(function($query) {
        $query->whereNull('member_card')
              ->whereNotNull('photo')
              ->whereNotNull('address')
              ->whereNotNull('phone');
    })->with('user')->get();
    
    // Card update requests
    $updateRequestMembers = \App\Models\Member::where('card_update_requested', true)
        ->whereNotNull('member_card')
        ->with('user')
        ->orderBy('card_update_requested_at', 'desc')
        ->get();
@endphp

<!-- Card Update Requests Alert -->
@if($updateRequestMembers->count() > 0)
<div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-amber-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-800 mb-1">
                🔄 Ada {{ $updateRequestMembers->count() }} Permintaan Update Kartu Anggota
            </h3>
            <p class="text-sm text-amber-700 mb-3">
                Member berikut meminta pembaruan kartu karena ada perubahan data:
            </p>
            <div class="bg-amber-100 rounded-lg p-3">
                <ul class="space-y-2">
                    @foreach($updateRequestMembers->take(5) as $updateMember)
                    <li class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 bg-amber-600 text-white text-xs font-bold rounded">UPDATE</span>
                            <span class="text-amber-900 font-medium">{{ $updateMember->user->name }}</span>
                            <span class="text-amber-600 text-xs">({{ $updateMember->user->email }})</span>
                            <span class="text-xs text-amber-600 italic">
                                - {{ $updateMember->card_update_requested_at->diffForHumans() }}
                            </span>
                        </div>
                        <a href="{{ route('admin.members.show', $updateMember->id) }}" 
                           class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded-lg transition">
                            Regenerate Kartu
                        </a>
                    </li>
                    @endforeach
                    @if($updateRequestMembers->count() > 5)
                    <li class="text-xs text-amber-600 italic">
                        ... dan {{ $updateRequestMembers->count() - 5 }} member lainnya
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@if($newMembers->count() > 0)
<div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-blue-800 mb-1">
                🔔 Ada {{ $newMembers->count() }} Permintaan Kartu Anggota (KTA)
            </h3>
            <p class="text-sm text-blue-700 mb-3">
                Member berikut sudah melengkapi data dan meminta pembuatan Kartu Anggota:
            </p>
            <div class="bg-blue-100 rounded-lg p-3">
                <ul class="space-y-2">
                    @foreach($newMembers->take(5) as $newMember)
                    <li class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            @if($newMember->card_requested)
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">REQUEST</span>
                            @else
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                            <span class="text-blue-900 font-medium">{{ $newMember->user->name }}</span>
                            <span class="text-blue-600 text-xs">({{ $newMember->user->email }})</span>
                            @if($newMember->card_requested)
                                <span class="text-xs text-blue-600 italic">
                                    - {{ $newMember->card_requested_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('admin.members.show', $newMember->id) }}" 
                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition">
                            Generate Kartu
                        </a>
                    </li>
                    @endforeach
                    @if($newMembers->count() > 5)
                    <li class="text-xs text-blue-600 italic">
                        ... dan {{ $newMembers->count() - 5 }} member lainnya
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Advanced Search & Filter with Alpine.js -->
<div class="mb-6 bg-white rounded-lg shadow p-6" x-data="memberFilter()">
    <form @submit.prevent="applyFilters">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" 
                       x-model.debounce.500ms="filters.search"
                       @input="applyFilters"
                       placeholder="Nama, email, institusi..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select x-model="filters.status" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="active">Aktif</option>
                    <option value="rejected">Ditolak</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Verification Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Verifikasi</label>
                <select x-model="filters.verified" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1">Verified</option>
                    <option value="0">Unverified</option>
                </select>
            </div>

            <!-- Card Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Kartu</label>
                <select x-model="filters.has_card" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1">Sudah Ada Kartu</option>
                    <option value="0">Belum Ada Kartu</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" 
                       x-model="filters.date_from"
                       @change="applyFilters"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" 
                       x-model="filters.date_to"
                       @change="applyFilters"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                <select x-model="filters.sort" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-600" x-html="recordInfo">
                Menampilkan {{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }} dari {{ $members->total() }} member
            </div>
            <div class="flex space-x-3">
                <button type="button" @click="resetFilters" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Reset Filter
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden" id="tableContainer">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verified</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kartu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
            @forelse($members as $member)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $member->user->name }}</div>
                    @if($member->institution_name)
                    <div class="text-xs text-gray-500">{{ $member->institution_name }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $member->user->email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($member->status == 'pending')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($member->status == 'active')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @elseif($member->status == 'rejected')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($member->status) }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-verified-badge :member="$member" size="sm" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($member->member_card)
                        <span class="text-green-600" title="Kartu sudah diupload">
                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @else
                        <span class="text-gray-400" title="Belum ada kartu">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $member->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.members.show', $member) }}" class="text-gray-600 hover:text-gray-900 mr-3" title="Detail">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    
                    @if($member->status == 'pending')
                    <form method="POST" action="{{ route('admin.members.approve', $member) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3" title="Approve">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.members.reject', $member) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-900 mr-3" title="Reject">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.members.destroy', $member) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada member</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6" id="paginationContainer">
    {{ $members->links() }}
</div>
@endsection

@push('scripts')
<script>
function memberFilter() {
    return {
        loading: false,
        filters: {
            search: '{{ request("search") }}',
            status: '{{ request("status") }}',
            verified: '{{ request("verified") }}',
            has_card: '{{ request("has_card") }}',
            date_from: '{{ request("date_from") }}',
            date_to: '{{ request("date_to") }}',
            sort: '{{ request("sort", "latest") }}'
        },
        currentPage: 1,
        recordInfo: 'Menampilkan {{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }} dari {{ $members->total() }} member',
        
        init() {
            this.$nextTick(() => {
                this.bindPaginationLinks();
            });
        },
        
        applyFilters() {
            this.currentPage = 1;
            this.loadData();
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                status: '',
                verified: '',
                has_card: '',
                date_from: '',
                date_to: '',
                sort: 'latest'
            };
            this.currentPage = 1;
            this.loadData();
        },
        
        loadData(page = null) {
            if (page) this.currentPage = page;
            
            const params = new URLSearchParams({
                ...this.filters,
                page: this.currentPage
            });
            
            for (let [key, value] of [...params.entries()]) {
                if (!value) params.delete(key);
            }
            
            this.loading = true;
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><div class="mt-2 text-gray-600">Memuat data...</div></td></tr>';
            
            fetch(`{{ route("admin.members.index") }}?${params.toString()}`, {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTableBody = doc.querySelector('#tableBody');
                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                }
                
                const newPagination = doc.querySelector('#paginationContainer');
                const paginationContainer = document.getElementById('paginationContainer');
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                    this.bindPaginationLinks();
                }
                
                const newRecordInfo = doc.querySelector('#recordInfo');
                if (newRecordInfo) {
                    this.recordInfo = newRecordInfo.innerHTML;
                }
                
                this.loading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center text-red-600">Terjadi kesalahan saat memuat data. Silakan coba lagi.</td></tr>';
                this.loading = false;
            });
        },
        
        bindPaginationLinks() {
            document.querySelectorAll('#paginationContainer a').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = link.getAttribute('href');
                    if (url) {
                        const urlParams = new URLSearchParams(url.split('?')[1]);
                        const page = urlParams.get('page') || 1;
                        this.loadData(page);
                        
                        document.getElementById('tableContainer').scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                });
            });
        }
    }
}
</script>
@endpush
