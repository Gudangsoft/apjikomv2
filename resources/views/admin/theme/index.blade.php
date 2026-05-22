@extends('layouts.admin')

@section('page-title', 'Tema Website')

@section('content')
<div class="max-w-5xl">

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center">
        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.theme.update') }}" id="themeForm">
        @csrf
        @method('PUT')

        {{-- Hidden inputs yang diisi via JS --}}
        <input type="hidden" name="theme_preset"  id="input_preset"  value="{{ $current['preset'] }}">
        <input type="hidden" name="theme_primary" id="input_primary" value="{{ $current['primary'] }}">
        <input type="hidden" name="theme_dark"    id="input_dark"    value="{{ $current['dark'] }}">
        <input type="hidden" name="theme_light"   id="input_light"   value="{{ $current['light'] }}">
        <input type="hidden" name="theme_pale"    id="input_pale"    value="{{ $current['pale'] }}">
        <input type="hidden" name="theme_footer"  id="input_footer"  value="{{ $current['footer'] }}">

        {{-- === BAGIAN 1: TEMA SIAP PAKAI === --}}
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-900">Pilih Tema Siap Pakai</h2>
                <p class="text-sm text-gray-500 mt-1">Klik tema untuk melihat preview langsung. Tekan Simpan untuk menerapkan.</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3" id="presetGrid">
                    @foreach($presets as $key => $preset)
                    <button type="button"
                        onclick="applyPreset('{{ $key }}', '{{ $preset['primary'] }}', '{{ $preset['dark'] }}', '{{ $preset['light'] }}', '{{ $preset['pale'] }}', '{{ $preset['footer'] }}')"
                        id="preset_{{ $key }}"
                        class="preset-card group relative flex flex-col items-center p-3 rounded-xl border-2 transition-all cursor-pointer text-center
                            {{ $current['preset'] === $key ? 'border-gray-900 shadow-lg scale-105' : 'border-gray-200 hover:border-gray-400' }}">

                        {{-- Color swatch --}}
                        <div class="w-full h-14 rounded-lg mb-2 overflow-hidden flex shadow-sm">
                            <div class="flex-1" style="background-color: {{ $preset['primary'] }}"></div>
                            <div class="w-5" style="background-color: {{ $preset['dark'] }}"></div>
                            <div class="w-4" style="background-color: {{ $preset['light'] }}"></div>
                        </div>

                        {{-- Footer preview --}}
                        <div class="w-full h-3 rounded mb-2" style="background-color: {{ $preset['footer'] }}"></div>

                        <span class="text-xs font-semibold text-gray-700">{{ $preset['emoji'] }} {{ $preset['name'] }}</span>

                        @if($current['preset'] === $key)
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-gray-900 rounded-full flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        @endif
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- === BAGIAN 2: KUSTOMISASI WARNA === --}}
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Kustomisasi Warna</h2>
                    <p class="text-sm text-gray-500 mt-1">Atur warna secara manual untuk tema kustom.</p>
                </div>
                <button type="button" onclick="resetToActive()" class="text-xs text-gray-500 hover:text-gray-700 underline">
                    Reset ke tema aktif
                </button>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach([
                        ['id' => 'primary', 'label' => 'Warna Utama', 'desc' => 'Navbar, tombol, highlight'],
                        ['id' => 'dark',    'label' => 'Warna Gelap',  'desc' => 'Hover, gradasi gelap'],
                        ['id' => 'light',   'label' => 'Warna Terang', 'desc' => 'Aksen, badge, border'],
                        ['id' => 'pale',    'label' => 'Warna Pucat',  'desc' => 'Background card, section'],
                        ['id' => 'footer',  'label' => 'Warna Footer', 'desc' => 'Background footer & topbar'],
                    ] as $col)
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">{{ $col['label'] }}</label>
                        <p class="text-xs text-gray-400">{{ $col['desc'] }}</p>
                        <div class="flex items-center gap-2">
                            <input type="color"
                                id="picker_{{ $col['id'] }}"
                                value="{{ $current[$col['id']] }}"
                                onchange="updateColor('{{ $col['id'] }}', this.value)"
                                class="w-10 h-10 rounded cursor-pointer border border-gray-300 p-0.5">
                            <input type="text"
                                id="hex_{{ $col['id'] }}"
                                value="{{ $current[$col['id']] }}"
                                oninput="syncHex('{{ $col['id'] }}', this.value)"
                                maxlength="7"
                                placeholder="#000000"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none uppercase">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- === BAGIAN 3: LIVE PREVIEW === --}}
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-900">Live Preview</h2>
                <p class="text-sm text-gray-500 mt-1">Tampilan perkiraan dengan warna yang dipilih.</p>
            </div>
            <div class="p-6">
                <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">

                    {{-- Topbar --}}
                    <div id="prev_topbar" class="px-4 py-1.5 text-white text-xs flex items-center gap-4" style="background-color: {{ $current['footer'] }}">
                        <span>📧 info@example.com</span>
                        <span>📞 +62 21 0000000</span>
                    </div>

                    {{-- Navbar --}}
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-b">
                        <div class="flex items-center gap-2">
                            <div id="prev_logo" class="w-8 h-8 rounded flex items-center justify-center text-white text-xs font-bold" style="background-color: {{ $current['primary'] }}">WA</div>
                            <span class="font-bold text-gray-800 text-sm">{{ $globalSiteName }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span id="prev_link" class="font-medium" style="color: {{ $current['primary'] }}">Beranda</span>
                            <span class="text-gray-600">Berita</span>
                            <span class="text-gray-600">Kegiatan</span>
                            <div id="prev_btn" class="px-3 py-1.5 rounded text-white text-xs font-medium" style="background-color: {{ $current['primary'] }}">Bergabung</div>
                        </div>
                    </div>

                    {{-- Hero --}}
                    <div id="prev_hero" class="px-6 py-8 text-white text-center" style="background: linear-gradient(135deg, {{ $current['primary'] }}, {{ $current['dark'] }})">
                        <h3 class="text-lg font-bold mb-1">Selamat Datang di {{ $globalSiteName }}</h3>
                        <p class="text-sm opacity-80 mb-3">{{ $globalSiteTagline }}</p>
                        <div class="inline-flex gap-2">
                            <div class="px-4 py-1.5 bg-white rounded text-xs font-semibold" id="prev_hero_btn" style="color: {{ $current['primary'] }}">Daftar Sekarang</div>
                            <div class="px-4 py-1.5 border border-white rounded text-xs text-white">Pelajari Lebih</div>
                        </div>
                    </div>

                    {{-- Cards --}}
                    <div id="prev_pale_bg" class="px-4 py-4 grid grid-cols-3 gap-3" style="background-color: {{ $current['pale'] }}">
                        @foreach(['Berita Terbaru', 'Kegiatan', 'Anggota'] as $card)
                        <div class="bg-white rounded-lg p-3 shadow-sm border-l-4" id="prev_card" style="border-color: {{ $current['primary'] }}">
                            <p class="text-xs font-semibold text-gray-700">{{ $card }}</p>
                            <p class="text-xs text-gray-400 mt-1">Lorem ipsum dolor sit amet...</p>
                            <div class="mt-2 text-xs font-medium" style="color: {{ $current['primary'] }}">Selengkapnya →</div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div id="prev_footer" class="px-4 py-3 text-white text-xs flex justify-between items-center" style="background-color: {{ $current['footer'] }}">
                        <span class="font-semibold">{{ $globalSiteName }}</span>
                        <span class="opacity-60">© {{ date('Y') }} All Rights Reserved</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- === TOMBOL SIMPAN === --}}
        <div class="flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Terapkan Tema
            </button>
        </div>

    </form>
