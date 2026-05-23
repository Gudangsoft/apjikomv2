@props([
    'dimensions' => null,
    'ratio'      => null,
    'maxSize'    => '2MB',
    'formats'    => 'JPG, PNG',
    'note'       => null,
])
<div class="mt-2 rounded-lg border border-blue-100 bg-blue-50 px-3 py-2.5 flex flex-wrap gap-x-4 gap-y-1.5 text-xs text-blue-700">
    @if($dimensions)
    <span class="flex items-center gap-1 font-medium">
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
        </svg>
        {{ $dimensions }}px{{ $ratio ? ' ('.$ratio.')' : '' }}
    </span>
    @endif
    <span class="flex items-center gap-1">
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        Maks <strong>{{ $maxSize }}</strong>
    </span>
    <span class="flex items-center gap-1">
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        {{ $formats }}
    </span>
    @if($note)
    <span class="w-full text-blue-600 italic">{{ $note }}</span>
    @endif
</div>
