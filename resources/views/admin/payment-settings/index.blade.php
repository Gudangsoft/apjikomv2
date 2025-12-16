@extends('layouts.admin')

@section('page-title', 'Pengaturan Pembayaran & Keanggotaan')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Pembayaran & Keanggotaan</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola biaya pendaftaran, rekening bank, dan kontak untuk pendaftaran anggota</p>
        </div>

        <form method="POST" action="{{ route('admin.payment-settings.update') }}" class="p-6">
            @csrf
            @method('PUT')

            <!-- Payment Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Pengaturan Pembayaran & Keanggotaan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mode Pendaftaran -->
                    <div class="md:col-span-2 bg-amber-50 p-4 rounded-lg border border-amber-200">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mode Pendaftaran
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pendaftaran *</label>
                                <select name="registration_mode" id="registration_mode"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" required>
                                    <option value="paid" {{ old('registration_mode', $settings->firstWhere('key', 'registration_mode')?->value ?? 'paid') == 'paid' ? 'selected' : '' }}>
                                        💳 Berbayar (Paid)
                                    </option>
                                    <option value="free" {{ old('registration_mode', $settings->firstWhere('key', 'registration_mode')?->value) == 'free' ? 'selected' : '' }}>
                                        🆓 Gratis (Free)
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih "Free" untuk pendaftaran gratis tanpa biaya</p>
                                @error('registration_mode')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Bayar *</label>
                                <select name="require_payment_proof" id="require_payment_proof"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" required>
                                    <option value="1" {{ old('require_payment_proof', $settings->firstWhere('key', 'require_payment_proof')?->value ?? '1') == '1' ? 'selected' : '' }}>
                                        ✅ Wajib Upload
                                    </option>
                                    <option value="0" {{ old('require_payment_proof', $settings->firstWhere('key', 'require_payment_proof')?->value) == '0' ? 'selected' : '' }}>
                                        ❌ Tidak Perlu Upload
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Atur apakah bukti bayar wajib diunggah</p>
                                @error('require_payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Biaya Pendaftaran -->
                    <div class="md:col-span-2 bg-purple-50 p-4 rounded-lg border border-purple-200" id="payment_fees_section">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Biaya Pendaftaran
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Individu (Rp/tahun) *</label>
                                <input type="number" name="biaya_individu" id="biaya_individu" value="{{ old('biaya_individu', $settings->firstWhere('key', 'biaya_individu')?->value ?? '250000') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" min="0">
                                <p class="text-xs text-gray-500 mt-1">Untuk anggota perorangan</p>
                                @error('biaya_individu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Program Studi (Rp/tahun) *</label>
                                <input type="number" name="biaya_prodi" id="biaya_prodi" value="{{ old('biaya_prodi', $settings->firstWhere('key', 'biaya_prodi')?->value ?? '750000') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" min="0">
                                <p class="text-xs text-gray-500 mt-1">Untuk perguruan tinggi</p>
                                @error('biaya_prodi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Rekening -->
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            Informasi Rekening Bank
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank *</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $settings->firstWhere('key', 'bank_name')?->value ?? 'BNI 46 Cabang Perintis Kemerdekaan') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening *</label>
                                <input type="text" name="account_number" value="{{ old('account_number', $settings->firstWhere('key', 'account_number')?->value ?? '1119995552') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                @error('account_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Atas Nama *</label>
                                <input type="text" name="account_name" value="{{ old('account_name', $settings->firstWhere('key', 'account_name')?->value ?? 'APTIKOM') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                @error('account_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Konfirmasi -->
                    <div class="md:col-span-2 bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Kontak Konfirmasi Pembayaran
                        </h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp *</label>
                            <input type="tel" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings->firstWhere('key', 'contact_whatsapp')?->value ?? '081234567890') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx (untuk konfirmasi pembayaran via WhatsApp)</p>
                            @error('contact_whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
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

<script>
// Toggle visibility berdasarkan mode pendaftaran
document.addEventListener('DOMContentLoaded', function() {
    const registrationMode = document.getElementById('registration_mode');
    const paymentFeesSection = document.getElementById('payment_fees_section');
    const biayaIndividu = document.getElementById('biaya_individu');
    const biayaProdi = document.getElementById('biaya_prodi');
    
    function togglePaymentFields() {
        if (registrationMode.value === 'free') {
            // Mode Free - sembunyikan dan nonaktifkan biaya
            paymentFeesSection.style.opacity = '0.5';
            paymentFeesSection.style.pointerEvents = 'none';
            biayaIndividu.value = '0';
            biayaProdi.value = '0';
            biayaIndividu.required = false;
            biayaProdi.required = false;
        } else {
            // Mode Paid - tampilkan dan aktifkan biaya
            paymentFeesSection.style.opacity = '1';
            paymentFeesSection.style.pointerEvents = 'auto';
            if (biayaIndividu.value === '0') {
                biayaIndividu.value = '250000';
            }
            if (biayaProdi.value === '0') {
                biayaProdi.value = '750000';
            }
            biayaIndividu.required = true;
            biayaProdi.required = true;
        }
    }
    
    // Jalankan saat halaman dimuat
    togglePaymentFields();
    
    // Jalankan saat nilai berubah
    registrationMode.addEventListener('change', togglePaymentFields);
});
</script>
@endsection
