@extends('layouts.admin')

@section('title', 'Edit Template Kartu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-5">
        <a href="{{ route('admin.card-templates.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Two-column layout: form left, preview right --}}
    <div class="flex gap-6 items-start">

        {{-- ===== LEFT: FORM ===== --}}
        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h1 class="text-xl font-bold text-gray-900 mb-6">Edit Template Kartu Anggota</h1>

                <form id="cardTemplateForm"
                      method="POST"
                      action="{{ route('admin.card-templates.update', $cardTemplate) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Template --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Template <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $cardTemplate->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Template Background Saat Ini --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template Background Saat Ini</label>
                        <img src="{{ asset('storage/' . $cardTemplate->template_image) }}"
                             alt="{{ $cardTemplate->name }}"
                             class="max-w-lg rounded-lg shadow border">
                    </div>

                    {{-- Upload Baru --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Template Background Baru <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <input type="file" name="template_image" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                               onchange="previewTemplate(event)">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks 5MB.</p>
                        <div id="templatePreview" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-1">Preview baru:</p>
                            <img id="preview" src="" alt="Preview" class="max-w-lg rounded-lg shadow border">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea name="description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('description', $cardTemplate->description) }}</textarea>
                    </div>

                    {{-- Aktifkan --}}
                    <div class="mb-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $cardTemplate->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-sm font-medium text-gray-700">Aktifkan template ini</span>
                        </label>
                    </div>

                    {{-- Font & Typography Settings --}}
                    @include('admin.member-card-templates.partials.font-settings')

                    {{-- Actions --}}
                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" onclick="loadPreview()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Perbarui Preview Kartu
                        </button>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.card-templates.index') }}"
                               class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== RIGHT: PREVIEW PANEL ===== --}}
        <div class="w-[480px] flex-shrink-0 hidden xl:block">
            <div class="sticky top-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    {{-- Preview Header --}}
                    <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Preview Kartu</p>
                                <p class="text-xs text-gray-500">Data contoh — bukan member asli</p>
                            </div>
                        </div>
                        <button type="button" onclick="loadPreview()"
                                class="text-xs px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-1">
                            <svg id="previewSpinIcon" class="w-3.5 h-3.5 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <svg id="previewRefreshIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh
                        </button>
                    </div>

                    {{-- Preview Image Area --}}
                    <div class="p-4 bg-gray-100 min-h-[280px] flex items-center justify-center" id="previewArea">
                        {{-- Loading State --}}
                        <div id="previewLoading" class="text-center hidden">
                            <svg class="w-8 h-8 animate-spin text-indigo-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <p class="text-sm text-gray-500">Membuat preview kartu...</p>
                        </div>
                        {{-- Empty State --}}
                        <div id="previewEmpty" class="text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <p class="text-sm text-gray-500 mb-3">Preview belum dimuat</p>
                            <button type="button" onclick="loadPreview()"
                                    class="text-sm px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Tampilkan Preview
                            </button>
                        </div>
                        {{-- Error State --}}
                        <div id="previewError" class="text-center hidden">
                            <svg class="w-10 h-10 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-red-600 font-medium">Gagal membuat preview</p>
                            <p id="previewErrorMsg" class="text-xs text-red-500 mt-1"></p>
                        </div>
                        {{-- Preview Image --}}
                        <img id="previewImage" src="" alt="Preview Kartu"
                             class="w-full rounded-lg shadow-md hidden"
                             style="image-rendering: high-quality;">
                    </div>

                    {{-- Sample Data Info --}}
                    <div class="px-4 py-3 bg-gray-50 border-t">
                        <p class="text-xs text-gray-500 font-medium mb-1.5">Data contoh yang digunakan:</p>
                        <div class="text-xs text-gray-600 space-y-0.5">
                            <p><span class="font-medium">No.Anggota:</span> APJIKOM.12062026.001</p>
                            <p><span class="font-medium">Nama:</span> Dr. Ahmad Maulidizen, SE.Sy, M.Sh, MM</p>
                            <p><span class="font-medium">Institusi:</span> Universitas Dian Nusantara</p>
                            <p><span class="font-medium">Kontak:</span> 087873170896</p>
                            <p><span class="font-medium">Alamat:</span> Jln. Tanjung Duren Barat II No. 1 Grogol, Jakarta Barat 11470</p>
                            <p><span class="font-medium">Berlaku:</span> Seumur Hidup</p>
                        </div>
                    </div>

                    {{-- Download Preview --}}
                    <div class="px-4 py-3 border-t hidden" id="downloadSection">
                        <a id="downloadLink" href="#" download="preview-kartu.png"
                           class="w-full flex items-center justify-center gap-2 py-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium hover:bg-indigo-50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Preview
                        </a>
                    </div>
                </div>

                {{-- Mobile Preview Button --}}
                <button type="button" onclick="openMobilePreview()"
                        class="xl:hidden w-full mt-4 flex items-center justify-center gap-2 py-3 bg-indigo-600 text-white rounded-xl font-medium text-sm shadow-lg hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Generate &amp; Lihat Preview Kartu
                </button>
            </div>
        </div>

    </div>{{-- end two-column --}}
</div>

{{-- Mobile Preview Modal --}}
<div id="mobilePreviewModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b">
            <p class="font-bold text-gray-900">Preview Kartu Anggota</p>
            <button type="button" onclick="closeMobilePreview()" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-5">
            <div id="mobilePreviewContent" class="flex items-center justify-center min-h-48 bg-gray-100 rounded-xl">
                <p class="text-sm text-gray-500">Klik "Generate" untuk membuat preview...</p>
            </div>
            <div class="flex gap-3 mt-4">
                <button type="button" onclick="loadPreview(true)"
                        class="flex-1 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    Generate Preview
                </button>
                <button type="button" onclick="closeMobilePreview()"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const PREVIEW_URL = '{{ route('admin.card-templates.preview', $cardTemplate) }}';
const CSRF_TOKEN  = '{{ csrf_token() }}';

function getFormFontSettings() {
    const form = document.getElementById('cardTemplateForm');
    const data = new FormData(form);
    const fs   = {};

    // Collect all font_settings[*] fields
    for (const [key, value] of data.entries()) {
        if (key.startsWith('font_settings[')) {
            const fieldName = key.replace('font_settings[', '').replace(']', '');
            fs[fieldName] = value;
        }
    }

    // Ensure boolean checkboxes that are unchecked are still sent as false
    ['header_bold', 'label_bold', 'value_bold'].forEach(k => {
        if (!(k in fs)) fs[k] = 'false';
        else            fs[k] = 'true';
    });

    return fs;
}

function setPreviewState(state) {
    // states: loading | empty | error | image
    document.getElementById('previewLoading').classList.toggle('hidden', state !== 'loading');
    document.getElementById('previewEmpty').classList.toggle('hidden',   state !== 'empty');
    document.getElementById('previewError').classList.toggle('hidden',   state !== 'error');
    document.getElementById('previewImage').classList.toggle('hidden',   state !== 'image');
    document.getElementById('downloadSection').classList.toggle('hidden',state !== 'image');

    // Spinner in refresh button
    document.getElementById('previewSpinIcon').classList.toggle('hidden',    state !== 'loading');
    document.getElementById('previewRefreshIcon').classList.toggle('hidden', state === 'loading');
}

async function loadPreview(mobile = false) {
    setPreviewState('loading');

    const fs = getFormFontSettings();

    // Build form data
    const body = new FormData();
    body.append('_token', CSRF_TOKEN);
    Object.entries(fs).forEach(([k, v]) => body.append('font_settings[' + k + ']', v));

    try {
        const res  = await fetch(PREVIEW_URL, { method: 'POST', body });
        const json = await res.json();

        if (json.success) {
            const img      = document.getElementById('previewImage');
            const dlLink   = document.getElementById('downloadLink');
            img.src        = json.image;
            dlLink.href    = json.image;
            setPreviewState('image');

            if (mobile) {
                document.getElementById('mobilePreviewContent').innerHTML =
                    '<img src="' + json.image + '" class="w-full rounded-xl shadow" alt="Preview Kartu">';
            }
        } else {
            document.getElementById('previewErrorMsg').textContent = json.error || 'Terjadi kesalahan';
            setPreviewState('error');
        }
    } catch (e) {
        document.getElementById('previewErrorMsg').textContent = e.message;
        setPreviewState('error');
    }
}

function openMobilePreview() {
    document.getElementById('mobilePreviewModal').classList.remove('hidden');
    document.getElementById('mobilePreviewModal').classList.add('flex');
}

function closeMobilePreview() {
    document.getElementById('mobilePreviewModal').classList.add('hidden');
    document.getElementById('mobilePreviewModal').classList.remove('flex');
}

function previewTemplate(event) {
    const preview = document.getElementById('preview');
    const container = document.getElementById('templatePreview');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Auto-load preview on page load
document.addEventListener('DOMContentLoaded', () => loadPreview());
</script>
@endsection
