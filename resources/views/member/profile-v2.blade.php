@extends('layouts.member')

@section('title', 'Profil Saya')

@section('content')
<div class='max-w-7xl mx-auto px-4 py-6'>
    <!-- Profile Incomplete Warning -->
    @php
        $needsUpdate = false;
        $missingItems = [];
        if (!$member->photo) {
            $needsUpdate = true;
            $missingItems[] = 'Foto profil untuk KTA';
        }
        if (!$member->address || strlen($member->address) < 10) {
            $needsUpdate = true;
            $missingItems[] = 'Alamat lengkap';
        }
        if (!$member->phone) {
            $needsUpdate = true;
            $missingItems[] = 'Nomor telepon';
        }

    // Ambil permintaan reset password terakhir
    $lastResetRequest = \App\Models\PasswordResetRequest::where('user_id', Auth::id())->latest()->first();
    @endphp

    @if($needsUpdate)
    <div class='bg-orange-50 border-l-4 border-orange-500 rounded-lg p-4 mb-6 shadow-sm'>
        <div class='flex items-start'>
            <svg class='w-6 h-6 text-orange-500 mr-3 flex-shrink-0' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>
            </svg>
            <div class='flex-1'>
                <h3 class='text-sm font-semibold text-orange-800 mb-1'>
                    ⚠️ Profil Belum Lengkap
                </h3>
                <p class='text-sm text-orange-700 mb-2'>
                    Lengkapi data berikut untuk pembuatan Kartu Tanda Anggota (KTA):
                </p>
                <ul class='list-disc list-inside text-sm text-orange-700 space-y-1 ml-2'>
                    @foreach($missingItems as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    @if(session('profile_complete'))
    <div class='bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm'>
        <div class='flex items-start'>
            <svg class='w-6 h-6 text-green-500 mr-3 flex-shrink-0' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
            </svg>
            <div class='flex-1'>
                <h3 class='text-sm font-semibold text-green-800 mb-1'>
                    ✅ Profil Sudah Lengkap!
                </h3>
                <p class='text-sm text-green-700 mb-2'>
                    Terima kasih telah melengkapi profil Anda. Data Anda akan segera diproses oleh admin untuk pembuatan Kartu Tanda Anggota (KTA).
                </p>
                <div class='bg-green-100 border border-green-200 rounded-lg p-3 mt-3'>
                    <p class='text-sm text-green-800 font-medium mb-1'>📋 Langkah Selanjutnya:</p>
                    <ol class='list-decimal list-inside text-sm text-green-700 space-y-1 ml-2'>
                        <li>Admin akan mereview data Anda</li>
                        <li>Kartu Anggota (KTA) akan di-generate otomatis</li>
                        <li>Anda akan mendapat notifikasi jika kartu sudah siap</li>
                        <li>Kartu dapat diakses di menu "Kartu Anggota"</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class='bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-4 animate-fade-in'>
        <div class='flex items-center'>
            <svg class='w-5 h-5 text-green-500 mr-3' fill='currentColor' viewBox='0 0 20 20'>
                <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'/>
            </svg>
            <p class='text-green-700 font-medium'>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class='bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-4'>
        <div class='flex items-start'>
            <svg class='w-5 h-5 text-red-600 mr-3 mt-0.5' fill='currentColor' viewBox='0 0 20 20'>
                <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'/>
            </svg>
            <ul class='list-disc list-inside text-red-700 space-y-1'>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- VIEW MODE -->
    <div id="viewMode" class='bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden'>
        <!-- Header -->
        <div class='bg-gradient-to-r from-purple-600 to-purple-800 p-6'>
            <div class='flex items-center justify-between flex-wrap gap-4'>
                <div class='flex items-center gap-3 text-white'>
                    <svg class='w-8 h-8' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z' clip-rule='evenodd'/>
                    </svg>
                    <div>
                        <h2 class='text-2xl font-bold'>Profil Anda</h2>
                        <p class='text-purple-100 text-sm'>Informasi data member</p>
                    </div>
                    @if($lastResetRequest)
                        <span class="ml-4 px-3 py-1 rounded-full text-sm font-semibold"
                            @if($lastResetRequest->status == 'pending')
                                style="background:#fef3c7;color:#b45309;"
                            @elseif($lastResetRequest->status == 'approved')
                                style="background:#dcfce7;color:#166534;"
                            @elseif($lastResetRequest->status == 'rejected')
                                style="background:#fee2e2;color:#991b1b;"
                            @endif
                        >
                            @if($lastResetRequest->status == 'pending')
                                Pending
                            @elseif($lastResetRequest->status == 'approved')
                                Approved
                            @elseif($lastResetRequest->status == 'rejected')
                                Ditolak
                            @endif
                        </span>
                    @endif
                </div>
                <button onclick="toggleEdit()" class='flex items-center gap-2 px-5 py-2.5 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition font-medium shadow-md'>
                    <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                    </svg>
                    <span>Edit Profil</span>
                </button>
            </div>
        </div>

        <div class='p-6 lg:p-8'>
            <!-- User Info Header -->
            <div class='flex items-center gap-4 mb-8 pb-6 border-b border-gray-200'>
                <div class='w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 text-white flex items-center justify-center text-2xl font-bold shadow-lg'>
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class='flex-grow'>
                    <h3 class='text-2xl font-bold text-gray-800'>{{ Auth::user()->name }}</h3>
                    <div class='flex items-center gap-2 mt-2 flex-wrap'>
                        <div class='flex items-center gap-2 bg-blue-600 text-white px-4 py-1.5 rounded-lg shadow-sm'>
                            <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                                <path d='M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z'/>
                                <path d='M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z'/>
                            </svg>
                            <p class='text-sm font-medium'>{{ Auth::user()->email }}</p>
                        </div>
                        @if($member->status == 'active')
                        <div class='flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-lg'>
                            <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                                <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'/>
                            </svg>
                            <span class='text-sm font-semibold'>Aktif</span>
                        </div>
                        @else
                        <div class='flex items-center gap-2 bg-orange-100 text-orange-700 px-3 py-1.5 rounded-lg'>
                            <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'>
                                <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'/>
                            </svg>
                            <span class='text-sm font-semibold'>Tidak Aktif</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Public Profile Link Card -->
            @if($member->show_in_directory)
            <div class='mb-6 bg-gradient-to-br from-purple-50 via-blue-50 to-purple-50 border-2 border-purple-200 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300'>
                <div class='flex items-start gap-4'>
                    <div class='flex-shrink-0 w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center shadow-lg'>
                        <svg class='w-8 h-8 text-white' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'/>
                        </svg>
                    </div>
                    <div class='flex-1'>
                        <h3 class='text-lg font-bold text-gray-800 mb-1 flex items-center gap-2'>
                            🌐 Profil Publik Anda
                            <span class='px-2 py-0.5 bg-green-500 text-white text-xs rounded-full font-semibold'>AKTIF</span>
                        </h3>
                        <p class='text-gray-600 text-sm mb-3'>Profil Anda ditampilkan di Direktori Anggota APJIKOM</p>
                        <a href="{{ route('directory.index') }}" target="_blank" 
                           class='inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-5 py-2.5 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 font-semibold shadow-md hover:shadow-lg group'>
                            <svg class='w-5 h-5 group-hover:scale-110 transition-transform' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                            </svg>
                            <span>Lihat Direktori Anggota</span>
                            <svg class='w-4 h-4 group-hover:translate-x-1 transition-transform' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class='mb-6 bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-300 rounded-2xl p-6 shadow-md'>
                <div class='flex items-start gap-4'>
                    <div class='flex-shrink-0 w-14 h-14 bg-gray-400 rounded-xl flex items-center justify-center'>
                        <svg class='w-8 h-8 text-white' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21'/>
                        </svg>
                    </div>
                    <div class='flex-1'>
                        <h3 class='text-lg font-bold text-gray-700 mb-1 flex items-center gap-2'>
                            🔒 Profil Publik Tidak Aktif
                            <span class='px-2 py-0.5 bg-gray-400 text-white text-xs rounded-full font-semibold'>NONAKTIF</span>
                        </h3>
                        <p class='text-gray-600 text-sm mb-3'>Aktifkan untuk menampilkan profil Anda di Direktori Anggota APJIKOM</p>
                        <a href="{{ route('directory.index') }}" target="_blank" 
                           class='inline-flex items-center gap-2 bg-gray-500 text-white px-5 py-2.5 rounded-lg hover:bg-gray-600 transition-all duration-300 font-semibold shadow-md'>
                            <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                            </svg>
                            <span>Lihat Direktori Anggota</span>
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Detail Information with Photo -->
            <div class='grid grid-cols-1 lg:grid-cols-3 gap-8'>
                <!-- Left & Center - Detail Info (2 columns) -->
                <div class='lg:col-span-2 space-y-5'>
                    <h4 class='text-lg font-bold text-gray-800 mb-4'>Informasi Member</h4>
                    
                    <div class='grid grid-cols-1 sm:grid-cols-2 gap-6'>
                        <div class='bg-gray-50 p-4 rounded-xl border border-gray-200'>
                            <p class='text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1'>Nomor Anggota</p>
                            <p class='text-lg font-bold text-purple-600'>{{ $member->member_number ?? '-' }}</p>
                        </div>
                        
                        <div class='bg-gray-50 p-4 rounded-xl border border-gray-200'>
                            <p class='text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1'>Tipe Member</p>
                            <p class='text-lg font-semibold text-gray-800'>{{ $member->member_type ?? '-' }}</p>
                        </div>
                    </div>

                    <div class='space-y-4'>
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Nama Lengkap</p>
                            <p class='text-gray-800 font-medium'>{{ Auth::user()->name }}</p>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Email</p>
                            <p class='text-gray-800'>{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Nomor Telepon</p>
                            <p class='text-gray-800'>{{ $member->phone ?? '-' }}</p>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Institusi</p>
                            <p class='text-gray-800'>{{ $member->institution_name ?? '-' }}</p>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Jabatan</p>
                            <p class='text-gray-800'>{{ $member->position ?? '-' }}</p>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 border-b border-gray-100 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Website</p>
                            <div>
                                @if($member->website)
                                <a href="{{ $member->website }}" target="_blank" class='text-blue-600 hover:text-blue-800 hover:underline break-all font-medium'>{{ $member->website }}</a>
                                @else
                                <p class='text-gray-400 italic'>Belum diisi</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class='flex flex-col sm:flex-row sm:gap-6 pb-3'>
                            <p class='text-sm font-semibold text-gray-600 sm:w-40 flex-shrink-0'>Alamat</p>
                            <p class='text-gray-800'>{{ $member->address ?? '-' }}</p>
                        </div>
                    </div>

                    @if($member->join_date || $member->expiry_date)
                    <div class='mt-6 pt-6 border-t border-gray-200'>
                        <h4 class='text-lg font-bold text-gray-800 mb-4'>Informasi Keanggotaan</h4>
                        <div class='grid grid-cols-1 sm:grid-cols-2 gap-4'>
                            @if($member->join_date)
                            <div class='flex items-center gap-3 bg-purple-50 p-4 rounded-xl'>
                                <svg class='w-8 h-8 text-purple-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                                </svg>
                                <div>
                                    <p class='text-xs text-gray-600 font-medium'>Tanggal Bergabung</p>
                                    <p class='text-sm font-bold text-gray-800'>{{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <div class='flex items-center gap-3 bg-green-50 p-4 rounded-xl'>
                                <svg class='w-8 h-8 text-green-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                                </svg>
                                <div>
                                    <p class='text-xs text-gray-600 font-medium'>Masa Berlaku</p>
                                    <p class='text-sm font-bold text-green-700'>Seumur Hidup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Directory Settings -->
                    <form action='{{ route("member.profile.update") }}' method='POST'>
                        @csrf
                        @method('PUT')
                        
                        <!-- Hidden fields untuk data yang tidak ditampilkan tapi harus dikirim -->
                        <input type='hidden' name='name' value='{{ Auth::user()->name }}'>
                        <input type='hidden' name='email' value='{{ Auth::user()->email }}'>
                        <input type='hidden' name='phone' value='{{ $member->phone }}'>
                        <input type='hidden' name='institution_name' value='{{ $member->institution_name }}'>
                        <input type='hidden' name='position' value='{{ $member->position }}'>
                        <input type='hidden' name='website' value='{{ $member->website }}'>
                        <input type='hidden' name='address' value='{{ $member->address }}'>
                        
                        <div class='mt-6 pt-6 border-t border-gray-200'>
                            <h4 class='text-lg font-bold text-gray-800 mb-4 flex items-center'>
                                <svg class='w-5 h-5 mr-2 text-blue-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'/>
                                </svg>
                                Pengaturan Direktori Anggota
                            </h4>
                            
                            <div class='bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4 rounded-lg'>
                                <p class='text-sm text-yellow-800'>
                                    <strong>💡 Info:</strong> Setelah mengubah pengaturan di bawah, klik tombol <strong>"Simpan Pengaturan Direktori"</strong> untuk menyimpan perubahan.
                                </p>
                            </div>
                            
                            <!-- Privacy Checkbox -->
                            <div class='bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border-2 border-blue-200 mb-4'>
                                <div class='flex items-start gap-4'>
                                    <div class='flex-shrink-0 pt-1'>
                                        <!-- Hidden input untuk memastikan nilai 0 dikirim jika checkbox tidak dicentang -->
                                        <input type='hidden' name='show_in_directory' value='0'>
                                        <input type='checkbox' 
                                               id='show_in_directory' 
                                               name='show_in_directory' 
                                               value='1' 
                                               onchange='updateDirectoryStatus(this)'
                                               {{ $member->show_in_directory ? 'checked' : '' }}
                                               class='w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer'>
                                    </div>
                                    <div class='flex-1'>
                                        <label for='show_in_directory' class='cursor-pointer'>
                                            <h5 class='text-lg font-bold text-gray-900 mb-2 flex items-center gap-2'>
                                                <svg class='w-5 h-5 text-blue-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                                                </svg>
                                                Tampilkan profil saya di direktori anggota
                                            </h5>
                                        </label>
                                        <p class='text-sm text-gray-600 mb-3'>
                                            Centang untuk menampilkan profil Anda di <a href='{{ route("directory.index") }}' target='_blank' class='text-blue-600 hover:text-blue-800 underline font-semibold'>halaman direktori anggota</a>. Jika tidak dicentang, profil Anda tidak akan tampil dan data tidak dapat dilihat oleh anggota lain.
                                        </p>
                                        
                                        <!-- Current Status -->
                                        <div id='directoryStatusBox' class='p-3 rounded-lg {{ $member->show_in_directory ? "bg-green-100 border border-green-300" : "bg-red-100 border border-red-300" }}'>
                                            <div class='flex items-center gap-2'>
                                                <svg id='statusIcon' class='w-5 h-5 {{ $member->show_in_directory ? "text-green-600" : "text-red-600" }}' fill='currentColor' viewBox='0 0 20 20'>
                                                    @if($member->show_in_directory)
                                                        <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'/>
                                                    @else
                                                        <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'/>
                                                    @endif
                                                </svg>
                                                <span id='statusText' class='text-sm font-semibold {{ $member->show_in_directory ? "text-green-800" : "text-red-800" }}'>
                                                    Status: {{ $member->show_in_directory ? 'Tampil di Direktori' : 'Tidak Tampil di Direktori' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bio -->
                            <div class='mb-4 mt-6'>
                            <label class='block text-sm font-bold text-gray-700 mb-2'>
                                <svg class='w-4 h-4 inline mr-1 text-purple-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'/>
                                </svg>
                                Biografi Singkat
                            </label>
                            <textarea name='bio' rows='5' id='bioTextarea' placeholder='Ceritakan sedikit tentang diri Anda atau institusi Anda...' class='w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all resize-none'>{{ old('bio', $member->bio) }}</textarea>
                            <p class='text-xs text-gray-500 mt-1'>Maksimal 300 kata. <span id='wordCount' class='font-semibold text-purple-600'>0</span> kata</p>
                        </div>
                        
                        <!-- CV Upload -->
                        <div class='mb-4'>
                            <label class='block text-sm font-bold text-gray-700 mb-2'>
                                <svg class='w-4 h-4 inline mr-1 text-indigo-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/>
                                </svg>
                                Curriculum Vitae (CV)
                            </label>
                            @if($member->cv_file)
                            <div class='mb-3 p-3 bg-green-50 border-2 border-green-200 rounded-xl'>
                                <div class='flex items-center justify-between'>
                                    <div class='flex items-center space-x-2'>
                                        <svg class='w-5 h-5 text-green-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                                        </svg>
                                        <span class='text-sm text-green-800 font-medium'>CV sudah diupload</span>
                                    </div>
                                    <div class='flex items-center space-x-2'>
                                        <a href='{{ asset("storage/" . $member->cv_file) }}' target='_blank' class='text-xs text-blue-600 hover:text-blue-700 underline'>Lihat CV</a>
                                        <button type='button' onclick='document.getElementById("deleteCV").value="1"; this.closest(".bg-green-50").classList.add("hidden"); document.getElementById("cvUploadSection").classList.remove("hidden");' class='text-xs text-red-600 hover:text-red-700'>Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' name='delete_cv' id='deleteCV' value='0'>
                            @endif
                            <div id='cvUploadSection' class='{{ $member->cv_file ? "hidden" : "" }}'>
                                <input type='file' name='cv_file' accept='.pdf,.doc,.docx' class='w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100'>
                                <p class='text-xs text-gray-500 mt-1'>Upload file PDF, DOC, atau DOCX. Maksimal 5MB</p>
                            </div>
                        </div>
                        
                        <!-- Expertise -->
                        <div class='mb-4'>
                            <label class='block text-sm font-bold text-gray-700 mb-2'>
                                <svg class='w-4 h-4 inline mr-1 text-orange-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'/>
                                </svg>
                                Keahlian & Bidang
                            </label>
                            <input type='text' name='expertise' value='{{ old("expertise", $member->expertise) }}' maxlength='300' placeholder='Contoh: Komunikasi Massa, Jurnalistik Digital, Media Sosial' class='w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all'>
                            <p class='text-xs text-gray-500 mt-1'>Pisahkan dengan koma. Maksimal 300 karakter</p>
                        </div>
                        
                        <!-- Social Media Links -->
                        <div class='space-y-3'>
                            <label class='block text-sm font-bold text-gray-700 mb-2'>
                                <svg class='w-4 h-4 inline mr-1 text-blue-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'/>
                                </svg>
                                Link Media Sosial
                            </label>
                            
                            <!-- LinkedIn -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-blue-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z'/>
                                    </svg>
                                </div>
                                <input type='url' name='linkedin' value='{{ old("linkedin", $member->linkedin) }}' placeholder='https://linkedin.com/in/username' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm'>
                            </div>
                            
                            <!-- Facebook -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-blue-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'/>
                                    </svg>
                                </div>
                                <input type='url' name='facebook' value='{{ old("facebook", $member->facebook) }}' placeholder='https://facebook.com/username' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm'>
                            </div>
                            
                            <!-- Twitter -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-sky-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-sky-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'/>
                                    </svg>
                                </div>
                                <input type='text' name='twitter' value='{{ old("twitter", $member->twitter) }}' placeholder='@username atau URL lengkap' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-all text-sm'>
                            </div>
                            
                            <!-- Instagram -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-pink-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-pink-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'/>
                                    </svg>
                                </div>
                                <input type='text' name='instagram' value='{{ old("instagram", $member->instagram) }}' placeholder='@username atau URL lengkap' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all text-sm'>
                            </div>
                        </div>

                        <!-- Link Akademik -->
                        <div class='space-y-4'>
                            <label class='block text-lg font-bold text-gray-800 mb-4 flex items-center gap-2'>
                                <svg class='w-5 h-5 text-purple-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'></path>
                                </svg>
                                Link Profil Akademik
                            </label>
                            
                            <!-- Google Scholar -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-blue-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M12 24a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0-24L0 9.5l4.838 3.94A8 8 0 0 1 12 9a8 8 0 0 1 7.162 4.44L24 9.5z'/>
                                    </svg>
                                </div>
                                <input type='url' name='google_scholar_link' value='{{ old("google_scholar_link", $member->google_scholar_link) }}' placeholder='https://scholar.google.com/...' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm'>
                            </div>
                            
                            <!-- Sinta -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-red-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-red-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'/>
                                    </svg>
                                </div>
                                <input type='url' name='sinta_link' value='{{ old("sinta_link", $member->sinta_link) }}' placeholder='https://sinta.kemdikbud.go.id/...' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm'>
                            </div>
                            
                            <!-- ORCID -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-green-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 4.378c.525 0 .947.431.947.947s-.422.947-.947.947a.95.95 0 0 1-.947-.947c0-.525.422-.947.947-.947zm-.722 3.038h1.444v10.041H6.647V7.416zm3.562 0h3.9c3.712 0 5.344 2.653 5.344 5.025 0 2.578-2.016 5.016-5.325 5.016h-3.919V7.416zm1.444 1.303v7.444h2.297c2.359 0 4.078-1.622 4.078-3.722 0-2.1-1.719-3.722-4.078-3.722h-2.297z'/>
                                    </svg>
                                </div>
                                <input type='url' name='orcid_link' value='{{ old("orcid_link", $member->orcid_link) }}' placeholder='https://orcid.org/...' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all text-sm'>
                            </div>
                            
                            <!-- Scopus -->
                            <div class='flex items-center gap-3'>
                                <div class='flex items-center justify-center w-10 h-10 bg-orange-100 rounded-lg flex-shrink-0'>
                                    <svg class='w-5 h-5 text-orange-600' fill='currentColor' viewBox='0 0 24 24'>
                                        <path d='M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-1.5 17.5L5 12l1.5-1.5 4 4 8-8 1.5 1.5-9.5 9.5z'/>
                                    </svg>
                                </div>
                                <input type='url' name='scopus_link' value='{{ old("scopus_link", $member->scopus_link) }}' placeholder='https://www.scopus.com/...' class='flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all text-sm'>
                            </div>
                        </div>
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 text-lg">
                                Simpan Profil
                            </button>
                        </div>
                    </div>
                    </form>
                </div>

                <!-- Right - Profile Image -->
                <div class='lg:col-span-1'>
                    <div class='sticky top-6'>
                        <h4 class='text-lg font-bold text-gray-800 mb-4'>Foto Profil</h4>
                        <div class='relative group'>
                            @if($member->photo)
                                <img src="{{ Storage::url($member->photo) }}" alt="Foto Profil" class='w-full aspect-[3/4] object-cover rounded-2xl shadow-xl border-4 border-white ring-2 ring-gray-200'>
                            @else
                                <div class='w-full aspect-[3/4] bg-gradient-to-br from-purple-400 via-purple-500 to-purple-600 rounded-2xl shadow-xl flex items-center justify-center'>
                                    <svg class='w-24 h-24 text-white opacity-60' fill='currentColor' viewBox='0 0 20 20'>
                                        <path fill-rule='evenodd' d='M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z' clip-rule='evenodd'/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Upload Button - Lebih Terlihat -->
                            <form action="{{ route('member.profile.upload-photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                                @csrf
                                <input type="file" name="photo" id="photoInput" accept="image/*" class='hidden' onchange="document.getElementById('photoForm').submit()">
                                <button type="button" onclick="document.getElementById('photoInput').click()" class='absolute bottom-4 right-4 p-4 rounded-full bg-yellow-500 hover:bg-yellow-600 text-white shadow-2xl transition transform hover:scale-125 border-4 border-white z-10'>
                                    <svg class='w-7 h-7' fill='none' stroke='currentColor' viewBox='0 0 24 24' stroke-width='2.5'>
                                        <path stroke-linecap='round' stroke-linejoin='round' d='M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z'/>
                                        <path stroke-linecap='round' stroke-linejoin='round' d='M15 13a3 3 0 11-6 0 3 3 0 016 0z'/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <p class='text-xs text-gray-500 mt-3 text-center'>Klik tombol kuning untuk upload foto (max 2MB)</p>
                        
                        @if($member->photo)
                        <form action="{{ route('member.profile.delete-photo') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto?')" class='mt-3'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class='w-full py-2 border-2 border-red-300 text-red-600 hover:bg-red-50 font-medium rounded-lg transition'>
                                🗑️ Hapus Foto
                            </button>
                        </form>
                        
                        <!-- Request KTA Button -->
                        @if(!$member->member_card && $member->photo && $member->address && $member->phone)
                            @if(!$member->card_requested)
                                <form action="{{ route('member.request-card') }}" method="POST" class='mt-4'>
                                    @csrf
                                    <button type="submit" class='group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 p-0.5 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-green-500/50'>
                                        <div class='relative bg-gradient-to-br from-emerald-600 to-green-700 rounded-[11px] px-6 py-4 transition-all duration-300 group-hover:from-emerald-500 group-hover:to-green-600'>
                                            <!-- Animated background shimmer -->
                                            <div class='absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000'></div>
                                            
                                            <!-- Content -->
                                            <div class='relative flex items-center justify-center gap-3'>
                                                <!-- Icon with animation -->
                                                <div class='flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg backdrop-blur-sm group-hover:rotate-12 transition-transform duration-300'>
                                                    <svg class='w-6 h-6 text-white' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'/>
                                                    </svg>
                                                </div>
                                                
                                                <!-- Text -->
                                                <div class='text-left'>
                                                    <div class='text-white font-bold text-lg tracking-wide'>
                                                        Request Kartu Anggota
                                                    </div>
                                                    <div class='text-green-100 text-xs font-medium'>
                                                        Klik untuk mengajukan pembuatan KTA
                                                    </div>
                                                </div>
                                                
                                                <!-- Arrow icon -->
                                                <svg class='w-5 h-5 text-white/80 ml-auto group-hover:translate-x-1 transition-transform duration-300' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 7l5 5m0 0l-5 5m5-5H6'/>
                                                </svg>
                                            </div>
                                            
                                            <!-- Pulse effect dots -->
                                            <div class='absolute top-2 right-2 flex gap-1'>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse'></span>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse' style='animation-delay: 0.2s'></span>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse' style='animation-delay: 0.4s'></span>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @else
                                <!-- Processing Status -->
                                <div class='mt-4 relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-500 p-0.5 shadow-lg shadow-blue-500/30'>
                                    <div class='relative bg-gradient-to-br from-blue-50 to-cyan-50 rounded-[11px] px-6 py-4'>
                                        <!-- Animated progress bar -->
                                        <div class='absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400 animate-pulse'></div>
                                        
                                        <div class='flex items-center gap-4'>
                                            <!-- Animated spinner icon -->
                                            <div class='flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl shadow-lg'>
                                                <svg class='w-7 h-7 text-white animate-spin' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'/>
                                                </svg>
                                            </div>
                                            
                                            <!-- Status text -->
                                            <div class='flex-1'>
                                                <div class='flex items-center gap-2 mb-1'>
                                                    <div class='text-blue-900 font-bold text-base'>
                                                        Permintaan Sedang Diproses
                                                    </div>
                                                    <div class='flex gap-1'>
                                                        <span class='w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce'></span>
                                                        <span class='w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce' style='animation-delay: 0.1s'></span>
                                                        <span class='w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce' style='animation-delay: 0.2s'></span>
                                                    </div>
                                                </div>
                                                <div class='text-blue-700 text-xs font-medium'>
                                                    Admin sedang memverifikasi data Anda
                                                </div>
                                            </div>
                                            
                                            <!-- Check badge -->
                                            <div class='flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg shadow-md'>
                                                <svg class='w-4 h-4 text-white' fill='currentColor' viewBox='0 0 20 20'>
                                                    <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'/>
                                                </svg>
                                                <span class='text-white text-xs font-bold'>Terkirim</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                        <!-- Request Update KTA Button (jika sudah punya kartu) -->
                        @if($member->member_card && $member->photo && $member->address && $member->phone)
                            @if(!$member->card_update_requested)
                                <form action="{{ route('member.request-card-update') }}" method="POST" class='mt-4'>
                                    @csrf
                                    <button type="submit" class='group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 p-0.5 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-500/50'>
                                        <div class='relative bg-gradient-to-br from-amber-600 to-orange-700 rounded-[11px] px-6 py-4 transition-all duration-300 group-hover:from-amber-500 group-hover:to-orange-600'>
                                            <!-- Animated background shimmer -->
                                            <div class='absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000'></div>
                                            
                                            <!-- Content -->
                                            <div class='relative flex items-center justify-center gap-3'>
                                                <!-- Icon with animation -->
                                                <div class='flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg backdrop-blur-sm group-hover:rotate-12 transition-transform duration-300'>
                                                    <svg class='w-6 h-6 text-white' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'/>
                                                    </svg>
                                                </div>
                                                
                                                <!-- Text -->
                                                <div class='text-left'>
                                                    <div class='text-white font-bold text-lg tracking-wide'>
                                                        Request Update KTA
                                                    </div>
                                                    <div class='text-orange-100 text-xs font-medium'>
                                                        Ajukan pembaruan kartu anggota
                                                    </div>
                                                </div>
                                                
                                                <!-- Arrow icon -->
                                                <svg class='w-5 h-5 text-white/80 ml-auto group-hover:translate-x-1 transition-transform duration-300' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 7l5 5m0 0l-5 5m5-5H6'/>
                                                </svg>
                                            </div>
                                            
                                            <!-- Pulse effect dots -->
                                            <div class='absolute top-2 right-2 flex gap-1'>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse'></span>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse' style='animation-delay: 0.2s'></span>
                                                <span class='w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse' style='animation-delay: 0.4s'></span>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @else
                                <!-- Update Request Processing Status - Elegant & Compact -->
                                <div class='mt-4 relative overflow-hidden rounded-xl bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400 p-[1px] shadow-lg hover:shadow-xl transition-all duration-300'>
                                    <div class='relative bg-white rounded-[11px] p-4'>
                                        <div class='flex items-center gap-3'>
                                            <!-- Animated Icon -->
                                            <div class='relative flex-shrink-0'>
                                                <div class='absolute inset-0 bg-orange-400 rounded-xl animate-ping opacity-25'></div>
                                                <div class='w-12 h-12 bg-gradient-to-br from-amber-500 via-orange-500 to-rose-500 rounded-xl flex items-center justify-center shadow-md'>
                                                    <svg class='w-6 h-6 text-white animate-spin' style='animation-duration: 2s;' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'/>
                                                    </svg>
                                                </div>
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class='flex-1 min-w-0'>
                                                <div class='flex items-center gap-2 mb-1'>
                                                    <h4 class='text-base font-bold text-gray-800'>
                                                        Update KTA Sedang Diproses
                                                    </h4>
                                                    <div class='flex gap-0.5'>
                                                        <span class='w-1 h-1 bg-orange-500 rounded-full animate-bounce'></span>
                                                        <span class='w-1 h-1 bg-orange-500 rounded-full animate-bounce' style='animation-delay: 0.15s;'></span>
                                                        <span class='w-1 h-1 bg-orange-500 rounded-full animate-bounce' style='animation-delay: 0.3s;'></span>
                                                    </div>
                                                </div>
                                                <p class='text-xs text-gray-600 mb-2'>
                                                    Admin akan memperbarui kartu Anda segera
                                                </p>
                                                
                                                <!-- Progress Bar -->
                                                <div class='relative h-1 bg-gradient-to-r from-orange-100 to-rose-100 rounded-full overflow-hidden'>
                                                    <div class='absolute inset-0 bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 rounded-full' style='width: 70%; animation: slideProgress 2s ease-in-out infinite;'></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Badge -->
                                            <div class='flex-shrink-0'>
                                                <div class='px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg shadow-md flex items-center gap-1.5'>
                                                    <div class='w-1.5 h-1.5 bg-white rounded-full animate-pulse'></div>
                                                    <span class='text-white text-xs font-semibold tracking-wide'>TERKIRIM</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <style>
                                    @keyframes slideProgress {
                                        0%, 100% { width: 60%; }
                                        50% { width: 85%; }
                                    }
                                </style>
                            @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODE FORM -->
    <div id="editMode" style="display:none" class='bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden'>
        <div class='bg-gradient-to-r from-purple-600 to-purple-800 p-6'>
            <div class='flex items-center justify-between text-white'>
                <div class='flex items-center gap-3'>
                    <svg class='w-8 h-8' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                    </svg>
                    <div>
                        <h2 class='text-2xl font-bold'>Edit Profil</h2>
                        <p class='text-purple-100 text-sm'>Perbarui informasi profil Anda</p>
                    </div>
                </div>
                <button onclick="toggleEdit()" class='p-2 hover:bg-purple-700 rounded-lg transition'>
                    <svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('member.profile.update') }}" method="POST" class='p-6 lg:p-8'>
            @csrf
            @method('PUT')

            <div class='bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded'>
                <div class='flex items-center'>
                    <svg class='w-5 h-5 text-blue-600 mr-3' fill='currentColor' viewBox='0 0 20 20'>
                        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z' clip-rule='evenodd'/>
                    </svg>
                    <p class='text-blue-700 text-sm font-medium'>Silakan perbarui informasi profil Anda di bawah ini</p>
                </div>
            </div>

            <div class='grid grid-cols-1 md:grid-cols-2 gap-5'>
                <!-- Nama Lengkap -->
                <div>
                    <label for='name' class='block text-sm font-semibold text-gray-700 mb-2'>
                        Nama Lengkap <span class='text-red-500'>*</span>
                    </label>
                    <input type='text' id='name' name='name' value='{{ old("name", Auth::user()->name) }}' required class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Email -->
                <div>
                    <label for='email' class='block text-sm font-semibold text-gray-700 mb-2'>
                        Email <span class='text-red-500'>*</span>
                    </label>
                    <input type='email' id='email' name='email' value='{{ old("email", Auth::user()->email) }}' required class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for='phone' class='block text-sm font-semibold text-gray-700 mb-2'>Nomor Telepon</label>
                    <input type='text' id='phone' name='phone' value='{{ old("phone", $member->phone) }}' placeholder='08123456789' class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Institusi -->
                <div>
                    <label for='institution_name' class='block text-sm font-semibold text-gray-700 mb-2'>Nama Institusi</label>
                    <input type='text' id='institution_name' name='institution_name' value='{{ old("institution_name", $member->institution_name) }}' placeholder='Nama institusi Anda' class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for='position' class='block text-sm font-semibold text-gray-700 mb-2'>Jabatan</label>
                    <input type='text' id='position' name='position' value='{{ old("position", $member->position) }}' placeholder='Jabatan Anda' class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Website -->
                <div>
                    <label for='website' class='block text-sm font-semibold text-gray-700 mb-2'>Website</label>
                    <input type='url' id='website' name='website' value='{{ old("website", $member->website) }}' placeholder='https://example.com' class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>
                </div>

                <!-- Alamat (Full Width) -->
                <div class='md:col-span-2'>
                    <label for='address' class='block text-sm font-semibold text-gray-700 mb-2'>
                        Alamat
                        <span class='text-xs text-gray-500 font-normal ml-2'>(Gunakan Enter untuk membuat baris baru)</span>
                    </label>
                    <textarea id='address' name='address' rows='3' placeholder='Contoh:&#10;Jl. Majapahit No. 605 Semarang&#10;RT 03 RW 05 Kelurahan Semarang Tengah&#10;Jawa Tengah 50192' class='w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition'>{{ old('address', $member->address) }}</textarea>
                    <p class='text-xs text-gray-500 mt-1'>💡 Tips: Tekan Enter untuk membuat baris baru agar alamat tampil rapi di kartu anggota (maksimal 3 baris)</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class='flex gap-4 mt-8 flex-wrap'>
                <button type='submit' class='flex items-center gap-2 px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-lg shadow-xl transition transform hover:scale-105'>
                    <svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
                <button type='button' onclick="toggleEdit()" class='px-8 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-bold text-lg transition'>
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- EDIT AKUN USER & PASSWORD -->
    <div class='bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6'>
        <div class='bg-white border-b-2 border-blue-200 p-6'>
            <div class='flex items-center gap-3'>
                <svg class='w-8 h-8 text-blue-600' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z' clip-rule='evenodd'/>
                </svg>
                <div>
                    <h2 class='text-2xl font-bold text-blue-900'>Pengaturan Akun</h2>
                    <p class='text-blue-700 text-sm font-medium'>Ubah nama dan password akun Anda</p>
                </div>
            </div>
        </div>

        <div class='p-6 lg:p-8'>
            <!-- Form Edit Nama User -->
            <form action="{{ route('member.profile.update-name') }}" method="POST" class='mb-8 pb-8 border-b border-gray-200'>
                @csrf
                @method('PUT')
                
                <h3 class='text-lg font-bold text-gray-800 mb-4 flex items-center gap-2'>
                    <svg class='w-6 h-6 text-blue-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'/>
                    </svg>
                    Ubah Nama Pengguna
                </h3>

                <div class='bg-blue-50 border-l-4 border-blue-500 p-4 mb-4'>
                    <p class='text-sm text-blue-700'>
                        <strong>Email:</strong> {{ Auth::user()->email }} (tidak bisa diubah)
                    </p>
                </div>

                <div class='mb-4'>
                    <label class='block text-base font-bold text-gray-900 mb-2'>
                        Nama Lengkap <span class='text-red-600'>*</span>
                    </label>
                    <input type='text' 
                           name='name' 
                           value='{{ old("name", Auth::user()->name) }}'
                           class='w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error("name") border-red-500 @enderror'
                           placeholder='Masukkan nama lengkap'
                           required>
                    @error('name')
                        <p class='text-red-500 text-sm mt-1'>{{ $message }}</p>
                    @enderror
                </div>

                <button type='submit' class='flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-lg transition transform hover:scale-105'>
                    <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                    </svg>
                    <span>Update Nama</span>
                </button>
            </form>

            <!-- Form Edit Password -->
            <form action="{{ route('member.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <h3 class='text-lg font-bold text-gray-800 mb-4 flex items-center gap-2'>
                    <svg class='w-6 h-6 text-red-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'/>
                    </svg>
                    Ubah Password
                </h3>

                <div class='bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4'>
                    <p class='text-sm text-yellow-800'>
                        <strong>Penting:</strong> Gunakan password yang kuat (minimal 8 karakter)
                    </p>
                </div>

                <div class='mb-4'>
                    <label class='block text-base font-bold text-gray-900 mb-2'>
                        Password Lama <span class='text-red-600'>*</span>
                    </label>
                    <input type='password' 
                           name='current_password' 
                           class='w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error("current_password") border-red-500 @enderror'
                           placeholder='Masukkan password lama'
                           required>
                    @error('current_password')
                        <p class='text-red-500 text-sm mt-1'>{{ $message }}</p>
                    @enderror
                </div>

                <div class='mb-4'>
                    <label class='block text-base font-bold text-gray-900 mb-2'>
                        Password Baru <span class='text-red-600'>*</span>
                    </label>
                    <input type='password' 
                           id='new_password'
                           name='password' 
                           class='w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error("password") border-red-500 @enderror'
                           placeholder='Masukkan password baru (min. 8 karakter)'
                           required>
                    @error('password')
                        <p class='text-red-500 text-sm mt-1'>{{ $message }}</p>
                    @enderror
                    <!-- Password Strength Meter -->
                    <div class="password-strength-meter" data-password-input="#new_password"></div>
                </div>

                <div class='mb-4'>
                    <label class='block text-base font-bold text-gray-900 mb-2'>
                        Konfirmasi Password Baru <span class='text-red-600'>*</span>
                    </label>
                    <input type='password' 
                           name='password_confirmation' 
                           class='w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500'
                           placeholder='Konfirmasi password baru'
                           required>
                </div>

                <button type='submit' class='flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold shadow-lg transition transform hover:scale-105'>
                    <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'/>
                    </svg>
                    <span>Update Password</span>
                </button>
            </form>
            
            <!-- Divider -->
            <div class='my-8 border-t border-gray-200'></div>
            
            <!-- Request Password Reset from Admin -->
            <div class='bg-gradient-to-br from-orange-50 to-amber-50 border-l-4 border-orange-500 rounded-xl p-6 shadow-sm'>
                <h3 class='text-lg font-bold text-gray-800 mb-3 flex items-center gap-2'>
                    <svg class='w-6 h-6 text-orange-600' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'/>
                    </svg>
                    Lupa Password?
                </h3>
                <p class='text-sm text-gray-700 mb-4'>
                    Jika Anda lupa password lama, Anda bisa meminta admin untuk mereset password Anda ke password default.
                </p>
                
                @php
                    $lastRequest = \App\Models\PasswordResetRequest::where('user_id', Auth::id())
                        ->latest()
                        ->first();
                    $hasPendingRequest = \App\Models\PasswordResetRequest::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->exists();
                @endphp
                
                @if($lastRequest && in_array($lastRequest->status, ['approved', 'rejected']))
                    <!-- Show last request status -->
                    <div class='p-4 rounded-lg flex items-start gap-3 shadow-sm border-l-4 mb-4
                        @if($lastRequest->status == 'approved') border-green-400 bg-green-50
                        @elseif($lastRequest->status == 'rejected') border-red-400 bg-red-50
                        @endif'>
                        <svg class='w-5 h-5 flex-shrink-0 mt-0.5'
                            @if($lastRequest->status == 'approved') fill='none' stroke='currentColor' viewBox='0 0 24 24' style='color:#22c55e;'
                            @elseif($lastRequest->status == 'rejected') fill='none' stroke='currentColor' viewBox='0 0 24 24' style='color:#ef4444;'
                            @endif>
                            @if($lastRequest->status == 'approved')
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                            @elseif($lastRequest->status == 'rejected')
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                            @endif
                        </svg>
                        <div>
                            <p class='font-semibold 
                                @if($lastRequest->status == 'approved') text-green-800
                                @elseif($lastRequest->status == 'rejected') text-red-800
                                @endif'>
                                @if($lastRequest->status == 'approved')
                                    Permintaan Disetujui
                                @elseif($lastRequest->status == 'rejected')
                                    Permintaan Ditolak
                                @endif
                            </p>
                            <p class='text-sm mt-1 
                                @if($lastRequest->status == 'approved') text-green-700
                                @elseif($lastRequest->status == 'rejected') text-red-700
                                @endif'>
                                @if($lastRequest->status == 'approved')
                                    Permintaan reset password Anda telah disetujui dan password sudah direset oleh admin.
                                @elseif($lastRequest->status == 'rejected')
                                    Permintaan reset password Anda ditolak oleh admin.
                                @endif
                            </p>
                            <p class='text-xs mt-1'>Dibuat: {{ $lastRequest->created_at->diffForHumans() }}</p>
                            @if($lastRequest->reason)
                                <div class='mt-2 text-xs'><span class='font-semibold'>Alasan:</span> {{ $lastRequest->reason }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Show request button again -->
                    <button onclick="openResetRequestModal()" class='flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl'>
                        <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z'/>
                        </svg>
                        <span>Reset Password</span>
                    </button>
                @elseif($hasPendingRequest)
                    <!-- Show pending status -->
                    <div class='p-4 rounded-lg flex items-start gap-3 shadow-sm border-l-4 border-amber-400 bg-amber-50'>
                        <svg class='w-5 h-5 flex-shrink-0 mt-0.5' fill='none' stroke='currentColor' viewBox='0 0 24 24' style='color:#f59e42;'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'/>
                        </svg>
                        <div>
                            <p class='font-semibold text-amber-800'>Permintaan Sedang Diproses</p>
                            <p class='text-sm mt-1 text-amber-700'>
                                Anda sudah memiliki permintaan reset password yang sedang menunggu persetujuan admin.
                            </p>
                            <p class='text-xs mt-1'>Dibuat: {{ $lastRequest->created_at->diffForHumans() }}</p>
                            @if($lastRequest->reason)
                                <div class='mt-2 text-xs'><span class='font-semibold'>Alasan:</span> {{ $lastRequest->reason }}</div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- No request yet, show button -->
                    <button onclick="openResetRequestModal()" class='flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl'>
                        <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z'/>
                        </svg>
                        <span>Reset Password</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Request Password Reset -->
<div id="resetRequestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Request Reset Password</h3>
            <button onclick="closeResetRequestModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('member.password-reset-request') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alasan Permintaan <span class="text-red-600">*</span>
                </label>
                <textarea name="reason" rows="4" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    placeholder="Contoh: Lupa password lama, tidak bisa login, dll..."></textarea>
                <p class="text-xs text-gray-500 mt-1">Admin akan mereview permintaan Anda</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-blue-800">
                    <strong>Catatan:</strong> Password akan direset ke <code class="px-2 py-0.5 bg-blue-100 rounded font-mono">@apjikom.oke</code>. 
                    Setelah direset, segera ubah password Anda.
                </p>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeResetRequestModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openResetRequestModal() {
    document.getElementById('resetRequestModal').classList.remove('hidden');
}

function closeResetRequestModal() {
    document.getElementById('resetRequestModal').classList.add('hidden');
}

function toggleEdit() {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    
    if (viewMode.style.display === 'none') {
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
    } else {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function updateDirectoryStatus(checkbox) {
    const statusBox = document.getElementById('directoryStatusBox');
    const statusIcon = document.getElementById('statusIcon');
    const statusText = document.getElementById('statusText');
    
    if (checkbox.checked) {
        // Tampil di direktori
        statusBox.className = 'p-3 rounded-lg bg-green-100 border border-green-300';
        statusIcon.className = 'w-5 h-5 text-green-600';
        statusIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
        statusText.className = 'text-sm font-semibold text-green-800';
        statusText.textContent = 'Status: Tampil di Direktori';
    } else {
        // Tidak tampil di direktori
        statusBox.className = 'p-3 rounded-lg bg-red-100 border border-red-300';
        statusIcon.className = 'w-5 h-5 text-red-600';
        statusIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
        statusText.className = 'text-sm font-semibold text-red-800';
        statusText.textContent = 'Status: Tidak Tampil di Direktori';
    }
}

function previewAndSubmitPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        // Validasi ukuran file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }
        
        // Validasi tipe file
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar!');
            event.target.value = '';
            return;
        }
        
        // Preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            
            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                placeholder.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" id="photoPreview">';
            }
        };
        reader.readAsDataURL(file);
        
        // Auto submit form
        document.getElementById('photoUploadForm').submit();
    }
}

// Word counter for bio textarea
document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('bioTextarea');
    const wordCountSpan = document.getElementById('wordCount');
    
    if (bioTextarea && wordCountSpan) {
        function updateWordCount() {
            const text = bioTextarea.value.trim();
            const wordCount = text === '' ? 0 : text.split(/\s+/).length;
            wordCountSpan.textContent = wordCount;
            
            // Change color based on word count
            if (wordCount > 300) {
                wordCountSpan.classList.remove('text-purple-600');
                wordCountSpan.classList.add('text-red-600');
            } else if (wordCount > 250) {
                wordCountSpan.classList.remove('text-purple-600', 'text-red-600');
                wordCountSpan.classList.add('text-orange-600');
            } else {
                wordCountSpan.classList.remove('text-red-600', 'text-orange-600');
                wordCountSpan.classList.add('text-purple-600');
            }
        }
        
        // Update on load
        updateWordCount();
        
        // Update on input
        bioTextarea.addEventListener('input', updateWordCount);
    }
});
</script>

<!-- Password Strength Meter Script -->
<script src="{{ asset('js/password-strength-meter.js') }}"></script>
@endsection
