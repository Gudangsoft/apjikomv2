@extends('layouts.admin')

@section('page-title', 'Changelog & Update Requests')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <h3 class="text-2xl font-bold text-gray-900">Changelog & Update Requests</h3>
            <button onclick="toggleAutoRefresh()" id="autoRefreshBtn" class="bg-green-500 text-white px-3 py-1.5 rounded text-sm hover:bg-green-600 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Auto-refresh ON</span>
            </button>
            <span class="text-sm text-gray-500">🔄 Refresh setiap 30 detik</span>
        </div>
        <a href="{{ route('admin.changelog.create') }}" class="bg-[#00629B] text-white px-4 py-2 rounded hover:bg-[#003A5D] flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Changelog</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('changelog')" id="tab-changelog" class="tab-button border-b-2 border-[#00629B] text-[#00629B] py-4 px-1 text-sm font-medium">
                    Changelog History
                </button>
                <button onclick="showTab('requests')" id="tab-requests" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                    Update Requests
                    @if($updateRequests->where('status', 'pending')->count() > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $updateRequests->where('status', 'pending')->count() }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Changelog Tab Content -->
        <div id="changelog-content" class="tab-content p-6">
            <div class="space-y-4">
                @forelse($changelogs as $changelog)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    @if($changelog->version)
                                        <span class="text-lg font-bold text-gray-900">v{{ $changelog->version }}</span>
                                    @endif
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $changelog->type === 'feature' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $changelog->type === 'bugfix' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $changelog->type === 'security' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $changelog->type === 'update' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ ucfirst($changelog->type) }}
                                    </span>
                                    @if(!$changelog->is_published)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600 mb-3">
                                    <span>📅 {{ $changelog->release_date->format('d M Y') }}</span>
                                    @if($changelog->updated_by)
                                        <span class="ml-3">👤 {{ $changelog->updated_by }}</span>
                                    @endif
                                </div>
                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($changelog->changes)) !!}
                                </div>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <a href="{{ route('admin.changelog.edit', $changelog) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.changelog.destroy', $changelog) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus changelog ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2">Belum ada changelog</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($changelogs->hasPages())
                <div class="mt-6">
                    {{ $changelogs->links() }}
                </div>
            @endif
        </div>

        <!-- Update Requests Tab Content -->
        <div id="requests-content" class="tab-content p-6 hidden">
            <!-- Add New Request Button -->
            <div class="mb-4 flex justify-end">
                <button onclick="openRequestModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Update Request</span>
                </button>
            </div>

            <div class="space-y-4">
                @forelse($updateRequests as $request)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $request->title }}</h4>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $request->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $request->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $request->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->priority === 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst($request->priority) }}
                                    </span>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $request->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </div>
                                <div class="bg-gray-50 border-l-4 border-purple-400 p-3 mb-3">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700">Dikirim oleh:</span>
                                    </div>
                                    @if($request->user)
                                        <p class="text-sm text-gray-900 font-medium">{{ $request->user->name }}</p>
                                        <p class="text-xs text-gray-600">✉️ {{ $request->user->email }}</p>
                                        @if($request->user->member)
                                            <p class="text-xs text-gray-600">🏢 {{ $request->user->member->institution_name ?? 'N/A' }}</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-gray-500">User tidak ditemukan</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">📅 {{ $request->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="text-gray-700 mb-3">
                                    {{ $request->description }}
                                </div>
                                @if($request->admin_notes)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mt-2">
                                        <p class="text-sm font-semibold text-blue-800 mb-1">Admin Notes:</p>
                                        <p class="text-sm text-blue-700">{{ $request->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <button onclick="openStatusModal({{ $request->id }}, '{{ $request->status }}', '{{ addslashes($request->admin_notes ?? '') }}')" 
                                        class="text-blue-600 hover:text-blue-900 p-2" title="Update Status">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.update-requests.destroy', $request) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus request ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="mt-2">Belum ada update request</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($updateRequests->hasPages())
                <div class="mt-6">
                    {{ $updateRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeStatusModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status Request</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea name="admin_notes" id="adminNotes" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                  placeholder="Catatan untuk member..."></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#00629B] text-base font-medium text-white hover:bg-[#003A5D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Status
                    </button>
                    <button type="button" onclick="closeStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Update Request Modal -->
<div id="requestModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRequestModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.update-requests.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Update Request Baru</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Request <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                               placeholder="Contoh: Tambah fitur export PDF">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                  placeholder="Jelaskan detail request Anda..."></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas <span class="text-red-500">*</span></label>
                        <select name="priority" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Prioritas</option>
                            <option value="low">Low - Tidak mendesak</option>
                            <option value="medium">Medium - Cukup penting</option>
                            <option value="high">High - Penting</option>
                            <option value="urgent">Urgent - Sangat mendesak</option>
                        </select>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 text-sm text-blue-700">
                        <p class="font-semibold mb-1">💡 Tips:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jelaskan request sejelas mungkin</li>
                            <li>Sebutkan fitur atau halaman yang dimaksud</li>
                            <li>Berikan contoh jika memungkinkan</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Request
                    </button>
                    <button type="button" onclick="closeRequestModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let lastCheckTime = new Date().toISOString();
let autoRefreshEnabled = true;
let refreshInterval = 30000; // 30 detik

function showTab(tab) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-[#00629B]', 'text-[#00629B]');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tab + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById('tab-' + tab);
    activeTab.classList.add('border-[#00629B]', 'text-[#00629B]');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

function openStatusModal(requestId, currentStatus, currentNotes) {
    document.getElementById('statusForm').action = '/admin/update-requests/' + requestId + '/status';
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('adminNotes').value = currentNotes;
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

function openRequestModal() {
    document.getElementById('requestModal').classList.remove('hidden');
}

function closeRequestModal() {
    document.getElementById('requestModal').classList.add('hidden');
}

// Auto-refresh functionality
function checkForUpdates() {
    if (!autoRefreshEnabled) return;
    
    fetch('/admin/changelog/latest?last_check=' + encodeURIComponent(lastCheckTime), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.hasNewChangelogs || data.hasNewRequests) {
            showUpdateNotification(data);
            updatePendingBadge(data.pendingCount);
        }
        lastCheckTime = data.timestamp;
    })
    .catch(error => {
        console.log('Error checking for updates:', error);
    });
}

function showUpdateNotification(data) {
    let message = '';
    if (data.hasNewChangelogs) {
        message += `${data.changelogs.length} changelog baru tersedia. `;
    }
    if (data.hasNewRequests) {
        message += `${data.updateRequests.length} update request baru. `;
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center space-x-3 animate-slide-in';
    notification.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-semibold">${message}</p>
            <button onclick="location.reload()" class="text-sm underline mt-1">Klik untuk refresh</button>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 10 seconds
    setTimeout(() => {
        notification.remove();
    }, 10000);
}

function updatePendingBadge(count) {
    const badge = document.querySelector('#tab-requests .bg-red-500');
    if (count > 0 && !badge) {
        const span = document.createElement('span');
        span.className = 'ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full';
        span.textContent = count;
        document.getElementById('tab-requests').appendChild(span);
    } else if (badge) {
        badge.textContent = count;
        if (count === 0) badge.remove();
    }
}

function toggleAutoRefresh() {
    autoRefreshEnabled = !autoRefreshEnabled;
    const button = document.getElementById('autoRefreshBtn');
    if (autoRefreshEnabled) {
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Auto-refresh ON</span>';
        button.classList.remove('bg-gray-500');
        button.classList.add('bg-green-500');
    } else {
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg><span>Auto-refresh OFF</span>';
        button.classList.remove('bg-green-500');
        button.classList.add('bg-gray-500');
    }
}

// Start auto-refresh
setInterval(checkForUpdates, refreshInterval);

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);

// Handle hash on page load (for direct links to requests tab)
window.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === '#requests') {
        showTab('requests');
    }
});
</script>
@endsection