</div>

<script>
const presets = @json($presets);

function applyPreset(key, primary, dark, light, pale, footer) {
    // Update hidden inputs
    document.getElementById('input_preset').value  = key;
    document.getElementById('input_primary').value = primary;
    document.getElementById('input_dark').value    = dark;
    document.getElementById('input_light').value   = light;
    document.getElementById('input_pale').value    = pale;
    document.getElementById('input_footer').value  = footer;

    // Update color pickers & hex inputs
    ['primary','dark','light','pale','footer'].forEach(id => {
        const val = {primary,dark,light,pale,footer}[id];
        document.getElementById('picker_' + id).value = val;
        document.getElementById('hex_' + id).value = val;
    });

    // Update preset card selection state
    document.querySelectorAll('.preset-card').forEach(el => {
        el.classList.remove('border-gray-900', 'shadow-lg', 'scale-105');
        el.classList.add('border-gray-200');
        const tick = el.querySelector('.absolute');
        if (tick) tick.remove();
    });
    const active = document.getElementById('preset_' + key);
    if (active) {
        active.classList.add('border-gray-900', 'shadow-lg', 'scale-105');
        active.classList.remove('border-gray-200');
    }

    // Update live preview
    updatePreview();
}

function updateColor(id, value) {
    document.getElementById('input_' + id).value = value;
    document.getElementById('hex_' + id).value = value;
    document.getElementById('input_preset').value = 'custom';
    updatePreview();
}

function syncHex(id, value) {
    if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
        document.getElementById('picker_' + id).value = value;
        document.getElementById('input_' + id).value = value;
        document.getElementById('input_preset').value = 'custom';
        updatePreview();
    }
}

function updatePreview() {
    const primary = document.getElementById('input_primary').value;
    const dark    = document.getElementById('input_dark').value;
    const light   = document.getElementById('input_light').value;
    const pale    = document.getElementById('input_pale').value;
    const footer  = document.getElementById('input_footer').value;

    // Topbar & Footer
    document.getElementById('prev_topbar').style.backgroundColor = footer;
    document.getElementById('prev_footer').style.backgroundColor = footer;

    // Logo & Primary elements
    document.getElementById('prev_logo').style.backgroundColor = primary;
    document.getElementById('prev_btn').style.backgroundColor  = primary;
    document.getElementById('prev_link').style.color = primary;

    // Hero gradient
    document.getElementById('prev_hero').style.background = `linear-gradient(135deg, ${primary}, ${dark})`;
    document.getElementById('prev_hero_btn').style.color = primary;

    // Cards pale background
    document.getElementById('prev_pale_bg').style.backgroundColor = pale;
    document.querySelectorAll('#prev_card').forEach(card => {
        card.style.borderColor = primary;
        card.querySelector('div').style.color = primary;
    });
}

function resetToActive() {
    const preset = '{{ $current['preset'] }}';
    if (presets[preset]) {
        const p = presets[preset];
        applyPreset(preset, p.primary, p.dark, p.light, p.pale, p.footer);
    }
}
</script>
@endsection
