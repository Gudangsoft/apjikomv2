@extends('layouts.admin')

@section('page-title', 'Pengaturan Umum')

@section('content')
<div class="max-w-5xl">
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
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, SVG. Max 2MB</p>
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
                        <p class="text-xs text-gray-500 mt-1">Format: PNG, ICO. Max 512KB</p>
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

            <!-- Social Media Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                    Media Sosial
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->get('social')?->firstWhere('key', 'facebook_url')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="https://facebook.com/apjikom">
                        @error('facebook_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Twitter/X URL</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->get('social')?->firstWhere('key', 'twitter_url')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="https://twitter.com/apjikom">
                        @error('twitter_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->get('social')?->firstWhere('key', 'instagram_url')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="https://instagram.com/apjikom">
                        @error('instagram_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->get('social')?->firstWhere('key', 'linkedin_url')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="https://linkedin.com/company/apjikom">
                        @error('linkedin_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings->get('social')?->firstWhere('key', 'youtube_url')?->value) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="https://youtube.com/@apjikom">
                        @error('youtube_url')
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
</div>
@endsection

