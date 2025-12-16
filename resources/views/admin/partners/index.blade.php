@extends('layouts.admin')

@section('title', 'Kelola Partner')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Partner</h1>
            <p class="text-gray-600 mt-1">Kelola logo partner yang ditampilkan di website</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" 
           class="px-6 py-3 bg-[#00629B] hover:bg-[#003A5D] text-white rounded-lg transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Partner</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Partners List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($partners->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-lg font-medium">Belum ada partner</p>
                <p class="mt-1">Klik tombol "Tambah Partner" untuk menambahkan partner baru</p>
            </div>
        @else
            <div id="partners-list" class="divide-y divide-gray-200">
                @foreach($partners as $partner)
                    <div class="partner-item p-4 hover:bg-gray-50 transition-colors" data-partner-id="{{ $partner->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <!-- Drag Handle -->
                                <div class="drag-handle flex-shrink-0 cursor-move text-gray-400 hover:text-[#00629B]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>

                                <!-- Logo Preview -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $partner->logo_url }}" 
                                         alt="{{ $partner->name }}"
                                         class="w-20 h-20 object-contain bg-gray-50 border border-gray-200 rounded p-2">
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $partner->name }}</h3>
                                        @if($partner->is_active)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Nonaktif</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600">
                                        <span class="partner-order-display">Urutan: {{ $partner->order }}</span>
                                        @if($partner->url)
                                            <span class="ml-4">→ <a href="{{ $partner->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $partner->url }}</a></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.partners.edit', $partner) }}" 
                                   class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus partner ini?')"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const partnersList = document.getElementById('partners-list');
    
    if (partnersList) {
        new Sortable(partnersList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updatePartnersOrder();
            }
        });
    }
});

function updatePartnersOrder() {
    const items = document.querySelectorAll('.partner-item');
    const updates = [];
    
    items.forEach(function(item, index) {
        const partnerId = item.dataset.partnerId;
        updates.push({
            id: partnerId,
            order: index + 1
        });
    });
    
    // Send AJAX request
    fetch('{{ route("admin.partners.update-order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ updates: updates })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update order display
            items.forEach(function(item, index) {
                const orderSpan = item.querySelector('.partner-order-display');
                if (orderSpan) {
                    orderSpan.textContent = 'Urutan: ' + (index + 1);
                }
            });
            
            showNotification('Urutan partner berhasil diperbarui!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal memperbarui urutan partner!', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transition-all ${type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800'}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'}
            </svg>
            ${message}
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>

<style>
.sortable-ghost {
    opacity: 0.4;
    background: #f3f4f6 !important;
}

.sortable-drag {
    opacity: 0.8;
}

.drag-handle {
    cursor: move;
    cursor: grab;
}

.drag-handle:active {
    cursor: grabbing;
}
</style>
@endsection
