@extends('layouts.admin')

@section('page-title', 'Detail Member')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.members.index') }}" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Detail Member</h3>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap member</p>
        </div>
        <div class="flex items-center space-x-3">
            <x-verified-badge :member="$member" size="lg" />
            @if($member->status == 'pending')
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($member->status == 'active')
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
            @elseif($member->status == 'rejected')
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
            @else
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($member->status) }}</span>
            @endif
        </div>
    </div>

    <!-- Verification Section -->
    <div class="mb-8 p-6 rounded-xl {{ $member->is_verified ? 'bg-green-50 border-2 border-green-200' : 'bg-yellow-50 border-2 border-yellow-200' }}">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    @if($member->is_verified)
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <h4 class="text-xl font-bold text-green-900">Member Terverifikasi</h4>
                    @else
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h4 class="text-xl font-bold text-yellow-900">Member Belum Diverifikasi</h4>
                    @endif
                </div>

                @if($member->is_verified)
                    <p class="text-green-800 mb-2">Member ini telah diverifikasi oleh admin.</p>
                    @if($member->verifier)
                        <p class="text-sm text-green-700">Diverifikasi oleh <strong>{{ $member->verifier->name }}</strong> pada {{ $member->verified_at->format('d F Y H:i') }}</p>
                    @endif
                    @if($member->verification_notes)
                        <div class="mt-3 p-3 bg-white rounded-lg border border-green-200">
                            <p class="text-sm font-semibold text-gray-700 mb-1">Catatan Verifikasi:</p>
                            <p class="text-sm text-gray-600">{{ $member->verification_notes }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-yellow-800">Verifikasi member untuk meningkatkan kredibilitas dan memberikan akses penuh.</p>
                @endif

                @if($member->verification_document)
                    <div class="mt-3">
                        <a href="{{ Storage::url($member->verification_document) }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-white border-2 border-blue-300 rounded-lg text-blue-700 hover:bg-blue-50 transition text-sm font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Dokumen Verifikasi
                        </a>
                    </div>
                @endif
            </div>

            <!-- Verification Actions -->
            <div class="flex flex-col space-y-3">
                @if(!$member->is_verified)
                    <!-- Verify Button -->
                    <button type="button" 
                            onclick="document.getElementById('verifyModal').classList.remove('hidden')"
                            class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center justify-center font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verifikasi Member
                    </button>
                @else
                    <!-- Unverify Button -->
                    <button type="button"
                            onclick="document.getElementById('unverifyModal').classList.remove('hidden')"
                            class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition inline-flex items-center justify-center font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batalkan Verifikasi
                    </button>
                @endif

                <!-- Upload Document Button -->
                <button type="button"
                        onclick="document.getElementById('uploadDocModal').classList.remove('hidden')"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center justify-center font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    {{ $member->verification_document ? 'Ganti' : 'Upload' }} Dokumen
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-lg font-semibold mb-4 text-gray-900">Informasi Pribadi</h4>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm text-gray-600">Nama Lengkap</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-600">Email</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-600">Tipe Keanggotaan</dt>
                    <dd class="text-base font-medium text-gray-900">{{ ucfirst($member->member_type) }}</dd>
                </div>
                @if($member->member_type == 'institution')
                <div>
                    <dt class="text-sm text-gray-600">Nama Institusi</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->institution_name }}</dd>
                </div>
                @endif
                @if($member->position)
                <div>
                    <dt class="text-sm text-gray-600">Jabatan</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->position }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <div>
            <h4 class="text-lg font-semibold mb-4 text-gray-900">Kontak</h4>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm text-gray-600">Telepon</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-600">Alamat</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $member->address }}</dd>
                </div>
                @if($member->website)
                <div>
                    <dt class="text-sm text-gray-600">Website</dt>
                    <dd class="text-base font-medium">
                        <a href="{{ $member->website }}" target="_blank" class="text-[#00629B] hover:underline">
                            {{ $member->website }}
                        </a>
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    @if($member->join_date || $member->expiry_date)
    <div class="mt-8 pt-6 border-t">
        <h4 class="text-lg font-semibold mb-4 text-gray-900">Informasi Keanggotaan</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($member->member_number)
            <div>
                <dt class="text-sm text-gray-600">Nomor Anggota</dt>
                <dd class="text-base font-medium text-gray-900">{{ $member->member_number }}</dd>
            </div>
            @endif
            @if($member->join_date)
            <div>
                <dt class="text-sm text-gray-600">Tanggal Bergabung</dt>
                <dd class="text-base font-medium text-gray-900">{{ $member->join_date->format('d F Y') }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm text-gray-600">Masa Berlaku</dt>
                <dd class="text-base font-medium text-green-700">Seumur Hidup</dd>
            </div>
        </div>
    </div>
    @endif

    <!-- Registration Source -->
    @if($member->registration_id)
    <div class="mt-8 pt-6 border-t">
        <h4 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Sumber Pendaftaran
        </h4>
        <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-700 mb-1">Member ini dibuat dari pendaftaran online</p>
                    <p class="text-xs text-purple-600">Registration ID: <span class="font-mono font-bold">#{{ $member->registration_id }}</span></p>
                    <p class="text-xs text-purple-600 mt-1">Tanggal pendaftaran: {{ $member->created_at->format('d F Y H:i') }}</p>
                </div>
                <a href="{{ route('admin.registrations.show', $member->registration_id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Detail Pendaftaran
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Photo Management Section -->
    <div class="mt-8 pt-6 border-t">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-900">Foto Member</h4>
            @if($member->is_verified)
                <div class="flex space-x-2">
                    @if($member->photo)
                        <!-- Delete Photo Button -->
                        <form method="POST" action="{{ route('admin.members.delete-photo', $member) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                    <!-- Upload/Update Photo Button -->
                    <button type="button" 
                            onclick="document.getElementById('uploadPhotoModal').classList.remove('hidden')"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $member->photo ? 'Ubah Foto' : 'Upload Foto' }}
                    </button>
                </div>
            @endif
        </div>
        
        <div class="flex items-start space-x-6">
            <!-- Photo Preview -->
            <div class="flex-shrink-0">
                @if($member->photo)
                    <img src="{{ Storage::url($member->photo) }}" 
                         alt="Foto {{ $member->user->name }}" 
                         class="w-40 h-48 object-cover rounded-lg shadow-md border-2 border-gray-200">
                @else
                    <div class="w-40 h-48 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-gray-200">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                @if(!$member->is_verified)
                    <!-- Member Not Verified Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-yellow-800">Member belum divalidasi</p>
                                <p class="text-sm text-yellow-700 mt-1">Admin hanya dapat mengedit foto setelah member divalidasi. Silakan verifikasi member terlebih dahulu.</p>
                            </div>
                        </div>
                    </div>
                @elseif($member->photo)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-green-800">Foto sudah di-upload</p>
                                <p class="text-sm text-green-700 mt-1">Admin dapat mengubah atau menghapus foto member yang sudah divalidasi.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-800">Foto belum di-upload</p>
                                <p class="text-sm text-blue-700 mt-1">Admin dapat menambahkan foto untuk member yang sudah divalidasi.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upload Photo Modal -->
    <div id="uploadPhotoModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $member->photo ? 'Ubah Foto Member' : 'Upload Foto Member' }}
                </h3>
                <button type="button" 
                        onclick="document.getElementById('uploadPhotoModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.members.upload-photo', $member) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Foto
                    </label>
                    <input type="file" 
                           name="photo" 
                           accept="image/jpeg,image/jpg,image/png"
                           required
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button"
                            onclick="document.getElementById('uploadPhotoModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Member Card Section -->
    <div class="mt-8 pt-6 border-t">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-900">Kartu Anggota</h4>
            <div class="flex space-x-2">
                <form method="POST" action="{{ route('admin.members.generate-card', $member) }}">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ $member->member_card ? 'Generate Ulang' : 'Generate Kartu' }}
                    </button>
                </form>
            </div>
        </div>
        
        @if($member->member_card)
        <div class="bg-gray-50 rounded-lg p-6">
            @if($member->card_generated_at)
            <div class="mb-3 flex items-center text-sm text-gray-600">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Di-generate otomatis pada {{ $member->card_generated_at->format('d F Y H:i') }}</span>
            </div>
            @endif
            
            @if(Str::endsWith($member->member_card, '.pdf'))
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">Kartu Anggota (PDF)</p>
                    <p class="text-sm text-gray-600 mt-1">File PDF tersimpan</p>
                </div>
                <a href="{{ asset('storage/' . $member->member_card) }}" 
                   target="_blank"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Lihat PDF
                </a>
            </div>
            @else
            <div class="text-center">
                <img src="{{ asset('storage/' . $member->member_card) }}" 
                     alt="Member Card" 
                     class="max-w-2xl mx-auto rounded-lg shadow-lg">
                <div class="mt-4">
                    <a href="{{ asset('storage/' . $member->member_card) }}" 
                       target="_blank"
                       class="text-purple-600 hover:text-purple-700 font-semibold">
                        Lihat Full Size →
                    </a>
                </div>
            </div>
            @endif
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <svg class="w-16 h-16 mx-auto text-yellow-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="text-gray-700 font-semibold">Belum ada kartu anggota</p>
            <p class="text-sm text-gray-600 mt-1 mb-4">Klik tombol "Generate Kartu" untuk membuat kartu otomatis atau "Upload Manual" untuk upload sendiri</p>
            
            @php
                $activeTemplate = \App\Models\MemberCardTemplate::getActive();
            @endphp
            
            @if(!$activeTemplate)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-sm text-red-700">
                    ⚠️ Belum ada template kartu aktif. 
                    <a href="{{ route('admin.card-templates.index') }}" class="underline font-semibold">
                        Upload template terlebih dahulu
                    </a>
                </p>
            </div>
            @endif
        </div>
        @endif
    </div>

    @if($member->status == 'pending')
    <div class="mt-8 pt-6 border-t flex space-x-4">
        <form method="POST" action="{{ route('admin.members.approve', $member) }}">
            @csrf
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Approve Member
            </button>
        </form>
        
        <form method="POST" action="{{ route('admin.members.reject', $member) }}">
            @csrf
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Reject Member
            </button>
        </form>
    </div>
    @endif
</div>

<!-- Verify Modal -->
<div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Verifikasi Member</h3>
            <button onclick="document.getElementById('verifyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.members.verify', $member) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi (Opsional)</label>
                <textarea name="verification_notes" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="document.getElementById('verifyModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Unverify Modal -->
<div id="unverifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Batalkan Verifikasi</h3>
            <button onclick="document.getElementById('unverifyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.members.unverify', $member) }}">
            @csrf
            <div class="mb-4">
                <p class="text-gray-700 mb-3">Apakah Anda yakin ingin membatalkan verifikasi member ini?</p>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan (Opsional)</label>
                <textarea name="verification_notes" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                          placeholder="Tambahkan alasan jika diperlukan..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="document.getElementById('unverifyModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Batalkan Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Upload Document Modal -->
<div id="uploadDocModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Upload Dokumen Verifikasi</h3>
            <button onclick="document.getElementById('uploadDocModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.members.upload-verification-document', $member) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen (PDF, JPG, PNG)</label>
                <input type="file" name="verification_document" accept=".pdf,.jpg,.jpeg,.png" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="document.getElementById('uploadDocModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
