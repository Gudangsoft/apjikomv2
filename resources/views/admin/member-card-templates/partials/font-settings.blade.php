{{-- Font & Typography Settings Panel --}}
{{-- Variables required: $availableFonts (array), $fontSettings (array with merged defaults) --}}

<div class="mt-8 border border-gray-200 rounded-xl overflow-hidden">
    {{-- Panel Header (clickable toggle) --}}
    <button type="button" onclick="toggleFontPanel()"
            class="w-full flex items-center justify-between px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition-colors">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h8M4 18h4"/>
                </svg>
            </div>
            <div class="text-left">
                <p class="font-semibold text-gray-900 text-sm">Pengaturan Font & Tipografi</p>
                <p class="text-xs text-gray-500">Atur ukuran huruf, jenis font, jarak baris, dan ketebalan teks kartu</p>
            </div>
        </div>
        <svg id="fontPanelChevron" class="w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Panel Body --}}
    <div id="fontPanelBody" class="hidden">
        <div class="p-6 bg-white space-y-8">

            {{-- ============================
                 SECTION: Jenis Font
                 ============================ --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-500 inline-block"></span>
                    Jenis Font
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Font Bold --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Font Tebal <span class="text-gray-400">(dipakai untuk label & header)</span>
                        </label>
                        <select name="font_settings[font_bold]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                            @foreach($availableFonts as $font)
                                <option value="{{ $font }}"
                                    {{ ($fontSettings['font_bold'] ?? 'arialbd.ttf') === $font ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                            @if(empty($availableFonts))
                                <option value="arialbd.ttf" selected>arialbd.ttf (default)</option>
                            @endif
                        </select>
                    </div>
                    {{-- Font Regular --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Font Biasa <span class="text-gray-400">(dipakai untuk nilai/isi)</span>
                        </label>
                        <select name="font_settings[font_regular]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                            @foreach($availableFonts as $font)
                                <option value="{{ $font }}"
                                    {{ ($fontSettings['font_regular'] ?? 'arial.ttf') === $font ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                            @if(empty($availableFonts))
                                <option value="arial.ttf" selected>arial.ttf (default)</option>
                            @endif
                        </select>
                    </div>
                </div>
                @if(empty($availableFonts))
                    <p class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tidak ada file font di <code>storage/fonts/</code>. Letakkan file .ttf ke folder tersebut.
                    </p>
                @endif
            </div>

            {{-- ============================
                 SECTION: Warna Teks
                 ============================ --}}
            <div class="border-t pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-pink-500 inline-block"></span>
                    Warna Teks
                </h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <input type="color" name="font_settings[font_color]"
                               id="fontColorPicker"
                               value="{{ $fontSettings['font_color'] ?? '#000000' }}"
                               class="w-12 h-10 rounded-lg border border-gray-300 cursor-pointer p-1"
                               oninput="document.getElementById('fontColorHex').value = this.value">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Hex Color</label>
                            <input type="text" id="fontColorHex"
                                   value="{{ $fontSettings['font_color'] ?? '#000000' }}"
                                   maxlength="7" placeholder="#000000"
                                   class="w-28 px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-purple-500"
                                   oninput="syncColorPicker(this.value)">
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        @foreach(['#000000' => 'Hitam', '#1a1a2e' => 'Navy', '#2d3748' => 'Abu Tua', '#1a365d' => 'Biru Tua', '#742a2a' => 'Merah Tua', '#1c4532' => 'Hijau Tua'] as $hex => $name)
                            <button type="button" onclick="setColor('{{ $hex }}')"
                                    title="{{ $name }}"
                                    class="w-7 h-7 rounded-full border-2 border-gray-300 hover:border-gray-500 transition-all"
                                    style="background-color: {{ $hex }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ============================
                 SECTION: Header Teks
                 ============================ --}}
            <div class="border-t pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                    Teks Header — "KARTU TANDA ANGGOTA"
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Header Font Size --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Ukuran Font: <strong id="headerFontSizeVal">{{ $fontSettings['header_font_size'] ?? 25 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[header_font_size]"
                               min="14" max="50" step="1"
                               value="{{ $fontSettings['header_font_size'] ?? 25 }}"
                               class="w-full accent-purple-600"
                               oninput="document.getElementById('headerFontSizeVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>14px</span><span>50px</span>
                        </div>
                    </div>
                    {{-- Header Bold --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Ketebalan</label>
                        <label class="flex items-center gap-3 cursor-pointer mt-3">
                            <input type="checkbox" name="font_settings[header_bold]" value="1"
                                   {{ ($fontSettings['header_bold'] ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                            <span class="text-sm text-gray-700">Tebal (<strong>Bold</strong>)</span>
                        </label>
                    </div>
                    {{-- Header Y Position --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Posisi Vertikal (Y): <strong id="headerYVal">{{ $fontSettings['header_y'] ?? 265 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[header_y]"
                               min="150" max="500" step="5"
                               value="{{ $fontSettings['header_y'] ?? 265 }}"
                               class="w-full accent-purple-600"
                               oninput="document.getElementById('headerYVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>150px</span><span>500px</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================
                 SECTION: Label Fields
                 ============================ --}}
            <div class="border-t pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                    Teks Label — No.Anggota, Nama, Institusi, dll.
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Label Font Size --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Ukuran Font: <strong id="labelFontSizeVal">{{ $fontSettings['label_font_size'] ?? 15 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[label_font_size]"
                               min="8" max="32" step="1"
                               value="{{ $fontSettings['label_font_size'] ?? 15 }}"
                               class="w-full accent-green-600"
                               oninput="document.getElementById('labelFontSizeVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>8px</span><span>32px</span>
                        </div>
                    </div>
                    {{-- Label Bold --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Ketebalan</label>
                        <label class="flex items-center gap-3 cursor-pointer mt-3">
                            <input type="checkbox" name="font_settings[label_bold]" value="1"
                                   {{ ($fontSettings['label_bold'] ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                            <span class="text-sm text-gray-700">Tebal (<strong>Bold</strong>)</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ============================
                 SECTION: Nilai/Isi Fields
                 ============================ --}}
            <div class="border-t pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span>
                    Teks Nilai — isi data member (nama, institusi, dll.)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Value Font Size --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Ukuran Font: <strong id="valueFontSizeVal">{{ $fontSettings['value_font_size'] ?? 15 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[value_font_size]"
                               min="8" max="32" step="1"
                               value="{{ $fontSettings['value_font_size'] ?? 15 }}"
                               class="w-full accent-orange-500"
                               oninput="document.getElementById('valueFontSizeVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>8px</span><span>32px</span>
                        </div>
                    </div>
                    {{-- Value Bold --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Ketebalan</label>
                        <label class="flex items-center gap-3 cursor-pointer mt-3">
                            <input type="checkbox" name="font_settings[value_bold]" value="1"
                                   {{ ($fontSettings['value_bold'] ?? false) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                            <span class="text-sm text-gray-700">Tebal (<strong>Bold</strong>)</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ============================
                 SECTION: Layout & Jarak
                 ============================ --}}
            <div class="border-t pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>
                    Layout & Jarak
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Line Spacing --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Jarak Antar Baris: <strong id="lineSpacingVal">{{ $fontSettings['line_spacing'] ?? 32 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[line_spacing]"
                               min="16" max="70" step="2"
                               value="{{ $fontSettings['line_spacing'] ?? 32 }}"
                               class="w-full accent-red-500"
                               oninput="document.getElementById('lineSpacingVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>Rapat (16px)</span><span>Lebar (70px)</span>
                        </div>
                    </div>
                    {{-- Label Width --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Lebar Kolom Label: <strong id="labelWidthVal">{{ $fontSettings['label_width'] ?? 95 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[label_width]"
                               min="50" max="200" step="5"
                               value="{{ $fontSettings['label_width'] ?? 95 }}"
                               class="w-full accent-red-500"
                               oninput="document.getElementById('labelWidthVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>50px</span><span>200px</span>
                        </div>
                    </div>
                    {{-- Label Gap (jarak setelah titik dua) --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Jarak Setelah ":": <strong id="labelGapVal">{{ $fontSettings['label_gap'] ?? 15 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[label_gap]"
                               min="5" max="50" step="1"
                               value="{{ $fontSettings['label_gap'] ?? 15 }}"
                               class="w-full accent-red-500"
                               oninput="document.getElementById('labelGapVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>5px</span><span>50px</span>
                        </div>
                    </div>
                    {{-- Data Start X --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Posisi Data (X): <strong id="dataXVal">{{ $fontSettings['data_start_x'] ?? 380 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[data_start_x]"
                               min="200" max="700" step="5"
                               value="{{ $fontSettings['data_start_x'] ?? 380 }}"
                               class="w-full accent-red-500"
                               oninput="document.getElementById('dataXVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>200px</span><span>700px</span>
                        </div>
                    </div>
                    {{-- Data Start Y --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">
                            Posisi Data (Y): <strong id="dataYVal">{{ $fontSettings['data_start_y'] ?? 310 }}px</strong>
                        </label>
                        <input type="range" name="font_settings[data_start_y]"
                               min="150" max="600" step="5"
                               value="{{ $fontSettings['data_start_y'] ?? 310 }}"
                               class="w-full accent-red-500"
                               oninput="document.getElementById('dataYVal').textContent = this.value + 'px'">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>150px</span><span>600px</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="border-t pt-5">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                    <p class="font-semibold mb-1">💡 Tips Pengaturan</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        <li>Perubahan hanya berlaku saat <strong>Generate Kartu</strong> dilakukan berikutnya</li>
                        <li>Kartu yang sudah dibuat tidak otomatis diperbarui — klik tombol Generate ulang di halaman member</li>
                        <li><strong>Posisi Data (X)</strong> menentukan seberapa jauh dari kiri teks data dimulai (setelah foto)</li>
                        <li><strong>Lebar Kolom Label</strong> menentukan posisi titik dua (:) pemisah label dan nilai</li>
                        <li>Untuk menambah font baru, upload file <code>.ttf</code> ke folder <code>storage/fonts/</code> di server</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function toggleFontPanel() {
    const body    = document.getElementById('fontPanelBody');
    const chevron = document.getElementById('fontPanelChevron');
    const isHidden = body.classList.contains('hidden');
    body.classList.toggle('hidden', !isHidden);
    chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
}

function syncColorPicker(hex) {
    if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
        document.getElementById('fontColorPicker').value = hex;
    }
}

function setColor(hex) {
    document.getElementById('fontColorPicker').value = hex;
    document.getElementById('fontColorHex').value     = hex;
    // Also update the hidden input value via the color picker's name
    const picker = document.querySelector('[name="font_settings[font_color]"]');
    if (picker) picker.value = hex;
}
</script>
