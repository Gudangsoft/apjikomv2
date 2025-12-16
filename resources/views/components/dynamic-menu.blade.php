<!-- Dynamic Menu Component -->
@if($globalMenus && $globalMenus->count() > 0)
    @foreach($globalMenus as $menu)
        @if($menu->type == 'dropdown' && $menu->children->count() > 0)
            <!-- Dropdown Menu -->
            <div class="relative group">
                <button class="text-gray-700 hover:text-purple-600 font-medium text-sm flex items-center">
                    @if($menu->icon)
                        <i class="{{ $menu->icon }} mr-1"></i>
                    @endif
                    {{ $menu->title }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Level 1 Dropdown -->
                <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2">
                        @foreach($menu->children as $childMenu)
                            @if($childMenu->type == 'dropdown' && $childMenu->children->count() > 0)
                                <!-- Level 2 with children -->
                                <div class="relative group/sub">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 flex items-center justify-between">
                                        <span>
                                            @if($childMenu->icon)
                                                <i class="{{ $childMenu->icon }} mr-2"></i>
                                            @endif
                                            {{ $childMenu->title }}
                                        </span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Level 2 Dropdown -->
                                    <div class="absolute left-full top-0 mt-0 w-56 bg-white rounded-md shadow-lg opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200">
                                        <div class="py-2">
                                            @foreach($childMenu->children as $grandChildMenu)
                                                <a href="{{ $grandChildMenu->type == 'page' && $grandChildMenu->page ? route('page.show', $grandChildMenu->page->slug) : ($grandChildMenu->url ?? '#') }}" 
                                                   target="{{ $grandChildMenu->target }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                                    @if($grandChildMenu->icon)
                                                        <i class="{{ $grandChildMenu->icon }} mr-2"></i>
                                                    @endif
                                                    {{ $grandChildMenu->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Level 2 without children -->
                                <a href="{{ $childMenu->type == 'page' && $childMenu->page ? route('page.show', $childMenu->page->slug) : ($childMenu->url ?? '#') }}" 
                                   target="{{ $childMenu->target }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                    @if($childMenu->icon)
                                        <i class="{{ $childMenu->icon }} mr-2"></i>
                                    @endif
                                    {{ $childMenu->title }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Simple Link -->
            <a href="{{ $menu->type == 'page' && $menu->page ? route('page.show', $menu->page->slug) : ($menu->url ?? '#') }}" 
               target="{{ $menu->target }}"
               class="text-gray-700 hover:text-purple-600 font-medium text-sm {{ request()->is(ltrim($menu->url ?? '', '/')) ? 'text-purple-600' : '' }}">
                @if($menu->icon)
                    <i class="{{ $menu->icon }} mr-1"></i>
                @endif
                {{ $menu->title }}
            </a>
        @endif
    @endforeach
@endif
