@php
    $indentClass = [
        0 => '',
        1 => 'ml-8',
        2 => 'ml-16',
    ];
    $bgClass = [
        0 => 'bg-blue-50 border-l-4 border-blue-500',
        1 => 'bg-green-50 border-l-4 border-green-500',
        2 => 'bg-yellow-50 border-l-4 border-yellow-500',
    ];
@endphp

<div class="menu-item-wrapper {{ $indentClass[$level] ?? 'ml-24' }} mb-2" data-menu-id="{{ $menu->id }}">
    <div class="flex items-center justify-between p-4 {{ $bgClass[$level] ?? 'bg-gray-50 border-l-4 border-gray-500' }} rounded-lg transition-all duration-200 hover:shadow-md">
        <div class="flex items-center space-x-4 flex-1">
            <!-- Drag Handle -->
            <div class="drag-handle flex-shrink-0 cursor-move text-gray-400 hover:text-[#00629B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                </svg>
            </div>
            
            <!-- Level indicator -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $level == 0 ? 'bg-blue-600' : ($level == 1 ? 'bg-green-600' : 'bg-yellow-600') }} text-white text-xs font-bold">
                    L{{ $level + 1 }}
                </span>
            </div>
            
            <!-- Menu info -->
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    @if($menu->icon)
                        <i class="{{ $menu->icon }} text-gray-600"></i>
                    @endif
                    <h4 class="text-sm font-semibold text-gray-900">{{ $menu->title }}</h4>
                    
                    <!-- Menu type badge -->
                    @if($menu->type == 'dropdown')
                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">Dropdown</span>
                    @elseif($menu->type == 'page')
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Page</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">Link</span>
                    @endif
                    
                    <!-- Status badge -->
                    @if($menu->is_active)
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                    @endif
                </div>
                
                <div class="mt-1 text-xs text-gray-600">
                    @if($menu->type == 'page' && $menu->page)
                        <span>→ Halaman: {{ $menu->page->title }}</span>
                    @elseif($menu->url)
                        <span>→ URL: {{ $menu->url }}</span>
                    @endif
                    <span class="menu-order-display ml-3">Urutan: {{ $menu->order }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.menus.edit', $menu) }}" 
                class="px-3 py-1 text-sm text-white bg-[#00629B] hover:bg-[#003A5D] rounded transition-colors">
                Edit
            </a>
            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline-block" 
                onsubmit="return confirm('Yakin ingin menghapus menu ini? Sub-menu juga akan terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    
    <!-- Render children recursively (up to 3 levels) -->
    @if($menu->children && $menu->children->count() > 0 && $level < 2)
        <div class="submenu-list mt-2">
            @foreach($menu->children as $childMenu)
                @include('admin.menus.partials.menu-item', ['menu' => $childMenu, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
