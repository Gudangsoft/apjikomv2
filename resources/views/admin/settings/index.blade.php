@extends('layouts.admin')

@section('page-title', 'Pengaturan Umum')

@section('content')
<div class="max-w-5xl">
    <!-- Tutorial Note -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-blue-800 mb-1">⚙️ Pengaturan Website</h3>
                <p class="text-sm text-blue-700 mb-2">
                    Halaman ini untuk mengatur <strong>informasi dasar website</strong> seperti nama, logo, kontak, dan social media. 
                    Perubahan akan langsung tampil di seluruh halaman website setelah disimpan.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Umum Website</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola informasi umum, logo, kontak, media sosial, dan SEO website APJIKOM</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <!-- General Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan Umum
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Website</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings->get('general')?->firstWhere('key', 'site_name')?->value ?? 'APJIKOM') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                        @error('site_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings->get('general')?->firstWhere('key', 'site_tagline')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent" 
                            placeholder="Advancing Technology for Humanity">
                        @error('site_tagline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                        <textarea name="site_description" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="Deskripsi singkat tentang APJIKOM...">{{ old('site_description', $settings->get('general')?->firstWhere('key', 'site_description')?->value) }}</textarea>
                        @error('site_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Statistics Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik Dashboard
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kepuasan (%)</label>
                        <div class="relative">
                            <input type="number" name="satisfaction_rate" min="0" max="100" step="1"
                                value="{{ old('satisfaction_rate', $settings->get('statistics')?->firstWhere('key', 'satisfaction_rate')?->value ?? 98) }}" 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" 
                                placeholder="98" required>
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500">%</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Nilai tingkat kepuasan anggota dalam persen (0-100)</p>
                        @error('satisfaction_rate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-pink-50 p-4 rounded-lg border border-pink-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-pink-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Informasi</h4>
                                <p class="text-xs text-gray-600">
                                    Nilai ini akan ditampilkan pada kartu "Tingkat Kepuasan" di dashboard admin. 
                                    Anda dapat mengupdate nilai ini berdasarkan survey atau feedback dari anggota.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo & Favicon Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Logo & Favicon
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                        @php
                            $currentLogo = $settings->get('general')?->firstWhere('key', 'site_logo')?->value;
                        @endphp
                        @if($currentLogo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $currentLogo) }}" alt="Current Logo" class="h-16 object-contain border rounded-lg p-2 bg-gray-50">
                            </div>
                        @endif
                        <input type="file" name="site_logo" accept="image/jpeg,image/png,image/jpg,image/svg+xml"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                        <x-image-hint dimensions="300×300" ratio="1:1" max-size="2MB" formats="JPG, PNG, SVG" note="Logo persegi atau landscape. Background transparan (PNG/SVG) direkomendasikan." />
                        @error('site_logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        @php
                            $currentFavicon = $settings->get('general')?->firstWhere('key', 'site_favicon')?->value;
                        @endphp
                        @if($currentFavicon)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $currentFavicon) }}" alt="Current Favicon" class="h-8 w-8 object-contain border rounded p-1 bg-gray-50">
                            </div>
                        @endif
                        <input type="file" name="site_favicon" accept="image/png,.ico"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                        <x-image-hint dimensions="64×64" ratio="1:1" max-size="512KB" formats="PNG, ICO" note="Favicon tampil sebagai ikon kecil di tab browser. Gunakan ukuran persegi." />
                        @error('site_favicon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Informasi Kontak
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings->get('contact')?->firstWhere('key', 'contact_email')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="info@apjikom.or.id">
                        @error('contact_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->get('contact')?->firstWhere('key', 'contact_phone')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="+62 21 1234567">
                        @error('contact_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="contact_address" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="Alamat lengkap organisasi...">{{ old('contact_address', $settings->get('contact')?->firstWhere('key', 'contact_address')?->value) }}</textarea>
                        @error('contact_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    SEO & Analytics
                </h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings->get('seo')?->firstWhere('key', 'meta_keywords')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="apjikom, jurnal ilmiah, komunikasi">
                        @error('meta_keywords')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="Deskripsi untuk search engine (maks 160 karakter)...">{{ old('meta_description', $settings->get('seo')?->firstWhere('key', 'meta_description')?->value) }}</textarea>
                        @error('meta_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics Code</label>
                        <textarea name="google_analytics" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent font-mono text-sm"
                            placeholder="<!-- Google Analytics tracking code -->">{{ old('google_analytics', $settings->get('seo')?->firstWhere('key', 'google_analytics')?->value) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Paste kode tracking dari Google Analytics</p>
                        @error('google_analytics')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Membership Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-1 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Pengaturan Keanggotaan
                </h3>
                <p class="text-sm text-gray-500 mb-5">Konfigurasi format nomor anggota dan aturan keanggotaan</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Awalan Nomor Anggota (Prefix)
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="member_number_prefix"
                                   value="{{ old('member_number_prefix', $settings->get('membership')?->firstWhere('key', 'member_number_prefix')?->value ?? 'APJIKOM') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 font-mono uppercase"
                                   placeholder="APJIKOM"
                                   oninput="updatePreviewNumber(this.value)">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Contoh format: <strong id="previewMemberNumber" class="text-purple-700 font-mono">{{ $settings->get('membership')?->firstWhere('key', 'member_number_prefix')?->value ?? 'APJIKOM' }}.11062026.001</strong>
                        </p>
                        @error('member_number_prefix')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-purple-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1 text-sm">Format Nomor Anggota</h4>
                                <p class="text-xs text-gray-600">
                                    Format: <code class="bg-purple-100 px-1 rounded font-mono">PREFIX.DDMMYYYY.XXX</code>
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    Nomor anggota yang <strong>sudah ada tidak akan berubah</strong> — hanya berlaku untuk anggota baru yang di-approve setelah perubahan ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t pt-6">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#00629B] to-[#0077B6] text-white rounded-lg hover:from-[#004B7A] hover:to-[#005F8D] transition-all shadow-md hover:shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pengaturan
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- ===================================================
         REGENERASI KARTU — form terpisah, di luar form utama
         =================================================== --}}
    @php
        $currentPrefix = $settings->get('membership')?->firstWhere('key', 'member_number_prefix')?->value ?? 'APJIKOM';
        $membersWithNumber = \App\Models\Member::whereNotNull('member_number')->count();
    @endphp

    <div class="bg-white rounded-lg shadow-sm mt-6 border-2 border-orange-200">
        <div class="p-6 border-b bg-orange-50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Regenerasi Kartu dengan Prefix Lama</h2>
                <p class="text-sm text-gray-600">
                    Ganti prefix nomor anggota lama dan generate ulang semua kartu anggota yang terpengaruh
                </p>
            </div>
        </div>

        <div class="p-6">
            {{-- Info stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 rounded-xl p-4 border text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $membersWithNumber }}</p>
                    <p class="text-xs text-gray-500 mt-1">Anggota punya nomor</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-200 text-center">
                    <p class="text-2xl font-bold text-purple-700 font-mono">{{ $currentPrefix }}</p>
                    <p class="text-xs text-gray-500 mt-1">Prefix aktif saat ini</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4 border border-orange-200 text-center" id="oldPrefixCountBox">
                    <p class="text-2xl font-bold text-orange-600" id="oldPrefixCount">—</p>
                    <p class="text-xs text-gray-500 mt-1">Anggota dengan prefix lama</p>
                </div>
            </div>

            {{-- Cara kerja --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 text-sm text-blue-800">
                <p class="font-semibold mb-2">Cara kerja:</p>
                <ol class="list-decimal list-inside space-y-1 text-xs text-blue-700">
                    <li>Sistem mencari semua anggota yang nomor keanggotaannya diawali dengan <strong>prefix lama</strong></li>
                    <li>Prefix lama diganti dengan prefix aktif: <code class="bg-blue-100 px-1 rounded font-mono">PREFIXLAMA.11062026.001 → {{ $currentPrefix }}.11062026.001</code></li>
                    <li>Kartu anggota di-generate ulang otomatis dengan nomor baru</li>
                    <li>Nomor urut dan tanggal <strong>tidak berubah</strong>, hanya prefix yang diganti</li>
                </ol>
            </div>

            {{-- Form regenerasi --}}
            <form method="POST" action="{{ route('admin.settings.regenerate-member-cards') }}"
                  onsubmit="return confirmRegenerate(event)">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    {{-- Prefix Lama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Prefix Lama <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="old_prefix" id="oldPrefixInput"
                                   placeholder="Contoh: APJIKOM"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 font-mono uppercase"
                                   oninput="checkOldPrefix(this.value)">
                            <span class="text-gray-400 font-mono text-lg flex-shrink-0">→</span>
                            <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg font-mono font-semibold text-sm flex-shrink-0">
                                {{ $currentPrefix }}
                            </span>
                        </div>
                        @error('old_prefix')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p id="oldPrefixHint" class="text-xs text-gray-500 mt-1">Masukkan prefix lama untuk melihat jumlah anggota yang akan terpengaruh</p>
                    </div>

                    {{-- Preview perubahan --}}
                    <div class="bg-gray-50 rounded-xl p-4 border">
                        <p class="text-xs font-medium text-gray-600 mb-2">Preview perubahan nomor:</p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs font-mono">
                                <span class="line-through text-red-500" id="previewOld">PREFIXLAMA.11062026.001</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs font-mono">
                                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                                <span class="text-green-700 font-semibold" id="previewNew">{{ $currentPrefix }}.11062026.001</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Konfirmasi --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="confirm" value="1"
                               class="w-4 h-4 text-red-600 rounded focus:ring-red-500 mt-0.5 flex-shrink-0">
                        <span class="text-sm text-red-800">
                            <strong>Saya mengerti</strong> bahwa operasi ini akan mengubah nomor anggota dan meng-generate ulang semua kartu anggota dengan prefix lama tersebut. Tindakan ini tidak dapat dibatalkan.
                        </span>
                    </label>
                    @error('confirm')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-xl font-semibold hover:bg-orange-600 transition shadow-md hover:shadow-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Generate Ulang Kartu
                    </button>
                    <p class="text-xs text-gray-500">Proses ini mungkin membutuhkan waktu beberapa menit tergantung jumlah anggota</p>
                </div>

                {{-- Error / Success session message --}}
                @if(session('success'))
                    <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800 flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-800 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

</div>
@push('scripts')
<script>
const CURRENT_PREFIX = '{{ $currentPrefix }}';

function updatePreviewNumber(prefix) {
    const clean = prefix.trim().toUpperCase() || 'APJIKOM';
    document.getElementById('previewMemberNumber').textContent = clean + '.11062026.001';
}

function checkOldPrefix(val) {
    const old = val.trim().toUpperCase();
    const dateEx = '11062026';

    document.getElementById('previewOld').textContent = (old || 'PREFIXLAMA') + '.' + dateEx + '.001';
    document.getElementById('previewNew').textContent = CURRENT_PREFIX + '.' + dateEx + '.001';

    if (!old) {
        document.getElementById('oldPrefixCount').textContent = '—';
        document.getElementById('oldPrefixHint').textContent  = 'Masukkan prefix lama untuk melihat jumlah anggota yang akan terpengaruh';
        return;
    }

    // AJAX check count
    fetch('{{ route('admin.settings.index') }}?check_prefix=' + encodeURIComponent(old), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).catch(() => null);

    // Optimistic: just show the typed prefix in count box label
    document.getElementById('oldPrefixCount').textContent = '...';
    document.getElementById('oldPrefixHint').textContent  = 'Semua anggota dengan nomor diawali "' + old + '" akan diproses';
}

function confirmRegenerate(e) {
    const old = document.getElementById('oldPrefixInput').value.trim().toUpperCase();
    if (!old) {
        alert('Masukkan prefix lama terlebih dahulu.');
        e.preventDefault();
        return false;
    }
    if (old === CURRENT_PREFIX) {
        alert('Prefix lama sama dengan prefix aktif (' + CURRENT_PREFIX + '). Tidak ada yang perlu diubah.');
        e.preventDefault();
        return false;
    }
    const confirmed = confirm(
        'KONFIRMASI\n\n' +
        'Anda akan mengganti prefix nomor anggota:\n' +
        '"' + old + '" → "' + CURRENT_PREFIX + '"\n\n' +
        'Semua kartu anggota dengan prefix tersebut akan di-generate ulang.\n\n' +
        'Lanjutkan?'
    );
    if (!confirmed) {
        e.preventDefault();
        return false;
    }
    // Show loading state
    e.target.querySelector('button[type=submit]').disabled = true;
    e.target.querySelector('button[type=submit]').textContent = 'Sedang memproses...';
    return true;
}
</script>
@endpush
@endsection

