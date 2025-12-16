<div class="mb-8 {{ $align === 'center' ? 'text-center' : '' }}">
    @if($title)
    <h2 class="text-3xl font-bold mb-3 {{ $darkMode ? 'text-white' : 'text-gray-900' }}">
        {{ $title }}
    </h2>
    @endif
    
    @if($subtitle)
    <p class="text-lg {{ $darkMode ? 'text-gray-300' : 'text-gray-600' }}">
        {{ $subtitle }}
    </p>
    @endif
</div>
