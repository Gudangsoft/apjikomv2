@extends('layouts.member')

@section('title', 'Sertifikat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('member.events.my') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Event Saya</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-6">
            <h1 class="text-2xl font-bold">Sertifikat Peserta</h1>
            <p class="text-purple-100 mt-1">{{ $registration->event->title }}</p>
        </div>

        <div class="p-6">
            <div class="mb-6">
                <img src="{{ $certificateUrl }}" 
                     alt="Sertifikat {{ $registration->user->name }}"
                     class="w-full rounded-lg border shadow-lg">
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('member.certificates.download', $registration) }}" 
                   class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Sertifikat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
