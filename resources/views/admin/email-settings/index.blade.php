@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Email</h1>
            <p class="text-gray-600 mt-2">Kelola konfigurasi email dan notifikasi otomatis</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.email-settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Email Server Configuration -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Konfigurasi Server Email
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mail Driver -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail Driver</label>
                        <select name="mail_mailer" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                            <option value="smtp" {{ setting('mail_mailer', 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ setting('mail_mailer', 'smtp') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="mailgun" {{ setting('mail_mailer', 'smtp') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ setting('mail_mailer', 'smtp') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                            <option value="postmark" {{ setting('mail_mailer', 'smtp') == 'postmark' ? 'selected' : '' }}>Postmark</option>
                            <option value="log" {{ setting('mail_mailer', 'smtp') == 'log' ? 'selected' : '' }}>Log (Testing)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Pilih metode pengiriman email</p>
                    </div>

                    <!-- Mail Host -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                        <input type="text" name="mail_host" value="{{ setting('mail_host', 'smtp.gmail.com') }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="smtp.gmail.com">
                        <p class="text-xs text-gray-500 mt-1">Contoh: smtp.gmail.com, smtp.mailtrap.io</p>
                    </div>

                    <!-- Mail Port -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                        <input type="number" name="mail_port" value="{{ setting('mail_port', '587') }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="587">
                        <p class="text-xs text-gray-500 mt-1">587 untuk TLS, 465 untuk SSL</p>
                    </div>

                    <!-- Encryption -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                        <select name="mail_encryption" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="tls" {{ setting('mail_encryption', 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ setting('mail_encryption', 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="null" {{ setting('mail_encryption', 'tls') == 'null' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username / Email</label>
                        <input type="text" name="mail_username" value="{{ setting('mail_username', '') }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="your-email@gmail.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password / App Password</label>
                        <input type="password" name="mail_password" value="{{ setting('mail_password', '') }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="••••••••">
                        <p class="text-xs text-gray-500 mt-1">Gunakan App Password untuk Gmail</p>
                    </div>
                </div>
            </div>

            <!-- Sender Information -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Informasi Pengirim
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- From Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Pengirim <span class="text-red-500">*</span></label>
                        <input type="email" name="mail_from_address" value="{{ setting('mail_from_address', 'noreply@apjikom.or.id') }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required
                               placeholder="noreply@apjikom.or.id">
                    </div>

                    <!-- From Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim <span class="text-red-500">*</span></label>
                        <input type="text" name="mail_from_name" value="{{ setting('mail_from_name', site_name()) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required
                               placeholder="{{ site_name() }}">
                    </div>
                </div>
            </div>

            <!-- Auto Email Settings -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    Notifikasi Email Otomatis
                </h2>

                <div class="space-y-4">
                    <!-- Enable Auto Email -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="auto_email_enabled" value="0">
                            <input type="checkbox" name="auto_email_enabled" value="1" 
                                   {{ setting('auto_email_enabled', '1') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3">
                            <label class="font-medium text-gray-900">Aktifkan Email Otomatis</label>
                            <p class="text-sm text-gray-500">Kirim email otomatis untuk berbagai event</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Registration Approved -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="email_registration_approved" value="0">
                            <input type="checkbox" name="email_registration_approved" value="1" 
                                   {{ setting('email_registration_approved', '1') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3">
                            <label class="font-medium text-gray-900">Pendaftaran Disetujui</label>
                            <p class="text-sm text-gray-500">Kirim email ketika pendaftaran member disetujui admin</p>
                        </div>
                    </div>

                    <!-- Registration Rejected -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="email_registration_rejected" value="0">
                            <input type="checkbox" name="email_registration_rejected" value="1" 
                                   {{ setting('email_registration_rejected', '1') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3">
                            <label class="font-medium text-gray-900">Pendaftaran Ditolak</label>
                            <p class="text-sm text-gray-500">Kirim email ketika pendaftaran member ditolak admin</p>
                        </div>
                    </div>

                    <!-- Password Reset -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="email_password_reset" value="0">
                            <input type="checkbox" name="email_password_reset" value="1" 
                                   {{ setting('email_password_reset', '1') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3">
                            <label class="font-medium text-gray-900">Reset Password</label>
                            <p class="text-sm text-gray-500">Kirim email ketika admin mereset password member</p>
                        </div>
                    </div>

                    <!-- Card Generated -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="email_card_generated" value="0">
                            <input type="checkbox" name="email_card_generated" value="1" 
                                   {{ setting('email_card_generated', '1') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3">
                            <label class="font-medium text-gray-900">Kartu Anggota Dibuat</label>
                            <p class="text-sm text-gray-500">Kirim email ketika kartu anggota berhasil digenerate</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Email -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Test Koneksi Email
                </h2>

                <div class="flex items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Tujuan Test</label>
                        <input type="email" id="test_email" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="test@example.com">
                    </div>
                    <button type="button" onclick="testEmailConnection()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Kirim Test Email
                    </button>
                </div>
                <div id="test-result" class="mt-3 hidden"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function testEmailConnection() {
    const email = document.getElementById('test_email').value;
    const resultDiv = document.getElementById('test-result');
    
    if (!email) {
        resultDiv.className = 'mt-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg';
        resultDiv.textContent = 'Masukkan email tujuan terlebih dahulu';
        resultDiv.classList.remove('hidden');
        return;
    }
    
    resultDiv.className = 'mt-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg';
    resultDiv.textContent = 'Mengirim email test...';
    resultDiv.classList.remove('hidden');
    
    fetch('{{ route("admin.email-settings.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ test_email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'mt-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg';
        } else {
            resultDiv.className = 'mt-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg';
        }
        resultDiv.textContent = data.message;
    })
    .catch(error => {
        resultDiv.className = 'mt-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg';
        resultDiv.textContent = 'Terjadi kesalahan: ' + error.message;
    });
}
</script>
@endsection
