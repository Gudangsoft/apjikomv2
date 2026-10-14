@extends('layouts.admin')

@section('page-title', 'Verifikasi Pembayaran Kartu Fisik')

@section('content')
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Verifikasi Pembayaran Cetak Kartu Fisik</h3>
    <p class="text-gray-600 mt-1">Cek bukti pembayaran member, lalu tandai valid/tidak valid. Member otomatis dikabari lewat WhatsApp.</p>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Tabs Status -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px overflow-x-auto" role="tablist">
            @foreach([
                'pending'  => ['Menunggu Verifikasi', 'text-amber-600 border-amber-600', $counts['pending']],
                'verified' => ['Terverifikasi', 'text-green-600 border-green-600', $counts['verified']],
                'rejected' => ['Ditolak', 'text-red-600 border-red-600', $counts['rejected']],
                'all'      => ['Semua', 'text-gray-700 border-gray-700', $counts['all']],
            ] as $key => [$label, $activeClass, $count])
            <a href="{{ route('admin.physical-card-requests.index', ['status' => $key]) }}"
               class="flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 whitespace-nowrap transition-colors
                      {{ $status === $key ? $activeClass : 'text-gray-500 border-transparent hover:text-gray-700' }}">
                {{ $label }}
                <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $status === $key ? 'bg-gray-100' : 'bg-gray-50 text-gray-400' }}">
                    {{ $count }}
                </span>
            </a>
            @endforeach
        </nav>
    </div>
</div>

<div class="space-y-4">
    @forelse($requests as $member)
    <div id="member-{{ $member->id }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex flex-col lg:flex-row lg:items-start gap-5">

            <!-- Info Member -->
            <div class="flex items-start gap-3 flex-1 min-w-0">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->user->name ?? '' }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-blue-600 font-bold">{{ mb_substr($member->user->name ?? '?', 0, 1) }}</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <a href="{{ route('admin.members.show', $member) }}" class="font-semibold text-gray-900 hover:text-purple-700 transition">
                        {{ $member->user->name ?? '-' }}
                    </a>
                    <p class="text-sm text-gray-500">{{ $member->institution_name ?? '-' }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $member->phone ?? 'Tidak ada nomor HP' }}
                        @if($member->physical_card_requested_at)
                        &bull; Request {{ $member->physical_card_requested_at->diffForHumans() }}
                        @endif
                    </p>

                    @php
                        $statusBadge = [
                            'verified' => ['Pembayaran Valid', 'bg-green-100 text-green-700'],
                            'rejected' => ['Pembayaran Ditolak', 'bg-red-100 text-red-700'],
                        ][$member->physical_card_payment_status] ?? ['Menunggu Verifikasi', 'bg-amber-100 text-amber-700'];
                    @endphp
                    <span class="inline-block mt-2 px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusBadge[1] }}">
                        {{ $statusBadge[0] }}
                    </span>
                    @if($member->physical_card_payment_notes)
                    <p class="text-xs text-gray-500 mt-1 italic">"{{ $member->physical_card_payment_notes }}"</p>
                    @endif
                </div>
            </div>

            <!-- Bukti Bayar -->
            <div class="flex-shrink-0">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Bukti Pembayaran</p>
                @if($member->card_payment_proof)
                    @if(Str::endsWith($member->card_payment_proof, '.pdf'))
                    <a href="{{ asset('storage/' . $member->card_payment_proof) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                        📄 Lihat PDF
                    </a>
                    @else
                    <a href="{{ asset('storage/' . $member->card_payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $member->card_payment_proof) }}" alt="Bukti Pembayaran"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 hover:shadow-md transition">
                    </a>
                    @endif
                @else
                    <div class="w-32 h-20 flex items-center justify-center bg-gray-50 border border-dashed border-gray-300 rounded-lg text-xs text-gray-400 text-center p-2">
                        Belum ada bukti bayar
                    </div>
                @endif
            </div>

            <!-- Aksi -->
            @if(!$member->physical_card_payment_status || $member->physical_card_payment_status === 'pending')
            <div class="flex flex-row lg:flex-col gap-2 flex-shrink-0 lg:w-48">
                <form method="POST" action="{{ route('admin.physical-card-requests.verify', $member) }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Tandai pembayaran {{ addslashes($member->user->name ?? '') }} sebagai VALID? Member akan dikirimi WA konfirmasi.')"
                            class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Verifikasi
                    </button>
                </form>
                <button type="button" onclick="openRejectModal({{ $member->id }}, '{{ addslashes($member->user->name ?? '') }}')"
                        class="flex-1 px-4 py-2.5 border border-red-300 text-red-600 hover:bg-red-50 text-sm font-semibold rounded-lg transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tolak
                </button>
            </div>
            @else
            <div class="flex-shrink-0 lg:w-48 text-xs text-gray-400 self-center">
                @if($member->physicalCardPaymentVerifier)
                    Diproses oleh {{ $member->physicalCardPaymentVerifier->name }}
                @endif
                @if($member->physical_card_payment_verified_at)
                    <br>{{ $member->physical_card_payment_verified_at->diffForHumans() }}
                @endif
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-gray-500">Tidak ada permintaan cetak kartu fisik di status ini.</p>
    </div>
    @endforelse
</div>

@if($requests->hasPages())
<div class="mt-6">
    {{ $requests->links() }}
</div>
@endif

<!-- Modal: Tolak Pembayaran -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">Tolak Pembayaran</h3>
            <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="rejectForm" method="POST" class="p-6 space-y-4">
            @csrf
            <p class="text-sm text-gray-600">Menolak pembayaran <strong id="rejectMemberName"></strong>. Member akan dikirimi WA pemberitahuan.</p>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (opsional)</label>
                <textarea name="reason" rows="3" maxlength="500"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-400"
                          placeholder="Contoh: Nominal transfer tidak sesuai."></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t">
                <button type="button" onclick="closeRejectModal()" class="px-5 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">Tolak Pembayaran</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(memberId, memberName) {
    document.getElementById('rejectForm').action = `/admin/physical-card-requests/${memberId}/reject`;
    document.getElementById('rejectMemberName').textContent = memberName;
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
