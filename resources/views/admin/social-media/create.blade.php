@extends('layouts.admin')

@section('page-title', 'Tambah Media Sosial')

@section('content')
<div class="max-w-3xl">

    <div class="mb-5">
        <a href="{{ route('admin.social-media.index') }}" class="text-sm text-gray-500 hover:text-purple-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Media Sosial
        </a>
    </div>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <ul class="text-sm text-red-700 space-y-1">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.social-media.store') }}" method="POST" enctype="multipart/form-data" id="smForm">
        @csrf

        <div class="bg-white rounded-xl shadow-sm">
            {{-- Header --}}
            <div class="p-5 border-b">
                <h1 class="text-lg font-bold text-gray-900">Tambah Media Sosial</h1>
                <p class="text-sm text-gray-500 mt-0.5">Pilih platform atau buat custom untuk platform baru</p>
            </div>

            <div class="p-6 space-y-6">

                {{-- STEP 1: Platform Picker --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Platform</label>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-3" id="platformGrid">
                        @php
                        $platforms = [
                            ['name' => 'Facebook',  'color' => '#1877F2', 'svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'],
                            ['name' => 'Instagram', 'color' => '#E1306C', 'svg' => '<defs><linearGradient id="ig" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#fd5949"/><stop offset="50%" style="stop-color:#d6249f"/><stop offset="100%" style="stop-color:#285AEB"/></linearGradient></defs><path fill="url(#ig)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>'],
                            ['name' => 'Twitter / X', 'color' => '#000000', 'svg' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
                            ['name' => 'YouTube',   'color' => '#FF0000', 'svg' => '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>'],
                            ['name' => 'LinkedIn',  'color' => '#0A66C2', 'svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
                            ['name' => 'TikTok',    'color' => '#010101', 'svg' => '<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>'],
                            ['name' => 'WhatsApp',  'color' => '#25D366', 'svg' => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>'],
                            ['name' => 'Telegram',  'color' => '#26A5E4', 'svg' => '<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>'],
                        ];
                        @endphp

                        @foreach($platforms as $p)
                        <button type="button"
                            onclick="selectPlatform('{{ $p['name'] }}', '{{ $p['color'] }}')"
                            data-name="{{ $p['name'] }}"
                            class="platform-tile group flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" style="background-color: {{ $p['color'] }}">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">{!! $p['svg'] !!}</svg>
                            </div>
                            <span class="text-xs font-medium text-gray-600 group-hover:text-purple-600 text-center leading-tight">{{ $p['name'] }}</span>
                        </button>
                        @endforeach

                        {{-- Custom --}}
                        <button type="button"
                            onclick="selectPlatform('custom', '')"
                            data-name="custom"
                            class="platform-tile group flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center shadow-sm group-hover:bg-gray-300">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <span class="text-xs font-medium text-gray-600 group-hover:text-purple-600 text-center leading-tight">Custom</span>
                        </button>
                    </div>
                </div>

                {{-- Nama Platform --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Platform <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Facebook, Instagram, Threads..."
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-400 bg-red-50 @enderror">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        URL / Link <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="url" id="url" value="{{ old('url') }}" required
                        placeholder="https://facebook.com/namahalaman"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('url') border-red-400 bg-red-50 @enderror">
                    @error('url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-500 mt-1">Sertakan https:// di awal URL</p>
                </div>

                {{-- Custom Icon (hanya tampil jika platform custom) --}}
                <div id="customIconSection" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Icon Custom</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-purple-400 transition-colors">
                        <input type="file" name="icon" id="iconUpload" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp"
                            class="hidden" onchange="previewCustomIcon(event)">
                        <div id="iconUploadPlaceholder" onclick="document.getElementById('iconUpload').click()" class="cursor-pointer">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-600 font-medium">Klik untuk upload icon</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG, WebP · Maks 2MB</p>
                        </div>
                        <div id="iconPreviewBox" class="hidden">
                            <img id="iconPreviewImg" src="" alt="Preview" class="w-16 h-16 object-contain mx-auto rounded-lg border">
                            <button type="button" onclick="clearIcon()" class="mt-2 text-xs text-red-500 hover:text-red-700">Hapus</button>
                        </div>
                    </div>
                    @error('icon')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                    <div class="mt-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Warna Background Icon</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="icon_class" id="iconColor" value="{{ old('icon_class', '#6366f1') }}"
                                class="h-9 w-16 rounded border border-gray-300 cursor-pointer p-0.5">
                            <span class="text-xs text-gray-500">Warna yang muncul di footer & profil member</span>
                        </div>
                    </div>
                </div>

                {{-- Preview --}}
                <div id="previewSection" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Preview Tampilan</label>
                    <div class="flex items-center gap-3 p-3 bg-gray-800 rounded-lg w-fit">
                        <div id="previewBadge" class="w-9 h-9 rounded-full flex items-center justify-center">
                            <svg id="previewSvg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"></svg>
                        </div>
                        <span class="text-xs text-white font-medium" id="previewName">Platform</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Tampilan di footer website</p>
                </div>

                {{-- Note --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="note" value="{{ old('note') }}"
                        placeholder="Contoh: Halaman resmi APJIKOM"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                {{-- Urutan & Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                        <p class="text-xs text-gray-500 mt-1">Angka kecil = tampil lebih awal</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                        <div class="flex items-center gap-2 mt-2.5">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <label for="is_active" class="text-sm text-gray-700">Aktifkan</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="p-5 border-t flex gap-3">
                <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2.5 px-4 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Media Sosial
                </button>
                <a href="{{ route('admin.social-media.index') }}"
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
const platformSvgs = {
    'facebook':  '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
    'instagram': '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>',
    'twitter':   '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>',
    'youtube':   '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>',
    'linkedin':  '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>',
    'tiktok':    '<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>',
    'whatsapp':  '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>',
    'telegram':  '<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>',
};

const platformColors = {
    'facebook': '#1877F2', 'instagram': '#E1306C', 'twitter': '#000000',
    'youtube': '#FF0000', 'linkedin': '#0A66C2', 'tiktok': '#010101',
    'whatsapp': '#25D366', 'telegram': '#26A5E4',
};

function selectPlatform(name, color) {
    // Highlight active tile
    document.querySelectorAll('.platform-tile').forEach(t => {
        t.classList.remove('border-purple-500', 'bg-purple-50', 'ring-2', 'ring-purple-300');
        t.classList.add('border-gray-200');
    });
    const tile = [...document.querySelectorAll('.platform-tile')].find(t => t.dataset.name === name);
    if (tile) {
        tile.classList.remove('border-gray-200');
        tile.classList.add('border-purple-500', 'bg-purple-50', 'ring-2', 'ring-purple-300');
    }

    const isCustom = name === 'custom';
    document.getElementById('customIconSection').classList.toggle('hidden', !isCustom);
    document.getElementById('previewSection').classList.toggle('hidden', isCustom);

    if (!isCustom) {
        document.getElementById('name').value = name;

        const key = name.toLowerCase().replace(' / ', '').replace(' ', '');
        const svg = platformSvgs[key] || platformSvgs['twitter'];
        const bgColor = color || '#6366f1';

        document.getElementById('previewSvg').innerHTML = svg;
        document.getElementById('previewBadge').style.backgroundColor = bgColor + '33'; // semi-transparent bg
        document.getElementById('previewBadge').style.border = '1px solid ' + bgColor + '66';
        document.getElementById('previewSvg').style.color = 'white';
        document.getElementById('previewBadge').style.backgroundColor = bgColor;
        document.getElementById('previewName').textContent = name;
    } else {
        document.getElementById('name').value = '';
        document.getElementById('name').focus();
    }
}

function previewCustomIcon(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('iconPreviewImg').src = e.target.result;
        document.getElementById('iconPreviewBox').classList.remove('hidden');
        document.getElementById('iconUploadPlaceholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

function clearIcon() {
    document.getElementById('iconUpload').value = '';
    document.getElementById('iconPreviewBox').classList.add('hidden');
    document.getElementById('iconUploadPlaceholder').classList.remove('hidden');
}
</script>
@endpush
@endsection
