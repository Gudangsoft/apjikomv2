@extends('layouts.admin')

@section('page-title', 'URL Halaman Login')

@section('content')
<div class="max-w-2xl">

    {{-- Info Banner --}}
    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-yellow-800 mb-1">Perhatian Sebelum Mengubah URL Login</h3>
                <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
                    <li>Setelah diubah, URL lama tidak akan bisa diakses lagi.</li>
                    <li>Catat URL baru sebelum menyimpan perubahan.</li>
                    <li>URL hanya boleh menggunakan huruf kecil, angka, dan tanda hubung (-).</li>
                    <li>Contoh: <code class="bg-yellow-100 px-1 rounded">login-admin-apjikom</code></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-start">
        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <p class="text-sm font-semibold text-red-800 mb-1">Terdapat kesalahan:</p>
        <ul class="text-sm text-red-700 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-900">URL Halaman Login Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Ubah URL yang digunakan untuk mengakses halaman login admin panel.</p>
        </div>

        <div class="p-6">
            {{-- Current URL Display --}}
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">URL Login Saat Ini</p>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    <a href="{{ url($currentUrl) }}" target="_blank" class="text-sm font-mono text-blue-600 hover:underline break-all">
                        {{ url($currentUrl) }}
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.login-url.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="admin_login_url" class="block text-sm font-semibold text-gray-700 mb-2">
                        URL Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center rounded-lg border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500">
                        <span class="px-3 py-2.5 bg-gray-100 text-gray-500 text-sm border-r border-gray-300 whitespace-nowrap flex-shrink-0">
                            {{ url('/') }}/
                        </span>
                        <input
                            type="text"
                            id="admin_login_url"
                            name="admin_login_url"
                            value="{{ old('admin_login_url', $currentUrl) }}"
                            class="flex-1 px-3 py-2.5 text-sm font-mono bg-white focus:outline-none @error('admin_login_url') border-red-500 @enderror"
                            placeholder="admin-panel-apjikom"
                            autocomplete="off"
                            spellcheck="false"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Hanya huruf kecil (a-z), angka (0-9), dan tanda hubung (-). Minimal 5 karakter.
                    </p>
                    @error('admin_login_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Live Preview --}}
                <div class="mb-6 p-3 bg-purple-50 rounded-lg border border-purple-200">
                    <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-1">Preview URL Baru</p>
                    <p class="text-sm font-mono text-purple-800 break-all" id="url-preview">{{ url('/') }}/{{ old('admin_login_url', $currentUrl) }}</p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        &larr; Kembali ke Pengaturan
                    </a>
                    <button type="submit"
                        onclick="return confirm('Pastikan Anda sudah mencatat URL baru. Setelah disimpan, URL lama tidak bisa diakses. Lanjutkan?')"
                        class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan URL Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- History / Info --}}
    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-xs text-blue-700">
            <strong>Tips:</strong> Gunakan URL yang unik dan tidak mudah ditebak untuk meningkatkan keamanan halaman login admin.
            Contoh: <code class="bg-blue-100 px-1 rounded">apjikom-admin-2024</code> atau <code class="bg-blue-100 px-1 rounded">panel-masuk-admin</code>
        </p>
    </div>

</div>

<script>
    const input = document.getElementById('admin_login_url');
    const preview = document.getElementById('url-preview');
    const baseUrl = '{{ url('/') }}/';

    input.addEventListener('input', function () {
        // Auto lowercase and replace spaces with hyphens
        let val = this.value.toLowerCase().replace(/\s+/g, '-');
        this.value = val;
        preview.textContent = baseUrl + val;
    });
</script>
@endsection
