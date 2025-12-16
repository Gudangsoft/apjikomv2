@extends('layouts.admin')

@section('page-title', 'Pengaturan Menu Footer')

@section('content')
<div class="max-w-6xl">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Menu Footer</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola menu dan tautan yang tampil di footer website</p>
        </div>

        <form method="POST" action="{{ route('admin.footer-settings.update') }}" class="p-6">
            @csrf
            @method('PUT')

            <!-- Preview Footer -->
            <div class="mb-8 p-6 bg-gradient-to-r from-purple-900 to-purple-800 rounded-lg">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview Footer
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white text-sm">
                    <div>
                        <h4 class="font-semibold mb-2 text-purple-200">Kolom 1: {{ old('footer_menu1_title', $settings->firstWhere('key', 'footer_menu1_title')?->value ?? 'Menu') }}</h4>
                        <ul class="space-y-1 text-purple-300">
                            <li>• {{ old('footer_menu1_item1_label', $settings->firstWhere('key', 'footer_menu1_item1_label')?->value ?? 'Item 1') }}</li>
                            <li>• {{ old('footer_menu1_item2_label', $settings->firstWhere('key', 'footer_menu1_item2_label')?->value ?? 'Item 2') }}</li>
                            <li>• {{ old('footer_menu1_item3_label', $settings->firstWhere('key', 'footer_menu1_item3_label')?->value ?? 'Item 3') }}</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2 text-purple-200">Kolom 2: {{ old('footer_menu2_title', $settings->firstWhere('key', 'footer_menu2_title')?->value ?? 'Layanan') }}</h4>
                        <ul class="space-y-1 text-purple-300">
                            <li>• {{ old('footer_menu2_item1_label', $settings->firstWhere('key', 'footer_menu2_item1_label')?->value ?? 'Item 1') }}</li>
                            <li>• {{ old('footer_menu2_item2_label', $settings->firstWhere('key', 'footer_menu2_item2_label')?->value ?? 'Item 2') }}</li>
                            <li>• {{ old('footer_menu2_item3_label', $settings->firstWhere('key', 'footer_menu2_item3_label')?->value ?? 'Item 3') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Menu Column 1 -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Kolom Menu 1
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kolom 1</label>
                        <input type="text" name="footer_menu1_title" 
                            value="{{ old('footer_menu1_title', $settings->firstWhere('key', 'footer_menu1_title')?->value ?? 'Menu') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Menu">
                        @error('footer_menu1_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @for($i = 1; $i <= 5; $i++)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Item {{ $i }} - Label</label>
                            <input type="text" name="footer_menu1_item{{ $i }}_label" 
                                value="{{ old('footer_menu1_item'.$i.'_label', $settings->firstWhere('key', 'footer_menu1_item'.$i.'_label')?->value) }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Label menu {{ $i }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Item {{ $i }} - URL</label>
                            <input type="text" name="footer_menu1_item{{ $i }}_url" 
                                value="{{ old('footer_menu1_item'.$i.'_url', $settings->firstWhere('key', 'footer_menu1_item'.$i.'_url')?->value) }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="/url atau https://...">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Menu Column 2 -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Kolom Menu 2
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kolom 2</label>
                        <input type="text" name="footer_menu2_title" 
                            value="{{ old('footer_menu2_title', $settings->firstWhere('key', 'footer_menu2_title')?->value ?? 'Layanan') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Layanan">
                        @error('footer_menu2_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @for($i = 1; $i <= 5; $i++)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Item {{ $i }} - Label</label>
                            <input type="text" name="footer_menu2_item{{ $i }}_label" 
                                value="{{ old('footer_menu2_item'.$i.'_label', $settings->firstWhere('key', 'footer_menu2_item'.$i.'_label')?->value) }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Label menu {{ $i }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Item {{ $i }} - URL</label>
                            <input type="text" name="footer_menu2_item{{ $i }}_url" 
                                value="{{ old('footer_menu2_item'.$i.'_url', $settings->firstWhere('key', 'footer_menu2_item'.$i.'_url')?->value) }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="/url atau https://...">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Footer Copyright -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Teks Copyright
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Teks Copyright Footer</label>
                    <input type="text" name="footer_copyright_text" 
                        value="{{ old('footer_copyright_text', $settings->firstWhere('key', 'footer_copyright_text')?->value ?? 'All Rights Reserved') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="All Rights Reserved">
                    <p class="text-xs text-gray-500 mt-1">Tahun otomatis akan ditampilkan. Contoh: © 2025 APJIKOM. [Teks ini]</p>
                    @error('footer_copyright_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold mb-1">Catatan Penting:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600">
                            <li>Kolom 1 dan 2 akan tampil di footer bersama dengan Logo dan Kontak</li>
                            <li>Biarkan kosong jika tidak ingin menampilkan item tertentu</li>
                            <li>URL bisa menggunakan path relatif (/berita) atau URL lengkap (https://...)</li>
                            <li>Informasi Kontak diatur di menu "Pengaturan Umum"</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6 border-t">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all shadow-md hover:shadow-lg">
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
