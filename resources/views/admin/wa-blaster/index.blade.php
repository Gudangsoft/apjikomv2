@extends('layouts.admin')

@section('page-title', 'WA Blaster')

@section('content')
<div class="max-w-6xl space-y-6">

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- STATS --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalSent) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Pesan Terkirim</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <p class="text-3xl font-bold text-gray-900">{{ $totalBlast }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Blast Dilakukan</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
            <p class="text-3xl font-bold text-gray-900">
                {{ \App\Models\Member::where('status','active')->whereNotNull('phone')->where('phone','!=','')->count() }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Anggota Aktif Punya HP</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORM BLAST --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-5 border-b">
                    <h2 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Kirim Pesan WhatsApp
                    </h2>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.wa-blaster.send') }}" method="POST" id="blastForm">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Blast <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   placeholder="Contoh: Undangan Rapat Anggota Mei 2026"
                                   class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>

                        {{-- Filter Penerima --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penerima <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-2" id="filterButtons">
                                @foreach([
                                    'active'   => ['Anggota Aktif', 'green'],
                                    'all'      => ['Semua Anggota', 'blue'],
                                    'individu' => ['Anggota Individu', 'purple'],
                                    'prodi'    => ['Anggota Prodi', 'orange'],
                                    'inactive' => ['Anggota Non-Aktif', 'gray'],
                                ] as $val => [$label, $color])
                                <button type="button" data-filter="{{ $val }}"
                                        onclick="selectFilter(this)"
                                        class="filter-btn px-3 py-1.5 text-sm font-medium rounded-full border transition-all
                                               {{ $val === 'active' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-300 hover:border-green-400' }}">
                                    {{ $label }}
                                </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="filter" id="filterInput" value="active">

                            {{-- Preview penerima --}}
                            <div id="recipientPreview" class="mt-3 p-3 bg-gray-50 rounded-lg text-sm hidden">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold text-gray-700">Preview Penerima:</span>
                                    <span id="recipientCount" class="text-green-700 font-bold"></span>
                                </div>
                                <div id="recipientList" class="space-y-1 text-gray-600"></div>
                                <p id="noPhoneWarning" class="mt-2 text-xs text-orange-600 hidden"></p>
                            </div>
                        </div>

                        {{-- Pesan --}}
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-sm font-semibold text-gray-700">Pesan <span class="text-red-500">*</span></label>
                                <span id="charCount" class="text-xs text-gray-400">0 / 4000</span>
                            </div>
                            <textarea name="message" id="messageInput" rows="7" required maxlength="4000"
                                      oninput="updateCharCount()"
                                      placeholder="Ketik pesan di sini..."
                                      class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono resize-y">{{ old('message') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">
                                *Format: <strong>*teks bold*</strong>, _italic_, ~strikethrough~
                            </p>
                        </div>

                        {{-- Variabel shortcut --}}
                        <div class="mb-5">
                            <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Sisipkan Variabel</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(\App\Http\Controllers\Admin\WaBlasterController::VARIABLES as $var => $desc)
                                <button type="button" onclick="insertVar('{{ $var }}')" title="{{ $desc }}"
                                        class="px-2.5 py-1 text-xs bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded font-mono transition-colors">
                                    {{ $var }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Gateway --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Metode Pengiriman</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-green-400 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="gateway" value="fonnte" checked class="text-green-600">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">API Gateway (Fonnte)</p>
                                        <p class="text-xs text-gray-500">Kirim otomatis via Fonnte API</p>
                                    </div>
                                </label>
                                <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-blue-400 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="gateway" value="manual" class="text-blue-600">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Manual (Link WA)</p>
                                        <p class="text-xs text-gray-500">Generate link wa.me untuk kirim manual</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" id="sendBtn"
                                class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Kirim Blast WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- SIDEBAR: Config + Tips --}}
        <div class="space-y-5">

            {{-- Konfigurasi Gateway --}}
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Konfigurasi Gateway</h3>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $gatewayToken ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $gatewayToken ? 'Terkonfigurasi' : 'Belum diatur' }}
                    </span>
                </div>
                <div class="p-4">
                    <form action="{{ route('admin.wa-blaster.save-settings') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">API Token <span class="text-red-500">*</span></label>
                            <input type="text" name="wa_gateway_token" value="{{ $gatewayToken }}"
                                   placeholder="Token dari Fonnte / gateway lain"
                                   class="w-full text-xs border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Endpoint URL</label>
                            <input type="url" name="wa_gateway_url" value="{{ $gatewayUrl }}"
                                   placeholder="https://api.fonnte.com/send"
                                   class="w-full text-xs border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono">
                            <p class="text-xs text-gray-400 mt-0.5">Default: api.fonnte.com</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Device ID <span class="text-gray-400">(opsional)</span></label>
                            <input type="text" name="wa_gateway_device" value="{{ $gatewayDevice }}"
                                   placeholder="ID device jika multi-device"
                                   class="w-full text-xs border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono">
                        </div>
                        <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors">
                            Simpan Konfigurasi
                        </button>
                    </form>
                </div>
            </div>

            {{-- Panduan --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-xs font-bold text-amber-800 mb-2">📱 Cara Setup Fonnte</p>
                <ol class="text-xs text-amber-700 space-y-1 list-decimal list-inside">
                    <li>Daftar di <strong>fonnte.com</strong></li>
                    <li>Scan QR dengan WA yang akan dipakai</li>
                    <li>Copy API Token dari dashboard</li>
                    <li>Paste di kolom API Token di atas</li>
                    <li>Simpan & langsung bisa digunakan</li>
                </ol>
                <p class="text-xs text-amber-600 mt-2 font-medium">⚠️ Pastikan WA gateway aktif & terkoneksi sebelum blast.</p>
            </div>

            {{-- Tips Pesan --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <p class="text-xs font-bold text-blue-800 mb-2">💡 Tips Pesan Efektif</p>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Sapa personal dengan <code class="bg-blue-100 px-1 rounded">{nama}</code></li>
                    <li>• Maksimal 1-3 poin penting</li>
                    <li>• Sertakan link atau nomor kontak</li>
                    <li>• Hindari kata spam (promo, gratis, klik)</li>
                    <li>• Test dulu ke 1 nomor sebelum blast massal</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- RIWAYAT BLAST --}}
    @if($recentLogs->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-5 border-b flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Riwayat Blast</h2>
            <span class="text-xs text-gray-500">10 terakhir</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Judul</th>
                        <th class="px-4 py-3 text-left">Filter</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Berhasil</th>
                        <th class="px-4 py-3 text-center">Gagal</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Waktu</th>
                        <th class="px-3 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentLogs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="font-medium text-gray-800 max-w-xs truncate">{{ $log->title }}</div>
                            <div class="text-xs text-gray-400">{{ $log->gateway }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700">{{ $log->recipient_filter }}</span>
                        </td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-700">{{ $log->total_recipients }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-green-600">{{ $log->success_count }}</td>
                        <td class="px-4 py-3 text-center font-semibold {{ $log->failed_count > 0 ? 'text-red-500' : 'text-gray-400' }}">{{ $log->failed_count }}</td>
                        <td class="px-4 py-3">
                            @php $c = $log->status_color @endphp
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
                                {{ $log->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            {{ $log->sent_at?->format('d M Y H:i') ?? $log->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-3 py-3">
                            <div class="flex gap-1">
                                <a href="{{ route('admin.wa-blaster.show', $log) }}"
                                   class="p-1.5 text-blue-500 hover:bg-blue-50 rounded transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form action="{{ route('admin.wa-blaster.destroy', $log) }}" method="POST"
                                      onsubmit="return confirm('Hapus log blast ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-400 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script>
let currentFilter = 'active';

function selectFilter(btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.className = b.className.replace(/bg-\w+-600 text-white border-\w+-600/, '');
        b.classList.add('bg-white', 'text-gray-600', 'border-gray-300');
    });
    btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-300');
    btn.classList.add('bg-green-600', 'text-white', 'border-green-600');

    currentFilter = btn.dataset.filter;
    document.getElementById('filterInput').value = currentFilter;
    loadRecipientPreview(currentFilter);
}

function loadRecipientPreview(filter) {
    const preview = document.getElementById('recipientPreview');
    preview.classList.remove('hidden');
    document.getElementById('recipientCount').textContent = 'Memuat...';
    document.getElementById('recipientList').innerHTML = '';

    fetch('{{ route("admin.wa-blaster.preview") }}?filter=' + filter)
        .then(r => r.json())
        .then(data => {
            document.getElementById('recipientCount').textContent = data.count + ' penerima';
            const list = document.getElementById('recipientList');
            list.innerHTML = data.sample.map(m =>
                `<div class="flex items-center gap-2 text-xs">
                    <span class="font-medium text-gray-700">${m.name}</span>
                    <span class="text-gray-400">${m.phone}</span>
                    <span class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-500">${m.type}</span>
                </div>`
            ).join('');
            if (data.count > 5) {
                list.innerHTML += `<p class="text-xs text-gray-400 mt-1">...dan ${data.count - 5} lainnya</p>`;
            }
            const warn = document.getElementById('noPhoneWarning');
            if (data.no_phone > 0) {
                warn.textContent = `⚠️ ${data.no_phone} anggota tidak punya nomor HP dan akan dilewati.`;
                warn.classList.remove('hidden');
            } else {
                warn.classList.add('hidden');
            }
        })
        .catch(() => {
            document.getElementById('recipientCount').textContent = 'Gagal memuat';
        });
}

function insertVar(v) {
    const ta = document.getElementById('messageInput');
    const start = ta.selectionStart;
    const end = ta.selectionEnd;
    ta.value = ta.value.substring(0, start) + v + ta.value.substring(end);
    ta.selectionStart = ta.selectionEnd = start + v.length;
    ta.focus();
    updateCharCount();
}

function updateCharCount() {
    const len = document.getElementById('messageInput').value.length;
    document.getElementById('charCount').textContent = len + ' / 4000';
}

// Load preview on page load
document.addEventListener('DOMContentLoaded', () => {
    loadRecipientPreview('active');
    updateCharCount();

    // Confirm before send
    document.getElementById('blastForm').addEventListener('submit', function(e) {
        const count = document.getElementById('recipientCount').textContent;
        if (!confirm(`Kirim blast WA ke ${count}?\n\nPastikan pesan sudah benar sebelum melanjutkan.`)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
