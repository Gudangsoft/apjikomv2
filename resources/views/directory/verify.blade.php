@extends('layouts.main')

@section('title', 'Verifikasi Keanggotaan - ' . ($member->user->name ?? $member->institution_name ?? 'Anggota'))

@section('content')
@php
    use Illuminate\Support\Facades\Storage;

    $nama    = $member->user->name ?? $member->institution_name ?? '-';
    $nomor   = $member->member_number ?: '-';
    $jabatan = $member->position ?: null;
    $inst    = $member->institution_name ?: null;
    $wilayah = collect([$member->city, $member->province])->filter()->implode(', ') ?: null;
    $bergabung = $member->join_date ? \Carbon\Carbon::parse($member->join_date)->translatedFormat('d F Y') : null;

    $fotoUrl = ($member->photo && Storage::disk('public')->exists($member->photo))
        ? Storage::url($member->photo) : null;

    $aktif = $member->status === 'active';
    $tampilDirektori = $member->show_in_directory && $member->is_verified && $aktif;
@endphp

<div class="bg-gradient-to-br from-purple-700 via-indigo-600 to-purple-600 py-10">
    <div class="container mx-auto px-4 text-center text-white">
        <p class="text-xs font-bold tracking-[0.25em] uppercase opacity-80">APJIKOM</p>
        <h1 class="text-2xl md:text-3xl font-bold mt-1">Verifikasi Keanggotaan</h1>
        <p class="text-sm opacity-80 mt-1">Asosiasi Pengelola Jurnal Informatika dan Komputer Indonesia</p>
    </div>
</div>

<div class="container mx-auto px-4 -mt-8 pb-16">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">

        <div class="p-6 sm:p-8">
            <div class="flex flex-col items-center text-center">
                <div class="w-32 h-40 rounded-xl overflow-hidden ring-4 ring-purple-100 border-2 border-purple-500 bg-purple-50 flex items-center justify-center">
                    @if($fotoUrl)
                        <img src="{{ $fotoUrl }}" alt="Foto {{ $nama }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-16 h-16 text-purple-300" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8z"/></svg>
                    @endif
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-4">{{ $nama }}</h2>
                <p class="text-sm text-gray-500 font-mono mt-0.5">{{ $nomor }}</p>

                @if($aktif)
                    <div class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-full bg-green-50 text-green-700 border border-green-200 font-semibold text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0L3.3 10.1a1 1 0 111.4-1.4l3.8 3.8 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                        TERDAFTAR RESMI &middot; Anggota Aktif
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-full bg-amber-50 text-amber-700 border border-amber-200 font-semibold text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.3 3.3a2 2 0 013.4 0l6 10.4A2 2 0 0116 17H4a2 2 0 01-1.7-3l6-10.4zM10 8a1 1 0 00-1 1v3a1 1 0 002 0V9a1 1 0 00-1-1zm0 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                        Status keanggotaan: {{ ucfirst($member->status ?? 'tidak diketahui') }}
                    </div>
                @endif
            </div>

            <dl class="mt-6 divide-y divide-gray-100 border-t border-gray-100 text-sm">
                @if($jabatan)
                <div class="flex py-3">
                    <dt class="w-40 flex-shrink-0 text-gray-500">Jabatan / Profesi</dt>
                    <dd class="text-gray-900 font-medium">{{ $jabatan }}</dd>
                </div>
                @endif
                @if($inst)
                <div class="flex py-3">
                    <dt class="w-40 flex-shrink-0 text-gray-500">Institusi</dt>
                    <dd class="text-gray-900 font-medium">{{ $inst }}</dd>
                </div>
                @endif
                @if($wilayah)
                <div class="flex py-3">
                    <dt class="w-40 flex-shrink-0 text-gray-500">Wilayah</dt>
                    <dd class="text-gray-900 font-medium">{{ $wilayah }}</dd>
                </div>
                @endif
                @if($bergabung)
                <div class="flex py-3">
                    <dt class="w-40 flex-shrink-0 text-gray-500">Terdaftar Sejak</dt>
                    <dd class="text-gray-900 font-medium">{{ $bergabung }}</dd>
                </div>
                @endif
            </dl>

            @if($tampilDirektori)
            <a href="{{ route('directory.show', $member) }}"
               class="mt-6 w-full inline-flex items-center justify-center px-5 py-3 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-semibold transition">
                Lihat Profil Lengkap
            </a>
            @endif
        </div>

        <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 text-center">
            <p class="text-xs text-gray-500">
                Halaman verifikasi otomatis {{ site_name() }} &middot; {{ now()->translatedFormat('d F Y, H:i') }}
            </p>
            <a href="{{ route('home') }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">{{ route('home') }}</a>
        </div>
    </div>
</div>
@endsection
