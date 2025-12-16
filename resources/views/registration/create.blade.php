@extends('layouts.main')

@section('title', 'Daftar Anggota APJIKOM')

@section('content')
<!-- Page Header -->
<section class="bg-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Pendaftaran Anggota APJIKOM</h1>
        <p class="text-lg text-purple-100">Bergabunglah bersama kami untuk memajukan publikasi ilmiah Indonesia</p>
    </div>
</section>

<!-- Registration Form -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Pendaftaran Berhasil!</h3>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Membership Type Selection -->
            <div class="bg-white rounded-lg shadow-sm border p-8 mb-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900">Pilih Tipe Keanggotaan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Individu Card -->
                    <div class="border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-purple-500 transition" id="card-individu" onclick="selectType('individu')">
                        <div class="flex items-start mb-4">
                            <input type="radio" name="membership_type" value="individu" id="type-individu" class="mt-1 mr-3 h-5 w-5 text-purple-600">
                            <div>
                                <label for="type-individu" class="text-xl font-bold text-gray-900 cursor-pointer">Individu</label>
                                <p class="text-gray-600 text-sm mt-2">Untuk anggota perorangan yang ingin bergabung secara individu</p>
                            </div>
                        </div>
                        @if($paymentSettings['registration_mode'] === 'paid')
                        <div class="bg-purple-50 rounded p-4 mt-4">
                            <p class="text-sm font-semibold text-purple-900 mb-2">Biaya Donasi:</p>
                            <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($paymentSettings['biaya_individu'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mt-1">Masa keanggotaan 1 tahun</p>
                        </div>
                        @else
                        <div class="bg-green-50 rounded p-4 mt-4">
                            <p class="text-sm font-semibold text-green-900 mb-2">Pendaftaran:</p>
                            <p class="text-2xl font-bold text-green-600">🆓 GRATIS</p>
                            <p class="text-xs text-gray-600 mt-1">Masa keanggotaan 1 tahun</p>
                        </div>
                        @endif
                    </div>

                    <!-- Prodi Card -->
                    <div class="border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-purple-500 transition" id="card-prodi" onclick="selectType('prodi')">
                        <div class="flex items-start mb-4">
                            <input type="radio" name="membership_type" value="prodi" id="type-prodi" class="mt-1 mr-3 h-5 w-5 text-purple-600">
                            <div>
                                <label for="type-prodi" class="text-xl font-bold text-gray-900 cursor-pointer">Program Studi</label>
                                <p class="text-gray-600 text-sm mt-2">Untuk perguruan tinggi yang memiliki program studi informatika dan komputer</p>
                            </div>
                        </div>
                        @if($paymentSettings['registration_mode'] === 'paid')
                        <div class="bg-purple-50 rounded p-4 mt-4">
                            <p class="text-sm font-semibold text-purple-900 mb-2">Biaya Donasi:</p>
                            <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($paymentSettings['biaya_prodi'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mt-1">Masa keanggotaan 1 tahun</p>
                        </div>
                        @else
                        <div class="bg-green-50 rounded p-4 mt-4">
                            <p class="text-sm font-semibold text-green-900 mb-2">Pendaftaran:</p>
                            <p class="text-2xl font-bold text-green-600">🆓 GRATIS</p>
                            <p class="text-xs text-gray-600 mt-1">Masa keanggotaan 1 tahun</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                @if($paymentSettings['registration_mode'] === 'paid')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-blue-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Transfer
                    </h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Bank:</span> {{ $paymentSettings['bank_name'] }}</p>
                        <p><span class="font-semibold">Nomor Rekening:</span> {{ $paymentSettings['account_number'] }}</p>
                        <p><span class="font-semibold">Atas Nama:</span> {{ $paymentSettings['account_name'] }}</p>
                    </div>
                </div>
                @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-green-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pendaftaran Gratis
                    </h3>
                    <p class="text-sm text-gray-700">Pendaftaran saat ini tidak dikenakan biaya. Silakan lengkapi formulir pendaftaran di bawah ini.</p>
                </div>
                @endif
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data" id="registration-form" style="display: none;">
                @csrf
                <div class="bg-white rounded-lg shadow-sm border p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Form Pendaftaran</h2>
                    
                    <input type="hidden" name="type" id="form-type">
                    
                    <!-- Common Fields -->
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nomor Handphone (Whatsapp) <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required maxlength="13"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('phone') border-red-500 @enderror"
                                   placeholder="08123456789" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Maksimal 13 karakter, tanpa tanda "+"</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required minlength="8"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-500 @enderror pr-12"
                                       placeholder="Minimal 8 karakter"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" onclick="togglePassword('password', 'togglePasswordIcon')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg id="togglePasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <!-- Password Strength Bar -->
                            <div class="mt-2">
                                <div class="flex items-center gap-1 mb-1">
                                    <div class="h-1 flex-1 rounded bg-gray-200" id="strength-bar-1"></div>
                                    <div class="h-1 flex-1 rounded bg-gray-200" id="strength-bar-2"></div>
                                    <div class="h-1 flex-1 rounded bg-gray-200" id="strength-bar-3"></div>
                                    <div class="h-1 flex-1 rounded bg-gray-200" id="strength-bar-4"></div>
                                </div>
                                <p id="strength-text" class="text-xs text-gray-500">Minimal 8 karakter</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('password_confirmation') border-red-500 @enderror pr-12"
                                       placeholder="Ketik ulang password"
                                       oninput="checkPasswordMatch()">
                                <button type="button" onclick="togglePassword('password_confirmation', 'togglePasswordConfirmIcon')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg id="togglePasswordConfirmIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p id="match-text" class="text-xs text-gray-500 mt-1"></p>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <span id="label-name">Nama Lengkap</span> <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('full_name') border-red-500 @enderror"
                                   placeholder="Nama lengkap tanpa gelar">
                            @error('full_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prodi Fields (hidden by default) -->
                        <div id="prodi-fields" style="display: none;">
                            <!-- Institution -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Institusi <span class="text-red-500">*</span></label>
                                <input type="text" name="institution" value="{{ old('institution') }}" list="institution-list"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('institution') border-red-500 @enderror"
                                       placeholder="Masukan Institusi Anda...">
                                <datalist id="institution-list">
                                    <option value="Universitas Indonesia">
                                    <option value="Institut Teknologi Bandung">
                                    <option value="Universitas Gadjah Mada">
                                    <option value="Institut Teknologi Sepuluh Nopember">
                                    <option value="Universitas Diponegoro">
                                    <option value="Universitas Airlangga">
                                    <option value="Universitas Padjadjaran">
                                    <option value="Universitas Brawijaya">
                                    <option value="Universitas Hasanuddin">
                                    <option value="Universitas Sumatera Utara">
                                    <option value="Universitas Andalas">
                                    <option value="Universitas Sriwijaya">
                                    <option value="Universitas Sebelas Maret">
                                    <option value="Universitas Jember">
                                    <option value="Universitas Lampung">
                                    <option value="Universitas Negeri Malang">
                                    <option value="Universitas Negeri Jakarta">
                                    <option value="Universitas Negeri Semarang">
                                    <option value="Universitas Negeri Surabaya">
                                    <option value="Universitas Negeri Yogyakarta">
                                    <option value="Universitas Pendidikan Indonesia">
                                    <option value="Institut Pertanian Bogor">
                                    <option value="Universitas Telkom">
                                    <option value="Universitas Bina Nusantara">
                                    <option value="Universitas Gunadarma">
                                    <option value="Universitas Mercu Buana">
                                    <option value="Universitas Trisakti">
                                    <option value="Universitas Kristen Petra">
                                    <option value="Universitas Atma Jaya Yogyakarta">
                                    <option value="Universitas Katolik Indonesia Atma Jaya">
                                    <option value="Universitas Dian Nuswantoro">
                                    <option value="Universitas Islam Indonesia">
                                    <option value="Universitas Muhammadiyah Malang">
                                    <option value="Universitas Ahmad Dahlan">
                                    <option value="STMIK AMIKOM Yogyakarta">
                                    <option value="Institut Teknologi Telkom Purwokerto">
                                    <option value="Politeknik Negeri Bandung">
                                    <option value="Politeknik Elektronika Negeri Surabaya">
                                </datalist>
                                @error('institution')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Study Program -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Program Studi <span class="text-red-500">*</span></label>
                                <input type="text" name="study_program" value="{{ old('study_program') }}" list="prodi-list"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('study_program') border-red-500 @enderror"
                                       placeholder="Masukan Prodi Anda...">
                                <datalist id="prodi-list">
                                    <option value="Teknik Informatika">
                                    <option value="Sistem Informasi">
                                    <option value="Ilmu Komputer">
                                    <option value="Teknologi Informasi">
                                    <option value="Rekayasa Perangkat Lunak">
                                    <option value="Teknik Komputer">
                                    <option value="Informatika">
                                    <option value="Sains Data">
                                    <option value="Data Science">
                                    <option value="Cyber Security">
                                    <option value="Keamanan Siber">
                                    <option value="Kecerdasan Buatan">
                                    <option value="Artificial Intelligence">
                                    <option value="Game Technology">
                                    <option value="Teknologi Game">
                                    <option value="Mobile Application and Technology">
                                    <option value="Internet of Things">
                                    <option value="Computer Science">
                                    <option value="Information Systems">
                                    <option value="Software Engineering">
                                    <option value="Computer Engineering">
                                    <option value="Information Technology">
                                </datalist>
                                @error('study_program')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Accreditation -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Akreditasi <span class="text-red-500">*</span></label>
                                <select name="accreditation"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('accreditation') border-red-500 @enderror">
                                    <option value="">Pilih Akreditasi</option>
                                    <option value="A" {{ old('accreditation') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('accreditation') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('accreditation') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="Unggul" {{ old('accreditation') == 'Unggul' ? 'selected' : '' }}>Unggul</option>
                                    <option value="Baik Sekali" {{ old('accreditation') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                    <option value="Baik" {{ old('accreditation') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                </select>
                                @error('accreditation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Accreditation Valid Until -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Akreditasi Berlaku Hingga <span class="text-red-500">*</span></label>
                                <input type="date" name="accreditation_valid_until" value="{{ old('accreditation_valid_until') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('accreditation_valid_until') border-red-500 @enderror">
                                @error('accreditation_valid_until')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Provinsi Institusi <span class="text-red-500">*</span></label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('province') border-red-500 @enderror"
                                       placeholder="Nama Provinsi">
                                @error('province')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Authorization Letter -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Upload Surat Kuasa</label>
                                <p class="text-sm text-gray-600 mb-2">
                                    <a href="https://dias.aptikom.org/assets/documents/template_surat_kuasa_anggota_prodi_aptikom.docx" 
                                       target="_blank" class="text-purple-600 hover:text-purple-700 underline">
                                        Download Template Surat Kuasa
                                    </a>
                                </p>
                                <input type="file" name="authorization_letter" accept=".jpg,.jpeg,.png,.bmp,.pdf,.doc,.docx"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('authorization_letter') border-red-500 @enderror">
                                @error('authorization_letter')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Format: jpg, bmp, png, jpeg, pdf, doc, docx | Maksimal 5MB</p>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        @if($paymentSettings['registration_mode'] === 'paid' && $paymentSettings['require_payment_proof'] == '1')
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                Upload Bukti Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.bmp,.pdf" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('payment_proof') border-red-500 @enderror"
                                   onchange="previewFile(this)">
                            @error('payment_proof')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Format: jpg, bmp, png, jpeg, pdf | Maksimal 5MB</p>
                            <div id="file-preview" class="mt-3"></div>
                        </div>
                        @elseif($paymentSettings['registration_mode'] === 'paid' && $paymentSettings['require_payment_proof'] == '0')
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                            <p class="text-sm text-yellow-700">
                                <span class="font-semibold">Catatan:</span> Bukti pembayaran tidak wajib diupload saat ini. Silakan hubungi admin untuk konfirmasi pembayaran.
                            </p>
                        </div>
                        @elseif($paymentSettings['registration_mode'] === 'free')
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-sm text-green-700">
                                <span class="font-semibold">Pendaftaran Gratis!</span> Tidak ada biaya yang perlu dibayarkan.
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex gap-4">
                        <button type="button" onclick="resetForm()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Kembali
                        </button>
                        <button type="submit" class="flex-1 apjikom-purple text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>

            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mt-6">
                <h3 class="font-bold text-gray-900 mb-4">Butuh Bantuan?</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        08118300996 / 082118476100
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        pendaftarananggotaaptikom@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function selectType(type) {
    // Update radio button
    document.getElementById('type-' + type).checked = true;
    
    // Update card styles
    document.getElementById('card-individu').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-prodi').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-' + type).classList.add('border-purple-500', 'bg-purple-50');
    
    // Set form type
    document.getElementById('form-type').value = type;
    
    // Show form
    document.getElementById('registration-form').style.display = 'block';
    
    // Show/hide prodi fields
    const prodiFields = document.getElementById('prodi-fields');
    const prodiInputs = prodiFields.querySelectorAll('input, select');
    
    if (type === 'prodi') {
        prodiFields.style.display = 'block';
        // Make prodi fields required
        prodiInputs.forEach(input => {
            if (input.name !== 'authorization_letter') {
                input.setAttribute('required', 'required');
            }
        });
    } else {
        prodiFields.style.display = 'none';
        // Remove required from prodi fields
        prodiInputs.forEach(input => {
            input.removeAttribute('required');
        });
    }
    
    // Scroll to form
    document.getElementById('registration-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetForm() {
    document.getElementById('registration-form').style.display = 'none';
    document.getElementById('card-individu').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-prodi').classList.remove('border-purple-500', 'bg-purple-50');
    document.querySelectorAll('input[name="membership_type"]').forEach(radio => radio.checked = false);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function previewFile(input) {
    const preview = document.getElementById('file-preview');
    const file = input.files[0];
    
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        preview.innerHTML = `
            <div class="flex items-center p-3 bg-gray-50 rounded border">
                <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">${fileName}</p>
                    <p class="text-xs text-gray-500">${fileSize} MB</p>
                </div>
            </div>
        `;
    }
}

// Toggle password visibility
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

// Check password strength
function checkPasswordStrength(password) {
    const strengthBar1 = document.getElementById('strength-bar-1');
    const strengthBar2 = document.getElementById('strength-bar-2');
    const strengthBar3 = document.getElementById('strength-bar-3');
    const strengthBar4 = document.getElementById('strength-bar-4');
    const strengthText = document.getElementById('strength-text');
    
    // Reset bars
    [strengthBar1, strengthBar2, strengthBar3, strengthBar4].forEach(bar => {
        bar.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500');
        bar.classList.add('bg-gray-200');
    });
    
    if (password.length === 0) {
        strengthText.textContent = 'Minimal 8 karakter';
        strengthText.className = 'text-xs text-gray-500';
        return;
    }
    
    let strength = 0;
    
    // Check length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Check for lowercase and uppercase
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    
    // Check for numbers
    if (/[0-9]/.test(password)) strength++;
    
    // Check for special characters
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Calculate final strength (max 4)
    strength = Math.min(strength, 4);
    
    // Update bars and text
    if (strength >= 1) {
        strengthBar1.classList.remove('bg-gray-200');
        strengthBar1.classList.add('bg-red-500');
        strengthText.textContent = 'Password lemah';
        strengthText.className = 'text-xs text-red-600 font-medium';
    }
    if (strength >= 2) {
        strengthBar2.classList.remove('bg-gray-200');
        strengthBar2.classList.add('bg-orange-500');
        strengthBar1.classList.remove('bg-red-500');
        strengthBar1.classList.add('bg-orange-500');
        strengthText.textContent = 'Password cukup';
        strengthText.className = 'text-xs text-orange-600 font-medium';
    }
    if (strength >= 3) {
        strengthBar3.classList.remove('bg-gray-200');
        strengthBar3.classList.add('bg-yellow-500');
        strengthBar1.classList.remove('bg-orange-500');
        strengthBar1.classList.add('bg-yellow-500');
        strengthBar2.classList.remove('bg-orange-500');
        strengthBar2.classList.add('bg-yellow-500');
        strengthText.textContent = 'Password baik';
        strengthText.className = 'text-xs text-yellow-600 font-medium';
    }
    if (strength >= 4) {
        strengthBar4.classList.remove('bg-gray-200');
        strengthBar4.classList.add('bg-green-500');
        strengthBar1.classList.remove('bg-yellow-500');
        strengthBar1.classList.add('bg-green-500');
        strengthBar2.classList.remove('bg-yellow-500');
        strengthBar2.classList.add('bg-green-500');
        strengthBar3.classList.remove('bg-yellow-500');
        strengthBar3.classList.add('bg-green-500');
        strengthText.textContent = 'Password kuat! ✓';
        strengthText.className = 'text-xs text-green-600 font-medium';
    }
}

// Check password match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    const matchText = document.getElementById('match-text');
    
    if (passwordConfirm.length === 0) {
        matchText.textContent = '';
        return;
    }
    
    if (password === passwordConfirm) {
        matchText.textContent = '✓ Password cocok';
        matchText.className = 'text-xs text-green-600 font-medium mt-1';
    } else {
        matchText.textContent = '✗ Password tidak cocok';
        matchText.className = 'text-xs text-red-600 font-medium mt-1';
    }
}

// Restore old values if validation fails
@if(old('type'))
    selectType('{{ old('type') }}');
@endif
</script>
@endsection
