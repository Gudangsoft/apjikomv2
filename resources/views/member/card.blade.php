@extends('layouts.member')

@section('title', 'Kartu Anggota')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl card-shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Kartu Anggota</h2>
                <p class="text-gray-600 mt-1">Download dan cetak kartu anggota Anda</p>
            </div>
            <a href="{{ route('member.dashboard') }}" 
               class="text-purple-600 hover:text-purple-800 font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if($member->member_card)
    <!-- Card Display -->
    <div class="bg-white rounded-xl card-shadow p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Card Image -->
            <div class="mb-8">
                <img src="{{ Storage::url($member->member_card) }}" 
                     alt="Kartu Anggota {{ Auth::user()->name }}" 
                     class="w-full rounded-xl shadow-2xl">
            </div>

            <!-- Card Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Kartu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Anggota</p>
                        <p class="font-semibold text-gray-900">{{ $member->member_number ?? 'Belum ada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Masa Berlaku</p>
                        <p class="font-semibold text-green-700">Seumur Hidup</p>
                    </div>
                    @if($member->card_generated_at)
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pembuatan</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($member->card_generated_at)->format('d F Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ Storage::url($member->member_card) }}" 
                   download="Kartu_Anggota_{{ $member->member_number }}.png"
                   class="inline-flex items-center justify-center px-8 py-4 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Kartu (PNG)
                </a>

                <button onclick="window.print()" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Kartu
                </button>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Petunjuk Penggunaan
                </h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>• Simpan kartu dalam format digital di perangkat Anda</li>
                    <li>• Untuk mencetak, gunakan kertas berkualitas baik ukuran A4</li>
                    <li>• Kartu dapat dilaminasi untuk keawetan lebih baik</li>
                    <li>• Tunjukkan kartu ini saat mengikuti kegiatan APJIKOM</li>
                    <li>• Jika kartu hilang atau rusak, hubungi admin untuk penerbitan ulang</li>
                </ul>
            </div>
        </div>
    </div>
    @else
    <!-- No Card -->
    <div class="bg-white rounded-xl card-shadow p-12 text-center">
        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Kartu Belum Tersedia</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            @if(!Auth::user()->member->photo || !Auth::user()->member->address || !Auth::user()->member->phone)
                Silakan lengkapi profil Anda (foto, alamat, dan telepon) terlebih dahulu, kemudian request kartu anggota melalui halaman profil.
            @elseif(!Auth::user()->member->card_requested)
                Kartu anggota belum di-request. Silakan klik tombol "Request Kartu Anggota" di halaman profil Anda.
            @else
                Permintaan kartu Anda sedang diproses oleh admin. Mohon tunggu beberapa saat.
            @endif
        </p>
        <div class="flex gap-3 justify-center">
            @if(!Auth::user()->member->photo || !Auth::user()->member->address || !Auth::user()->member->phone || !Auth::user()->member->card_requested)
                <a href="{{ route('member.profile') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    📋 Lengkapi Profil & Request Kartu
                </a>
            @endif
            <a href="{{ route('member.dashboard') }}" 
               class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
    @endif
</div>

<style>
@media print {
    nav, aside, button, .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    main {
        padding: 0 !important;
    }
    
    .card-shadow {
        box-shadow: none !important;
    }
}
</style>
@endsection
