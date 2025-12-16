@extends('layouts.admin')

@section('page-title', 'Kelola Menu')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Daftar Menu (3 Tingkat)</h3>
        <p class="text-sm text-gray-600 mt-1">Drag & drop untuk mengurutkan menu</p>
    </div>
    <a href="{{ route('admin.menus.create') }}" class="bg-[#00629B] text-white px-4 py-2 rounded hover:bg-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Menu</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        @if($menus->count() > 0)
            <div id="menu-list" class="space-y-2">
                @foreach($menus as $menu)
                    @include('admin.menus.partials.menu-item', ['menu' => $menu, 'level' => 0])
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                Belum ada menu. <a href="{{ route('admin.menus.create') }}" class="text-[#00629B] hover:underline">Tambah menu pertama</a>
            </div>
        @endif
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable for main menu
    const menuList = document.getElementById('menu-list');
    if (menuList) {
        new Sortable(menuList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateMenuOrder(evt.to, null);
            }
        });
    }
    
    // Initialize sortable for all submenus
    document.querySelectorAll('.submenu-list').forEach(function(submenu) {
        const parentId = submenu.closest('.menu-item-wrapper').dataset.menuId;
        new Sortable(submenu, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateMenuOrder(evt.to, parentId);
            }
        });
    });
});

function updateMenuOrder(container, parentId) {
    const items = container.querySelectorAll(':scope > .menu-item-wrapper');
    const updates = [];
    
    items.forEach(function(item, index) {
        const menuId = item.dataset.menuId;
        updates.push({
            id: menuId,
            order: index + 1
        });
    });
    
    // Send AJAX request to update order
    fetch('{{ route("admin.menus.update-order") }}', {
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
            // Update order numbers in UI
            items.forEach(function(item, index) {
                const orderSpan = item.querySelector('.menu-order-display');
                if (orderSpan) {
                    orderSpan.textContent = 'Urutan: ' + (index + 1);
                }
            });
            
            // Show success message
            showNotification('Urutan menu berhasil diperbarui!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal memperbarui urutan menu!', 'error');
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

.drag-handle:hover {
    color: #00629B;
}
</style>
@endsection
