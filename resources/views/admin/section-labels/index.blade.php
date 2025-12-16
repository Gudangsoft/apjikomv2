@extends('layouts.admin')

@section('title', 'Kelola Label Section')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Label Section</h1>
        <p class="text-gray-600 mt-1">Ubah label/judul untuk setiap section di website</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.section-labels.bulk-update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="space-y-6">
                    @foreach($labels as $label)
                    <div class="border-b pb-4 last:border-b-0">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kunci Setting
                                </label>
                                <p class="text-sm text-gray-500 font-mono bg-gray-50 p-2 rounded">
                                    {{ $label->key }}
                                </p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="label_{{ $label->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Label / Judul
                                </label>
                                <input 
                                    type="text" 
                                    id="label_{{ $label->id }}"
                                    name="labels[{{ $label->id }}]" 
                                    value="{{ old('labels.' . $label->id, $label->value) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required
                                >
                                @error('labels.' . $label->id)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                @php
                                $descriptions = [
                                    'section_label_about' => 'Label untuk section Tentang di halaman home',
                                    'section_label_benefits' => 'Label untuk section Keuntungan menjadi anggota',
                                    'section_label_partners' => 'Label untuk section daftar partner',
                                    'section_label_partners_subtitle' => 'Subtitle di bawah judul section partner',
                                    'section_label_cta' => 'Label untuk section call-to-action pendaftaran',
                                    'section_label_latest_news' => 'Label untuk section berita terbaru',
                                    'section_label_upcoming_events' => 'Label untuk section event mendatang',
                                    'section_label_members' => 'Label untuk section daftar anggota',
                                    'section_label_categories' => 'Label untuk section kategori',
                                    'section_label_registration' => 'Label untuk halaman pendaftaran',
                                ];
                                $description = $descriptions[$label->key] ?? 'Tidak ada deskripsi';
                                @endphp
                                
                                <p class="text-xs text-gray-500 mt-1">
                                    <strong>Deskripsi:</strong> {{ $description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-lg">
                <p class="text-sm text-gray-600">
                    <strong>Total:</strong> {{ $labels->count() }} label section
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                        Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">📖 Panduan Penggunaan</h3>
        <ul class="space-y-2 text-sm text-blue-800">
            <li>✅ Label section ini akan muncul di berbagai halaman website</li>
            <li>✅ Perubahan akan langsung terlihat setelah disimpan</li>
            <li>✅ Gunakan teks yang jelas dan deskriptif</li>
            <li>✅ Maksimal 255 karakter per label</li>
        </ul>
        
        <div class="mt-4 p-4 bg-white rounded border border-blue-200">
            <h4 class="font-semibold text-blue-900 mb-2">🎨 Cara Menambah Section Baru:</h4>
            <ol class="list-decimal list-inside space-y-1 text-sm text-blue-800">
                <li>Tambahkan setting baru di <code class="bg-blue-100 px-1 rounded">SectionLabelsSeeder.php</code></li>
                <li>Jalankan: <code class="bg-blue-100 px-1 rounded">php artisan db:seed --class=SectionLabelsSeeder</code></li>
                <li>Gunakan component: <code class="bg-blue-100 px-1 rounded">&lt;x-section-heading setting-key="nama_key" /&gt;</code></li>
            </ol>
        </div>
    </div>
</div>
@endsection
