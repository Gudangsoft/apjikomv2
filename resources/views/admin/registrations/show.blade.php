@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.registrations.index') }}" class="text-purple-600 hover:text-purple-700 text-sm mb-2 inline-block">
                ← Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pendaftaran #{{ $registration->id }}</h1>
        </div>
        <div>
            @if($registration->status == 'pending')
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif($registration->status == 'approved')
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    Approved
                </span>
            @else
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                    Rejected
                </span>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($registration->status === 'approved' && isset($existingMember) && $existingMember)
    <div class="bg-green-50 border border-green-200 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-medium text-green-800">Pendaftaran ini sudah dikonversi menjadi Member!</p>
                <p class="text-sm text-green-700 mt-1">
                    Member Number: <strong>{{ $existingMember->member_number }}</strong> 
                    <a href="{{ route('admin.members.show', $existingMember->id) }}" 
                       class="ml-2 underline hover:text-green-900">
                        Lihat Detail Member →
                    </a>
                </p>
            </div>
        </div>
    </div>
    @elseif($registration->status === 'approved' && (!isset($existingMember) || !$existingMember))
    <div class="bg-yellow-50 border border-yellow-200 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-medium text-yellow-800">Pendaftaran disetujui tapi belum jadi Member</p>
                <p class="text-sm text-yellow-700 mt-1">
                    Klik "Update Status" di samping untuk membuat member otomatis saat approve.
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tipe Keanggotaan</label>
                            <p class="text-gray-900 mt-1">
                                @if($registration->type == 'individu')
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                        Individu
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800">
                                        Program Studi
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Pendaftaran</label>
                            <p class="text-gray-900 mt-1">{{ $registration->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="text-gray-900 mt-1">{{ $registration->full_name }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-900 mt-1">{{ $registration->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nomor Handphone</label>
                            <p class="text-gray-900 mt-1">{{ $registration->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prodi Specific Info -->
            @if($registration->type == 'prodi')
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Program Studi</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Institusi</label>
                        <p class="text-gray-900 mt-1">{{ $registration->institution }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Program Studi</label>
                        <p class="text-gray-900 mt-1">{{ $registration->study_program }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Akreditasi</label>
                            <p class="text-gray-900 mt-1">{{ $registration->accreditation }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Berlaku Hingga</label>
                            <p class="text-gray-900 mt-1">{{ $registration->accreditation_valid_until->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Provinsi</label>
                        <p class="text-gray-900 mt-1">{{ $registration->province }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Files -->
            @if($registration->type == 'prodi' && $registration->authorization_letter)
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Dokumen</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <!-- Authorization Letter (Prodi only) -->
                    @if($registration->type == 'prodi' && $registration->authorization_letter)
                    <div>
                        <label class="text-sm font-medium text-gray-500 mb-2 block">Surat Kuasa</label>
                        @php
                            $extension = pathinfo($registration->authorization_letter, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'bmp']))
                            <img src="{{ asset('storage/' . $registration->authorization_letter) }}" 
                                 alt="Surat Kuasa" 
                                 class="max-w-md rounded border">
                        @else
                            <div class="flex items-center p-3 bg-gray-50 rounded border max-w-md">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">File Dokumen</p>
                                    <p class="text-xs text-gray-500">{{ basename($registration->authorization_letter) }}</p>
                                </div>
                            </div>
                        @endif
                        <a href="{{ asset('storage/' . $registration->authorization_letter) }}" 
                           target="_blank"
                           class="inline-block mt-2 text-purple-600 hover:text-purple-700 text-sm font-medium">
                            Lihat/Download File →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Update Status</h2>
                </div>
                <form method="POST" action="{{ route('admin.registrations.update-status', $registration->id) }}" class="px-6 py-4">
                    @csrf
                    @method('PUT')
                    
                    <!-- Info Box -->
                    @if($registration->status !== 'approved')
                    <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Approve Otomatis:</p>
                                <ul class="list-disc list-inside space-y-0.5 text-xs">
                                    <li>Membuat akun member baru</li>
                                    <li>Generate kartu anggota otomatis</li>
                                    <li>Password default: <strong>password123</strong></li>
                                    <li>Member bisa langsung login</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" required
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $registration->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <!-- Show in Directory Option (only when approved AND verified) -->
                        @if($registration->status == 'approved' && isset($existingMember) && $existingMember && $existingMember->is_verified)
                        <div id="directory-option">
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" name="show_in_directory" value="1" 
                                           {{ (isset($existingMember) && $existingMember && $existingMember->show_in_directory) ? 'checked' : '' }}
                                           class="mt-1 h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <div class="ml-3">
                                        <span class="flex items-center text-sm font-semibold text-gray-900">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Tampilkan profil saya di direktori anggota
                                        </span>
                                        <p class="text-xs text-gray-600 mt-1">
                                            Centang untuk menampilkan profil Anda di 
                                            <a href="{{ route('member-directory.index') }}" target="_blank" class="text-blue-600 hover:underline">halaman direktori anggota</a>. 
                                            Jika tidak dicentang, profil Anda tidak akan tampil dan data tidak dapat dilihat oleh anggota lain.
                                        </p>
                                        @if(isset($existingMember) && $existingMember && $existingMember->show_in_directory)
                                        <div class="mt-2 flex items-center text-xs text-green-700 bg-green-50 px-2 py-1 rounded">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Status: Tampil di Direktori
                                        </div>
                                        @endif
                                    </div>
                                </label>
                            </div>
                        </div>
                        @elseif($registration->status == 'approved' && isset($existingMember) && $existingMember && !$existingMember->is_verified)
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Member Belum Terverifikasi</p>
                                    <p class="text-xs">Opsi "Tampilkan di Direktori" akan muncul setelah member diverifikasi oleh admin. 
                                    <a href="{{ route('admin.members.show', $existingMember->id) }}" class="underline hover:text-yellow-900">Verifikasi Member →</a></p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="notes" rows="4" 
                                      placeholder="Tambahkan catatan (opsional)"
                                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">{{ $registration->notes }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 font-medium">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete -->
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Hapus Pendaftaran</h2>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-600 mb-4">Aksi ini tidak dapat dibatalkan. Data pendaftaran dan file akan dihapus permanen.</p>
                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium">
                            Hapus Pendaftaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 p-4">
                <h3 class="font-semibold text-blue-900 mb-2 flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Info Kontak
                </h3>
                <div class="space-y-1 text-xs text-gray-700">
                    <p><span class="font-medium">Email:</span> {{ $registration->email }}</p>
                    <p><span class="font-medium">Phone:</span> {{ $registration->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
