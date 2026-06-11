@extends('layouts.admin')

@section('page-title', 'Kirim Email Massal')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800">Kirim Email Massal ke Anggota</h1>
    <p class="text-sm text-gray-500 mt-1">Kirim email langsung ke seluruh atau sebagian anggota aktif.</p>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg text-sm text-green-800">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('admin.bulk-email.send') }}">
                @csrf

                {{-- Recipients --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penerima</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recipients" value="active" checked
                                class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Anggota Aktif saja
                                <span class="text-xs text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded ml-1">{{ $activeCount }}</span>
                            </span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recipients" value="all"
                                class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Semua Anggota
                                <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded ml-1">{{ $allMemberCount }}</span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Subject --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Subjek Email <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('subject') border-red-400 @enderror"
                        placeholder="Contoh: Informasi Penting untuk Anggota APJIKOM" required>
                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Body --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Email <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400 mb-1">HTML diperbolehkan (misal: &lt;b&gt;tebal&lt;/b&gt;, &lt;a href="..."&gt;tautan&lt;/a&gt;)</p>
                    <textarea name="body" rows="10"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('body') border-red-400 @enderror"
                        placeholder="<p>Yth. Anggota APJIKOM,</p>&#10;<p>...</p>" required>{{ old('body') }}</textarea>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        onclick="return confirm('Yakin ingin mengirim email ke semua penerima yang dipilih?')"
                        class="bg-[#00629B] hover:bg-[#005280] text-white font-semibold px-6 py-2.5 rounded-lg transition-colors text-sm">
                        Kirim Email
                    </button>
                    <span class="text-xs text-gray-400">Proses pengiriman mungkin memakan beberapa saat.</span>
                </div>
            </form>
        </div>
    </div>

    {{-- Sidebar --}}
    <div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-2">Informasi</h3>
            <ul class="text-xs text-blue-700 space-y-1.5">
                <li>• Anggota aktif: <strong>{{ $activeCount }}</strong></li>
                <li>• Total anggota: <strong>{{ $allMemberCount }}</strong></li>
                <li>• Email dikirim menggunakan konfigurasi SMTP di pengaturan</li>
                <li>• Pastikan server email sudah dikonfigurasi dengan benar</li>
                <li>• Untuk pengiriman besar, disarankan mengaktifkan queue worker</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <h3 class="text-sm font-semibold text-yellow-800 mb-2">Peringatan</h3>
            <p class="text-xs text-yellow-700">Pastikan isi email sudah benar sebelum mengirim. Email yang sudah terkirim tidak dapat ditarik kembali.</p>
        </div>
    </div>
</div>

{{-- History --}}
@if($recentLogs->count() > 0)
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-base font-semibold text-gray-800 mb-4">Riwayat Pengiriman</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500">Waktu</th>
                    <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500">Admin</th>
                    <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentLogs as $log)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-2 px-3 text-xs text-gray-500 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-3 text-xs text-gray-700">{{ $log->user->name ?? '-' }}</td>
                    <td class="py-2 px-3 text-xs text-gray-600">{{ $log->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
