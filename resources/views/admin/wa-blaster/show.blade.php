@extends('layouts.admin')

@section('page-title', 'Detail Blast WA')

@section('content')
<div class="max-w-4xl">

    @if(session('success'))
    <div class="mb-5 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="mb-5">
        <a href="{{ route('admin.wa-blaster.index') }}" class="text-sm text-gray-500 hover:text-green-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke WA Blaster
        </a>
    </div>

    {{-- Summary Card --}}
    <div class="bg-white rounded-xl shadow-sm mb-5">
        <div class="p-5 border-b flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $log->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Dikirim oleh <strong>{{ $log->sender?->name ?? 'System' }}</strong>
                    · {{ $log->sent_at?->format('d M Y, H:i') ?? $log->created_at->format('d M Y, H:i') }}
                </p>
            </div>
            @php $c = $log->status_color @endphp
            <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
                {{ $log->status_label }}
            </span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100">
            <div class="p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $log->total_recipients }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Penerima</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $log->success_count }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Berhasil</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-2xl font-bold {{ $log->failed_count > 0 ? 'text-red-500' : 'text-gray-400' }}">{{ $log->failed_count }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Gagal</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $log->success_rate }}%</p>
                <p class="text-xs text-gray-500 mt-0.5">Success Rate</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Pesan --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 border-b"><h2 class="font-semibold text-gray-900">Isi Pesan</h2></div>
            <div class="p-4">
                <div class="bg-green-50 rounded-xl p-4 font-mono text-sm text-gray-800 whitespace-pre-wrap leading-relaxed border border-green-100">{{ $log->message }}</div>
                <div class="mt-3 flex gap-3 text-xs text-gray-500">
                    <span>Filter: <strong>{{ $log->recipient_filter }}</strong></span>
                    <span>Gateway: <strong>{{ $log->gateway }}</strong></span>
                </div>
            </div>
        </div>

        {{-- Nomor Gagal --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 border-b"><h2 class="font-semibold text-gray-900">Nomor Gagal</h2></div>
            <div class="p-4">
                @if($log->gateway === 'manual')
                    <p class="text-sm text-gray-500 italic">Mode manual — tidak ada tracking otomatis.</p>
                @elseif(empty($log->failed_numbers))
                    <div class="text-center py-6 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">Semua pesan berhasil terkirim</p>
                    </div>
                @else
                    <div class="space-y-1 max-h-64 overflow-y-auto">
                        @foreach($log->failed_numbers as $num)
                        <div class="flex items-center justify-between text-sm py-1.5 border-b border-gray-50">
                            <span class="font-mono text-gray-700">{{ $num }}</span>
                            <a href="https://wa.me/{{ $num }}" target="_blank"
                               class="text-xs text-green-600 hover:underline">Coba Manual</a>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ count($log->failed_numbers) }} nomor gagal</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Manual Mode: Link WA --}}
    @if($log->gateway === 'manual' && session('manual_numbers'))
    <div class="mt-5 bg-white rounded-xl shadow-sm">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Link WhatsApp Manual</h2>
            <button onclick="copyAll()" class="text-xs px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                Salin Semua Nomor
            </button>
        </div>
        <div class="p-4 space-y-2 max-h-96 overflow-y-auto" id="manualLinks">
            @foreach(session('manual_numbers') as $item)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                <div>
                    <span class="font-medium text-gray-800">{{ $item['name'] }}</span>
                    <span class="text-gray-400 ml-2 font-mono text-xs">{{ $item['phone'] }}</span>
                </div>
                <a href="{{ $item['wa_link'] }}" target="_blank"
                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Kirim WA
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <script>
    function copyAll() {
        const numbers = @json(collect(session('manual_numbers'))->pluck('phone')->toArray());
        navigator.clipboard.writeText(numbers.join('\n')).then(() => alert('Semua nomor tersalin!'));
    }
    </script>
    @endif

</div>
@endsection
