@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-lg mx-auto px-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Cek Status Pendaftaran</h1>
            <p class="text-gray-500 mt-2">Masukkan email yang Anda gunakan saat mendaftar</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <form method="POST" action="{{ route('registration.status.check') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('email') border-red-400 @enderror"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-[#00629B] hover:bg-[#005280] text-white font-semibold py-2.5 rounded-lg transition-colors text-sm">
                    Cek Status
                </button>
            </form>
        </div>

        {{-- Result --}}
        @isset($registration)
        <div class="mt-6 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Hasil Pencarian</h2>

            @if($registration->status === 'approved')
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg mb-4">
                    <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-green-800">Pendaftaran Disetujui</p>
                        <p class="text-sm text-green-600">Akun Anda sudah aktif. Silakan login ke dashboard member.</p>
                    </div>
                </div>
            @elseif($registration->status === 'pending')
                <div class="flex items-center gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-4">
                    <svg class="w-8 h-8 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-yellow-800">Menunggu Verifikasi</p>
                        <p class="text-sm text-yellow-600">Pendaftaran Anda sedang ditinjau oleh admin. Harap bersabar.</p>
                    </div>
                </div>
            @elseif($registration->status === 'rejected')
                <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-lg mb-4">
                    <svg class="w-8 h-8 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-red-800">Pendaftaran Ditolak</p>
                        @if($registration->notes)
                            <p class="text-sm text-red-600">Alasan: {{ $registration->notes }}</p>
                        @else
                            <p class="text-sm text-red-600">Pendaftaran Anda tidak dapat disetujui. Hubungi admin untuk informasi lebih lanjut.</p>
                        @endif
                    </div>
                </div>
            @endif

            <dl class="space-y-2 text-sm">
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Nama</dt>
                    <dd class="font-medium text-gray-800">{{ $registration->full_name }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium text-gray-800">{{ $registration->email }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Tipe Pendaftaran</dt>
                    <dd class="font-medium text-gray-800">{{ $registration->type === 'prodi' ? 'Program Studi / Institusi' : 'Perorangan' }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Tanggal Daftar</dt>
                    <dd class="font-medium text-gray-800">{{ $registration->created_at->format('d F Y') }}</dd>
                </div>
                @if($member)
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">No Anggota</dt>
                    <dd class="font-medium text-gray-800">{{ $member->member_number }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Masa Berlaku</dt>
                    <dd class="font-medium text-gray-800">s/d {{ $member->expiry_date?->format('d F Y') }}</dd>
                </div>
                @endif
            </dl>

            @if($registration->status === 'approved')
            <div class="mt-5">
                <a href="{{ route('member.login') }}"
                    class="block text-center bg-[#00629B] hover:bg-[#005280] text-white font-semibold py-2.5 rounded-lg transition-colors text-sm">
                    Login ke Dashboard Member
                </a>
            </div>
            @endif
        </div>
        @elseif(isset($email) && !isset($registration))
        <div class="mt-6 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <svg class="w-8 h-8 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-gray-700">Data Tidak Ditemukan</p>
                    <p class="text-sm text-gray-500">Email <strong>{{ $email }}</strong> tidak terdaftar. Pastikan email sesuai dengan yang digunakan saat mendaftar.</p>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('registration.create') }}" class="text-sm text-[#00629B] hover:underline">Daftar sebagai anggota baru</a>
            </div>
        </div>
        @endisset
    </div>
</div>
@endsection
