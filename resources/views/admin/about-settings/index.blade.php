@extends('layouts.admin')

@section('page-title', 'Pengaturan Section Tentang')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Section Tentang</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola konten dan fitur-fitur pada section About/Tentang APJIKOM</p>
        </div>

        <form method="POST" action="{{ route('admin.about-settings.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <!-- About Section Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Konten Section Tentang
                </h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Tentang APJIKOM</label>
                        @php
                            $currentAboutImage = $settings->firstWhere('key', 'about_image')?->value;
                        @endphp
                        @if($currentAboutImage)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $currentAboutImage) }}" alt="About Image" class="h-48 w-auto object-cover border rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="about_image" accept="image/jpeg,image/png,image/jpg"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max 2MB. Rekomendasi: 800x600px</p>
                        @error('about_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tag/Nama Singkat</label>
                        <input type="text" name="about_tag" 
                            value="{{ old('about_tag', $settings->firstWhere('key', 'about_tag')?->value ?? 'APJIKOM') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="APJIKOM">
                        <p class="text-xs text-gray-500 mt-1">Tag singkat yang muncul di atas judul section About</p>
                        @error('about_tag')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Section About</label>
                        <input type="text" name="section_label_about" 
                            value="{{ old('section_label_about', $settings->firstWhere('key', 'section_label_about')?->value ?? 'Asosiasi Pengelola Jurnal Informatika dan Komputer') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="Asosiasi Pengelola Jurnal Informatika dan Komputer">
                        <p class="text-xs text-gray-500 mt-1">Judul lengkap yang muncul di section About</p>
                        @error('section_label_about')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tentang APJIKOM</label>
                        <textarea name="about_description" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="APJIKOM adalah asosiasi yang mewadahi...">{{ old('about_description', $settings->firstWhere('key', 'about_description')?->value ?? 'APJIKOM adalah asosiasi yang mewadahi pengelola jurnal ilmiah di Indonesia yang memiliki rumpun ilmu informatika dan komputer. Kami bertujuan untuk meningkatkan kualitas publikasi ilmiah, penelitian dan pengabdian kepada masyarakat di bidang teknologi informasi dan komputer.') }}</textarea>
                        @error('about_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- About Features Settings -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00629B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Fitur-Fitur About Section
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1: Kolaborasi -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Feature 1: Kolaborasi</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                                <input type="text" name="about_feature1_title" value="{{ old('about_feature1_title', $settings->firstWhere('key', 'about_feature1_title')?->value ?? 'Kolaborasi') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                                <textarea name="about_feature1_desc" rows="3" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">{{ old('about_feature1_desc', $settings->firstWhere('key', 'about_feature1_desc')?->value ?? 'Menekankan kerja sama antara perguruan tinggi, industri, dan pemerintah untuk mengembangkan publikasi ilmiah.') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2: Inovasi -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Feature 2: Inovasi</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                                <input type="text" name="about_feature2_title" value="{{ old('about_feature2_title', $settings->firstWhere('key', 'about_feature2_title')?->value ?? 'Inovasi') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                                <textarea name="about_feature2_desc" rows="3" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">{{ old('about_feature2_desc', $settings->firstWhere('key', 'about_feature2_desc')?->value ?? 'Menekankan pengembangan dan penerapan teknologi terbaru dalam publikasi dan pengelolaan jurnal ilmiah.') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3: Bermanfaat -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Feature 3: Bermanfaat</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                                <input type="text" name="about_feature3_title" value="{{ old('about_feature3_title', $settings->firstWhere('key', 'about_feature3_title')?->value ?? 'Bermanfaat') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                                <textarea name="about_feature3_desc" rows="3" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent">{{ old('about_feature3_desc', $settings->firstWhere('key', 'about_feature3_desc')?->value ?? 'Menekankan kontribusi nyata dalam publikasi, riset, dan pengabdian masyarakat melalui teknologi dan kolaborasi.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Badge Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                    <div class="border rounded-lg p-4 bg-cyan-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Statistik Kiri (Tahun Berkiprah)</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Angka</label>
                                <input type="text" name="about_stat1_number" value="{{ old('about_stat1_number', $settings->firstWhere('key', 'about_stat1_number')?->value ?? '25') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                                    placeholder="25">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Label</label>
                                <input type="text" name="about_stat1_label" value="{{ old('about_stat1_label', $settings->firstWhere('key', 'about_stat1_label')?->value ?? 'Tahun Berkiprah') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                                    placeholder="Tahun Berkiprah">
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg p-4 bg-purple-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Statistik Kanan (Penghargaan)</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Angka (gunakan + untuk awalan)</label>
                                <input type="text" name="about_stat2_number" value="{{ old('about_stat2_number', $settings->firstWhere('key', 'about_stat2_number')?->value ?? '+68') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                                    placeholder="+68">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Label</label>
                                <input type="text" name="about_stat2_label" value="{{ old('about_stat2_label', $settings->firstWhere('key', 'about_stat2_label')?->value ?? 'Penghargaan') }}" 
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                                    placeholder="Penghargaan">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Button Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Label Tombol CTA</label>
                        <input type="text" name="about_cta_label" value="{{ old('about_cta_label', $settings->firstWhere('key', 'about_cta_label')?->value ?? 'Bergabung Sekarang') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="Bergabung Sekarang">
                        @error('about_cta_label')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Tombol CTA</label>
                        <input type="text" name="about_cta_link" value="{{ old('about_cta_link', $settings->firstWhere('key', 'about_cta_link')?->value ?? '/daftar-anggota') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00629B] focus:border-transparent"
                            placeholder="/daftar-anggota atau https://example.com">
                        <p class="text-xs text-gray-500 mt-1">Gunakan path relatif (/daftar-anggota) atau URL lengkap (https://...)</p>
                        @error('about_cta_link')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6 border-t">
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
