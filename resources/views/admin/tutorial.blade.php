@extends('layouts.admin')

@section('page-title', 'Panduan Penggunaan')

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl p-6 text-white">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Panduan Penggunaan Sistem</h1>
                <p class="text-purple-200 mt-1">Pelajari cara mengelola setiap fitur di panel admin APJIKOM</p>
            </div>
        </div>
    </div>

    {{-- Quick Nav --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Daftar Isi</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm">
            @php
            $sections = [
                ['id'=>'dashboard',    'label'=>'Dashboard',        'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['id'=>'konten',       'label'=>'Konten Website',   'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['id'=>'keanggotaan',  'label'=>'Keanggotaan',      'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['id'=>'tampilan',     'label'=>'Tampilan',         'icon'=>'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm12 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],
                ['id'=>'users',        'label'=>'Manajemen User',   'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['id'=>'pengaturan',   'label'=>'Pengaturan',       'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                ['id'=>'media-sosial', 'label'=>'Media Sosial',     'icon'=>'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z'],
                ['id'=>'changelog',    'label'=>'Changelog',        'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['id'=>'tips',         'label'=>'Tips Penting',     'icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
            ];
            @endphp
            @foreach($sections as $s)
            <a href="#{{ $s['id'] }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/>
                </svg>
                {{ $s['label'] }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- 1. Dashboard --}}
    <div id="dashboard" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-blue-50 border-b border-blue-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h2 class="font-bold text-blue-800 text-base">Dashboard</h2>
        </div>
        <div class="p-6 text-sm text-gray-700 space-y-3">
            <p>Dashboard adalah halaman utama setelah login. Menampilkan ringkasan statistik sistem secara real-time.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="font-semibold text-gray-800 mb-1">Kartu Statistik</p>
                    <p class="text-gray-600">Total anggota, berita, kegiatan, dan permohonan pendaftaran yang masuk.</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="font-semibold text-gray-800 mb-1">Aktivitas Terbaru</p>
                    <p class="text-gray-600">Log aktivitas terbaru dari admin dan perubahan data sistem.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Konten Website --}}
    <div id="konten" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-green-50 border-b border-green-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="font-bold text-green-800 text-base">Konten Website</h2>
        </div>
        <div class="p-6 space-y-5 text-sm text-gray-700">

            <x-tutorial-item title="Berita" icon="📰">
                <ol class="list-decimal list-inside space-y-1 text-gray-600">
                    <li>Klik <strong>Konten Website → Berita</strong> di sidebar</li>
                    <li>Klik <strong>Tambah Berita</strong> untuk membuat berita baru</li>
                    <li>Isi judul, isi berita (editor), kategori, dan upload gambar thumbnail</li>
                    <li>Centang <strong>Publikasikan</strong> agar berita tampil di website</li>
                    <li>Klik <strong>Simpan</strong></li>
                </ol>
                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-800">
                    <strong>Tips:</strong> Gambar thumbnail ideal berukuran <strong>1200×630 px</strong> (rasio 16:9). Berita yang tidak dipublikasikan tidak tampil di website.
                </div>
            </x-tutorial-item>

            <x-tutorial-item title="Kegiatan / Event" icon="📅">
                <ol class="list-decimal list-inside space-y-1 text-gray-600">
                    <li>Masuk ke <strong>Konten Website → Kegiatan</strong></li>
                    <li>Klik <strong>Tambah Kegiatan</strong></li>
                    <li>Isi nama, deskripsi, tanggal, lokasi, dan kapasitas peserta</li>
                    <li>Atur harga tiket (kosongkan jika gratis)</li>
                    <li>Upload gambar banner kegiatan <em>(1920×800 px)</em></li>
                    <li>Publikasikan dan simpan</li>
                </ol>
                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-800">
                    <strong>Catatan:</strong> Peserta yang mendaftar akan muncul di halaman detail kegiatan. Sertifikat bisa digenerate otomatis jika template sertifikat sudah diatur.
                </div>
            </x-tutorial-item>

            <x-tutorial-item title="FAQ & Testimoni" icon="💬">
                <p class="text-gray-600">Kelola pertanyaan umum (FAQ) dan testimoni anggota yang tampil di halaman beranda.</p>
                <ul class="list-disc list-inside mt-1 space-y-1 text-gray-600">
                    <li>FAQ: pertanyaan & jawaban, bisa diurutkan</li>
                    <li>Testimoni: nama, foto, jabatan, dan isi testimoni</li>
                    <li>Keduanya bisa diaktifkan/nonaktifkan tanpa menghapus data</li>
                </ul>
            </x-tutorial-item>

            <x-tutorial-item title="Galeri" icon="🖼️">
                <p class="text-gray-600">Upload foto kegiatan atau dokumentasi untuk ditampilkan di halaman Galeri website.</p>
                <p class="mt-1 text-gray-600">Gambar dapat dikelompokkan berdasarkan album/kategori. Format: JPG, PNG · Maks 5MB.</p>
            </x-tutorial-item>

        </div>
    </div>

    {{-- 3. Keanggotaan --}}
    <div id="keanggotaan" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-purple-50 border-b border-purple-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="font-bold text-purple-800 text-base">Keanggotaan</h2>
        </div>
        <div class="p-6 space-y-5 text-sm text-gray-700">

            <x-tutorial-item title="Kelola Anggota" icon="👤">
                <ol class="list-decimal list-inside space-y-1 text-gray-600">
                    <li>Buka <strong>Keanggotaan → Data Anggota</strong></li>
                    <li>Lihat daftar semua anggota beserta status keanggotaan</li>
                    <li>Klik <strong>Edit</strong> untuk mengubah data, status, atau tipe keanggotaan</li>
                    <li>Gunakan filter Status / Tipe untuk mempercepat pencarian</li>
                </ol>
                <div class="mt-2 p-3 bg-purple-50 border border-purple-200 rounded-lg text-xs text-purple-800">
                    <strong>Status Anggota:</strong> <em>Active</em> = bisa login dan akses dashboard member. <em>Inactive / Expired</em> = akses dibatasi.
                </div>
            </x-tutorial-item>

            <x-tutorial-item title="Pendaftaran Masuk" icon="📋">
                <p class="text-gray-600">Calon anggota yang mendaftar melalui website akan muncul di <strong>Keanggotaan → Pendaftaran</strong>.</p>
                <ol class="list-decimal list-inside mt-1 space-y-1 text-gray-600">
                    <li>Tinjau data pendaftar</li>
                    <li>Klik <strong>Approve</strong> untuk menerima atau <strong>Reject</strong> untuk menolak</li>
                    <li>Jika di-approve, akun member akan aktif otomatis</li>
                </ol>
            </x-tutorial-item>

            <x-tutorial-item title="Kartu Anggota & Sertifikat" icon="🪪">
                <p class="text-gray-600">Atur template kartu anggota dan sertifikat di sub-menu masing-masing. Template menggunakan format gambar dengan placeholder teks.</p>
                <p class="mt-1 text-gray-600">Setelah template diatur, admin bisa generate kartu/sertifikat untuk setiap anggota.</p>
            </x-tutorial-item>

        </div>
    </div>

    {{-- 4. Tampilan --}}
    <div id="tampilan" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-orange-50 border-b border-orange-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm12 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
            </div>
            <h2 class="font-bold text-orange-800 text-base">Tampilan Website</h2>
        </div>
        <div class="p-6 space-y-5 text-sm text-gray-700">

            <x-tutorial-item title="Slider / Banner Beranda" icon="🖼️">
                <ol class="list-decimal list-inside space-y-1 text-gray-600">
                    <li>Buka <strong>Tampilan → Slider</strong></li>
                    <li>Klik <strong>Tambah Slider</strong></li>
                    <li>Upload gambar banner ukuran <strong>1920×800 px</strong></li>
                    <li>Isi judul dan deskripsi (opsional)</li>
                    <li>Atur nomor urut — angka kecil tampil lebih awal</li>
                </ol>
                <div class="mt-2 p-3 bg-orange-50 border border-orange-200 rounded-lg text-xs text-orange-800">
                    <strong>Penting:</strong> Simpan konten utama di bagian tengah gambar agar tidak terpotong di layar HP. Rasio ideal <strong>12:5</strong>.
                </div>
            </x-tutorial-item>

            <x-tutorial-item title="Menu Navigasi" icon="☰">
                <p class="text-gray-600">Kelola menu navigasi website di <strong>Tampilan → Menu</strong>. Bisa menambahkan tautan ke halaman internal atau URL eksternal.</p>
            </x-tutorial-item>

            <x-tutorial-item title="Halaman Statis" icon="📄">
                <p class="text-gray-600">Buat halaman baru seperti "Tentang Kami", "Kebijakan Privasi", dll. di <strong>Tampilan → Halaman</strong>. Halaman yang dibuat akan otomatis bisa diakses dari menu.</p>
            </x-tutorial-item>

            <x-tutorial-item title="Tema & Warna" icon="🎨">
                <p class="text-gray-600">Ubah warna utama, gelap, dan footer website di <strong>Tampilan → Tema</strong> tanpa harus mengedit kode. Perubahan langsung berlaku ke seluruh website.</p>
            </x-tutorial-item>

        </div>
    </div>

    {{-- 5. Media Sosial --}}
    <div id="media-sosial" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-pink-50 border-b border-pink-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-pink-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
            </div>
            <h2 class="font-bold text-pink-800 text-base">Media Sosial</h2>
        </div>
        <div class="p-6 space-y-4 text-sm text-gray-700">
            <p>Kelola tautan media sosial yang tampil di footer website. Semua perubahan langsung terlihat di halaman publik.</p>
            <ol class="list-decimal list-inside space-y-1 text-gray-600">
                <li>Buka <strong>Pengaturan → Media Sosial</strong></li>
                <li>Klik <strong>Tambah Media Sosial</strong></li>
                <li>Pilih platform dari tile visual (Facebook, Instagram, dll.) atau klik <strong>Custom</strong> untuk platform baru</li>
                <li>Isi URL profil / halaman</li>
                <li>Atur urutan tampilan dan aktifkan</li>
            </ol>
            <div class="p-3 bg-pink-50 border border-pink-200 rounded-lg text-xs text-pink-800">
                <strong>Platform baru?</strong> Pilih <em>Custom</em> → upload logo icon (SVG/PNG) → pilih warna background. Icon akan tampil otomatis di footer.
            </div>
        </div>
    </div>

    {{-- 6. Manajemen User --}}
    <div id="users" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-red-50 border-b border-red-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h2 class="font-bold text-red-800 text-base">Manajemen User</h2>
        </div>
        <div class="p-6 space-y-4 text-sm text-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="font-semibold text-red-800">Admin</p>
                    <p class="text-xs text-red-600 mt-1">Akses penuh ke semua fitur panel admin</p>
                </div>
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="font-semibold text-blue-800">Editor</p>
                    <p class="text-xs text-blue-600 mt-1">Bisa kelola konten (berita, kegiatan) tapi tidak akses pengaturan sistem</p>
                </div>
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="font-semibold text-green-800">Member</p>
                    <p class="text-xs text-green-600 mt-1">Akses dashboard member, profil, dan daftar kegiatan</p>
                </div>
            </div>
            <p class="text-gray-600">Untuk mengubah role, nama, email, atau password user: buka <strong>Manajemen User → Daftar User</strong> → klik ikon edit.</p>
            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-800">
                <strong>Keamanan:</strong> Jangan berikan role Admin ke orang yang tidak dipercaya. Ganti password akun admin secara berkala.
            </div>
        </div>
    </div>

    {{-- 7. Pengaturan --}}
    <div id="pengaturan" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="font-bold text-gray-800 text-base">Pengaturan Sistem</h2>
        </div>
        <div class="p-6 space-y-5 text-sm text-gray-700">

            <x-tutorial-item title="Pengaturan Umum" icon="⚙️">
                <p class="text-gray-600">Buka <strong>Pengaturan → Pengaturan Umum</strong> untuk mengatur:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5 text-gray-600">
                    <li>Nama & tagline website</li>
                    <li>Logo dan favicon</li>
                    <li>Informasi kontak (email, telepon, alamat)</li>
                    <li>Visibilitas nama di navbar dan footer</li>
                    <li>Meta SEO (keywords, description)</li>
                </ul>
            </x-tutorial-item>

            <x-tutorial-item title="Email & Notifikasi" icon="📧">
                <p class="text-gray-600">Atur konfigurasi SMTP di <strong>Pengaturan → Email & Notifikasi</strong> agar sistem bisa mengirim email (reset password, notifikasi pendaftaran, dll.).</p>
                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-800">
                    <strong>SMTP Gmail:</strong> Host: <code>smtp.gmail.com</code>, Port: <code>587</code>, Enkripsi: <code>TLS</code>. Gunakan <em>App Password</em> Google, bukan password akun utama.
                </div>
            </x-tutorial-item>

        </div>
    </div>

    {{-- 8. Changelog --}}
    <div id="changelog" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-indigo-50 border-b border-indigo-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h2 class="font-bold text-indigo-800 text-base">Changelog / Catatan Update</h2>
        </div>
        <div class="p-6 text-sm text-gray-700 space-y-3">
            <p>Halaman <a href="{{ route('admin.changelog.index') }}" class="text-purple-600 hover:underline font-medium">Changelog</a> mencatat semua pembaruan sistem secara kronologis.</p>
            <ol class="list-decimal list-inside space-y-1 text-gray-600">
                <li>Buka <strong>Log & Changelog → Changelog</strong></li>
                <li>Klik <strong>Tambah Changelog</strong></li>
                <li>Isi versi, tanggal, deskripsi perubahan, dan tipe (Feature/Bugfix/Security/Update)</li>
                <li>Centang <strong>Publikasikan</strong> agar terlihat</li>
            </ol>
        </div>
    </div>

    {{-- 9. Tips Penting --}}
    <div id="tips" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-yellow-50 border-b border-yellow-100 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            </div>
            <h2 class="font-bold text-yellow-800 text-base">Tips Penting</h2>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            @php
            $tips = [
                ['icon'=>'🔐', 'title'=>'Keamanan Akun', 'desc'=>'Gunakan password minimal 12 karakter kombinasi huruf, angka, dan simbol. Jangan bagikan password admin ke siapapun.'],
                ['icon'=>'🖼️', 'title'=>'Ukuran Gambar', 'desc'=>'Slider: 1920×800px · Berita/Event: 1200×630px · Logo: 300×300px · Foto profil: 400×400px. Selalu kompres sebelum upload.'],
                ['icon'=>'💾', 'title'=>'Backup Data', 'desc'=>'Backup database secara rutin minimal seminggu sekali melalui cPanel → Backup Wizard.'],
                ['icon'=>'🌐', 'title'=>'Cache Browser', 'desc'=>'Jika perubahan tidak terlihat di website, tekan Ctrl+Shift+R (Windows) atau Cmd+Shift+R (Mac) untuk hard refresh.'],
                ['icon'=>'📱', 'title'=>'Cek Mobile', 'desc'=>'Setelah upload konten baru, cek tampilan di HP. Buka Developer Tools browser → pilih mode mobile untuk preview cepat.'],
                ['icon'=>'✉️', 'title'=>'Email SMTP', 'desc'=>'Jika email tidak terkirim, pastikan konfigurasi SMTP sudah benar di Pengaturan → Email. Gunakan App Password untuk Gmail.'],
                ['icon'=>'🗑️', 'title'=>'Hapus Hati-hati', 'desc'=>'Data yang dihapus tidak bisa dikembalikan. Pertimbangkan untuk menonaktifkan data daripada menghapus.'],
                ['icon'=>'📊', 'title'=>'SEO', 'desc'=>'Isi meta description dan keywords di setiap berita/halaman agar mudah ditemukan di Google. Panjang ideal: 150-160 karakter.'],
            ];
            @endphp
            @foreach($tips as $tip)
            <div class="flex gap-3 p-3 bg-gray-50 rounded-lg">
                <span class="text-2xl flex-shrink-0">{{ $tip['icon'] }}</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $tip['title'] }}</p>
                    <p class="text-xs text-gray-600 mt-0.5">{{ $tip['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Footer --}}
    <div class="text-center text-xs text-gray-400 pb-6">
        Butuh bantuan lebih lanjut? Hubungi pengembang sistem atau catat permintaan di
        <a href="{{ route('admin.changelog.index') }}" class="text-purple-600 hover:underline">Changelog & Update Requests</a>.
    </div>

</div>
@endsection
