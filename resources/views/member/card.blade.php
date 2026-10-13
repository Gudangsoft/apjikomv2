@extends('layouts.member')

@section('title', 'Kartu Anggota')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl card-shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Kartu Anggota</h2>
                <p class="text-gray-600 mt-1">Download, cetak, atau ajukan permintaan kartu anggota Anda</p>
            </div>
            <a href="{{ route('member.dashboard') }}"
               class="text-purple-600 hover:text-purple-800 font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if($member->member_card)
    <!-- Card Display -->
    <div class="bg-white rounded-xl card-shadow p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Kartu (HTML, desain baru tanpa chip ATM) -->
            <div class="mb-8">
                @include('member.partials.kartu-anggota')
            </div>

            <!-- Card Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Kartu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Anggota</p>
                        <p class="font-semibold text-gray-900">{{ $member->member_number ?? 'Belum ada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Masa Berlaku</p>
                        <p class="font-semibold text-green-700">Seumur Hidup</p>
                    </div>
                    @if($member->card_generated_at)
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pembuatan</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($member->card_generated_at)->format('d F Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center no-print">
                <button onclick="window.print()"
                        class="inline-flex items-center justify-center px-8 py-4 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak / Simpan PDF
                </button>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6 no-print">
                <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Petunjuk Penggunaan
                </h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>• Simpan kartu dalam format digital di perangkat Anda</li>
                    <li>• Untuk mencetak, gunakan kertas berkualitas baik ukuran A4</li>
                    <li>• Kartu dapat dilaminasi untuk keawetan lebih baik</li>
                    <li>• Tunjukkan kartu ini saat mengikuti kegiatan {{ site_name() }}</li>
                    <li>• Jika kartu hilang, rusak, atau datanya perlu diperbarui, ajukan permintaan di bawah ini</li>
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- ═══ KARTU FILE (digital, gratis) ═══ -->
    @php
        $profileCompleteForCard = $member->photo && $member->address && strlen((string) $member->address) >= 10 && $member->phone;
        $hasPendingCardRequest = (!$member->member_card && $member->card_requested)
            || ($member->member_card && $member->card_update_requested);
    @endphp
    <div class="bg-white rounded-xl card-shadow p-6 no-print">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ $member->member_card ? 'Request Update Kartu Anggota' : 'Belum Punya Kartu Anggota?' }}
                </h3>
                <p class="text-sm text-gray-500 mt-0.5">Kartu digital (file) — gratis, tanpa biaya cetak.</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>

        @if(!$profileCompleteForCard)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <p class="text-sm text-orange-700">Lengkapi foto, alamat, dan nomor telepon di profil Anda terlebih dahulu.</p>
                <a href="{{ route('member.profile') }}"
                   class="flex-shrink-0 inline-flex justify-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition">
                    Lengkapi Profil
                </a>
            </div>
        @elseif($hasPendingCardRequest)
            <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <svg class="w-6 h-6 text-blue-600 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Permintaan sedang diproses</p>
                    <p class="text-xs text-blue-600">Admin akan segera memproses kartu Anda.</p>
                </div>
            </div>
        @elseif($member->member_card)
            <form method="POST" action="{{ route('member.request-card-update') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Request Update Kartu Anggota
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('member.request-card') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Request Kartu Anggota
                </button>
            </form>
        @endif
    </div>

    @if(!$member->member_card)
    <!-- No Card Yet: context card -->
    <div class="bg-white rounded-xl card-shadow p-12 text-center no-print">
        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Kartu Belum Tersedia</h3>
        <p class="text-gray-600 mb-2 max-w-md mx-auto">
            @if(!$profileCompleteForCard)
                Lengkapi profil Anda (foto, alamat, dan telepon) terlebih dahulu, lalu klik "Lengkapi Profil" di atas.
            @elseif($hasPendingCardRequest)
                Permintaan kartu Anda sedang diproses oleh admin. Mohon tunggu beberapa saat.
            @else
                Klik tombol "Request Kartu Anggota" di atas untuk mengajukan pembuatan kartu.
            @endif
        </p>
    </div>
    @endif

    <!-- ═══ KARTU FISIK (cetak, berbayar) — layanan terpisah dari kartu file di atas ═══ -->
    <div class="bg-white rounded-xl card-shadow p-6 no-print">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Request Cetak Kartu Fisik</h3>
                <p class="text-sm text-gray-500 mt-0.5">Kartu dicetak &amp; dikirim oleh admin — ada biaya cetak.</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
            </div>
        </div>

        @if(!$profileCompleteForCard)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <p class="text-sm text-orange-700">Lengkapi foto, alamat, dan nomor telepon di profil Anda terlebih dahulu.</p>
                <a href="{{ route('member.profile') }}"
                   class="flex-shrink-0 inline-flex justify-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition">
                    Lengkapi Profil
                </a>
            </div>
        @elseif($member->physical_card_requested)
            <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <svg class="w-6 h-6 text-blue-600 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Permintaan cetak fisik sedang diproses</p>
                    <p class="text-xs text-blue-600">Admin akan segera memproses pembayaran &amp; pencetakan kartu Anda.</p>
                </div>
            </div>
        @else
            <button type="button" onclick="openPhysicalCardModal()"
                    class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Request Cetak Kartu Fisik
            </button>
        @endif

        @if($member->card_payment_proof)
        <p class="text-xs text-gray-400 mt-3">✓ Bukti pembayaran terlampir pada permintaan terakhir Anda.</p>
        @endif
    </div>
</div>

<!-- Modal: Request Cetak Kartu Fisik -->
@php
    $cardBankAccounts = member_card_bank_accounts();
    $cardFeeNote = setting('member_card_fee_note');
    $cardWaContacts = member_wa_contacts();
    $cardWaNumber = $cardWaContacts[0]['number'] ?? setting('contact_whatsapp');
    $cardWaMessage = 'Halo Admin ' . $globalSiteName . ', saya ' . Auth::user()->name . ' sudah mengirim permintaan cetak kartu fisik beserta bukti pembayarannya. Mohon diproses, terima kasih.';
@endphp
<div id="cardRequestModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">Request Cetak Kartu Fisik</h3>
            <button type="button" onclick="closeCardRequestModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="cardRequestForm" method="POST"
              action="{{ route('member.request-physical-card') }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            @if(count($cardBankAccounts))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-blue-800 mb-3">Rekening Pembayaran Biaya Cetak Kartu</p>
                <div class="space-y-3">
                    @foreach($cardBankAccounts as $bank)
                    @php $badge = bank_badge($bank['bank'] ?? ''); @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-11 rounded-lg flex items-center justify-center text-white font-extrabold text-[11px] tracking-wide shadow-sm flex-shrink-0"
                             style="background: {{ $badge['color'] }}">
                            {{ $badge['label'] }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-mono font-semibold text-blue-900 tracking-wide">{{ $bank['number'] ?? '' }}</p>
                            @if(!empty($bank['holder']))
                            <p class="text-xs text-blue-700 truncate">a.n. {{ $bank['holder'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($cardFeeNote)
                <p class="text-xs text-blue-700 mt-3 pt-3 border-t border-blue-200">{{ $cardFeeNote }}</p>
                @endif
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran Bukti Pembayaran <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="file" name="payment_proof" accept="image/*,.pdf"
                       class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-50 file:text-purple-700 file:text-sm border border-gray-300 rounded-lg">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP, atau PDF — maksimal 5MB.</p>
            </div>

            @if($cardWaNumber)
            <a href="https://wa.me/{{ wa_number($cardWaNumber) }}?text={{ urlencode($cardWaMessage) }}" target="_blank" rel="noopener noreferrer"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-green-50 hover:bg-green-100 border border-green-200 text-green-700 text-sm font-semibold rounded-lg transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0012.05 0"/>
                </svg>
                Konfirmasi via WhatsApp
            </a>
            @endif

            <div class="flex justify-end gap-3 pt-2 border-t">
                <button type="button" onclick="closeCardRequestModal()"
                        class="px-5 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit"
                        class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPhysicalCardModal() {
    const modal = document.getElementById('cardRequestModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeCardRequestModal() {
    const modal = document.getElementById('cardRequestModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

<style>
@media print {
    nav, aside, button, .no-print {
        display: none !important;
    }

    body {
        background: white !important;
    }

    main {
        padding: 0 !important;
    }

    .card-shadow {
        box-shadow: none !important;
    }
}
</style>
@endsection
