@props([
    'title' => '',
    'icon'  => '',
])
<div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
    <button
        @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition text-left"
    >
        <span class="flex items-center gap-2 font-semibold text-gray-800">
            @if($icon)
            <span class="text-lg leading-none">{{ $icon }}</span>
            @endif
            {{ $title }}
        </span>
        <svg
            class="w-4 h-4 text-gray-500 flex-shrink-0 transition-transform duration-200"
            :class="open ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="px-4 py-3 text-sm text-gray-700 bg-white border-t border-gray-100"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
