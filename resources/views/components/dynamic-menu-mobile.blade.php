<!-- Dynamic Mobile Menu Component -->
@if($globalMenus && $globalMenus->count() > 0)
    @foreach($globalMenus as $menu)
        @if($menu->type == 'dropdown' && $menu->children->count() > 0)
            <!-- Dropdown Menu for Mobile -->
            <div class="border-b border-gray-200">
                <button onclick="toggleMobileSubmenu('mobile-menu-{{ $menu->id }}')" 
                        class="w-full flex items-center justify-between py-3 text-sm text-gray-700 hover:text-purple-600">
                    <span>
                        @if($menu->icon)
                            <i class="{{ $menu->icon }} mr-2"></i>
                        @endif
                        {{ $menu->title }}
                    </span>
                    <svg class="w-4 h-4 transition-transform" id="mobile-menu-{{ $menu->id }}-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Level 1 Submenu -->
                <div id="mobile-menu-{{ $menu->id }}" class="hidden pl-4 pb-2">
                    @foreach($menu->children as $childMenu)
                        @if($childMenu->type == 'dropdown' && $childMenu->children->count() > 0)
                            <!-- Level 2 with children -->
                            <div class="border-l border-gray-300 ml-2">
                                <button onclick="toggleMobileSubmenu('mobile-menu-{{ $childMenu->id }}')" 
                                        class="w-full flex items-center justify-between py-2 pl-3 text-sm text-gray-600 hover:text-purple-600">
                                    <span>
                                        @if($childMenu->icon)
                                            <i class="{{ $childMenu->icon }} mr-2"></i>
                                        @endif
                                        {{ $childMenu->title }}
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" id="mobile-menu-{{ $childMenu->id }}-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Level 2 Submenu -->
                                <div id="mobile-menu-{{ $childMenu->id }}" class="hidden pl-4">
                                    @foreach($childMenu->children as $grandChildMenu)
                                        <a href="{{ $grandChildMenu->type == 'page' && $grandChildMenu->page ? route('page.show', $grandChildMenu->page->slug) : ($grandChildMenu->url ?? '#') }}" 
                                           target="{{ $grandChildMenu->target }}"
                                           class="block py-2 pl-3 text-sm text-gray-600 hover:text-purple-600 border-l border-gray-300 ml-2">
                                            @if($grandChildMenu->icon)
                                                <i class="{{ $grandChildMenu->icon }} mr-2"></i>
                                            @endif
                                            {{ $grandChildMenu->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Level 2 without children -->
                            <a href="{{ $childMenu->type == 'page' && $childMenu->page ? route('page.show', $childMenu->page->slug) : ($childMenu->url ?? '#') }}" 
                               target="{{ $childMenu->target }}"
                               class="block py-2 pl-3 text-sm text-gray-600 hover:text-purple-600 border-l border-gray-300 ml-2">
                                @if($childMenu->icon)
                                    <i class="{{ $childMenu->icon }} mr-2"></i>
                                @endif
                                {{ $childMenu->title }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <!-- Simple Link for Mobile -->
            <a href="{{ $menu->type == 'page' && $menu->page ? route('page.show', $menu->page->slug) : ($menu->url ?? '#') }}" 
               target="{{ $menu->target }}"
               class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">
                @if($menu->icon)
                    <i class="{{ $menu->icon }} mr-2"></i>
                @endif
                {{ $menu->title }}
            </a>
        @endif
    @endforeach
@endif
