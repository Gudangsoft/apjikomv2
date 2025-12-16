@extends('layouts.main')

@section('title', 'Daftar Member')

@section('content')
<!-- Page Header -->
<section class="bg-[#00629B] text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Bergabung dengan APJIKOM</h1>
        <p class="text-lg text-blue-100">Daftar sebagai anggota dan nikmati berbagai keuntungan</p>
    </div>
</section>

<!-- Registration Form -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Pendaftaran Berhasil!</h3>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Membership Type Selection -->
            <div class="bg-white rounded-lg shadow-sm border p-8 mb-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900">Pilih Tipe Keanggotaan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Individu Card -->
                    <div class="border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-purple-500 transition" id="card-individu" onclick="selectType('individu')">
                        <div class="flex items-start">
                            <input type="radio" name="membership_type" value="individu" id="type-individu" class="mt-1 mr-3 h-5 w-5 text-purple-600">
                            <div>
                                <label for="type-individu" class="text-xl font-bold text-gray-900 cursor-pointer">Individu</label>
                                <p class="text-gray-600 text-sm mt-2">Untuk anggota perorangan yang ingin bergabung secara individu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Prodi/Institusi Card -->
                    <div class="border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-purple-500 transition" id="card-prodi" onclick="selectType('prodi')">
                        <div class="flex items-start">
                            <input type="radio" name="membership_type" value="prodi" id="type-prodi" class="mt-1 mr-3 h-5 w-5 text-purple-600">
                            <div>
                                <label for="type-prodi" class="text-xl font-bold text-gray-900 cursor-pointer">Program Studi / Institusi</label>
                                <p class="text-gray-600 text-sm mt-2">Untuk perguruan tinggi yang memiliki program studi informatika dan komputer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded shadow-sm border p-8" id="registration-form" style="display: none;">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Form Pendaftaran Member</h2>
            
            <form method="POST" action="{{ route('member.store') }}" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="type" id="form-type">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Institution Name -->
                        <div id="field-institution">
                            <label class="block text-gray-700 font-medium mb-2">Institusi <span class="text-red-500">*</span></label>
                            <input type="text" name="institution_name" value="{{ old('institution_name') }}" list="institution-list"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('institution_name') border-red-500 @enderror"
                                   placeholder="Masukan Institusi Anda...">
                            <datalist id="institution-list">
                                <option value="Universitas Indonesia">
                                <option value="Institut Teknologi Bandung">
                                <option value="Universitas Gadjah Mada">
                                <option value="Institut Teknologi Sepuluh Nopember">
                                <option value="Universitas Diponegoro">
                                <option value="Universitas Airlangga">
                                <option value="Universitas Padjadjaran">
                                <option value="Universitas Brawijaya">
                                <option value="Universitas Hasanuddin">
                                <option value="Universitas Telkom">
                                <option value="Universitas Bina Nusantara">
                                <option value="Universitas Gunadarma">
                            </datalist>
                            @error('institution_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Study Program (Prodi only) -->
                        <div id="field-study-program" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Program Studi <span class="text-red-500">*</span></label>
                            <input type="text" name="study_program" value="{{ old('study_program') }}" list="prodi-list"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('study_program') border-red-500 @enderror"
                                   placeholder="Masukan Prodi Anda...">
                            <datalist id="prodi-list">
                                <option value="Teknik Informatika">
                                <option value="Sistem Informasi">
                                <option value="Ilmu Komputer">
                                <option value="Teknologi Informasi">
                                <option value="Rekayasa Perangkat Lunak">
                                <option value="Informatika">
                            </datalist>
                            @error('study_program')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Accreditation (Prodi only) -->
                        <div id="field-accreditation" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Akreditasi <span class="text-red-500">*</span></label>
                            <select name="accreditation"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('accreditation') border-red-500 @enderror">
                                <option value="">Pilih Akreditasi Prodi</option>
                                <option value="A" {{ old('accreditation') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('accreditation') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('accreditation') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="Unggul" {{ old('accreditation') == 'Unggul' ? 'selected' : '' }}>Unggul</option>
                                <option value="Baik Sekali" {{ old('accreditation') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                <option value="Baik" {{ old('accreditation') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            </select>
                            @error('accreditation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Accreditation Valid Until (Prodi only) -->
                        <div id="field-accreditation-valid" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Akreditasi Berlaku Hingga</label>
                            <input type="text" name="accreditation_valid_until" value="{{ old('accreditation_valid_until') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('accreditation_valid_until') border-red-500 @enderror"
                                   placeholder="Contoh : 29 Mei 1453">
                            @error('accreditation_valid_until')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Province (Prodi only) -->
                        <div id="field-province" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Provinsi Institusi <span class="text-red-500">*</span></label>
                            <input type="text" name="province" value="{{ old('province') }}" list="province-list"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('province') border-red-500 @enderror"
                                   placeholder="Provinsi Institusi Anda...">
                            <datalist id="province-list">
                                <option value="DKI Jakarta">
                                <option value="Jawa Barat">
                                <option value="Jawa Tengah">
                                <option value="Jawa Timur">
                                <option value="Daerah Istimewa Yogyakarta">
                                <option value="Banten">
                            </datalist>
                            @error('province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position (Individu only) -->
                        <div id="field-position" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Jabatan</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Address (Individu only) -->
                        <div id="field-address" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">
                                Alamat <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 font-normal ml-2">(Gunakan Enter untuk membuat baris baru)</span>
                            </label>
                            <textarea name="address" rows="3" placeholder="Contoh:&#10;Jl. Majapahit No. 605 Semarang&#10;RT 03 RW 05 Kelurahan Semarang Tengah&#10;Jawa Tengah 50192"
                                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">💡 Tips: Tekan Enter untuk membuat baris baru agar alamat tampil rapi di kartu anggota (maksimal 3 baris)</p>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Payment Proof -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                            <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.bmp,.pdf" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('payment_proof') border-red-500 @enderror">
                            @error('payment_proof')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">File Format : jpg,bmp,png,png,jpeg,pdf | Maks File : 5 Mb</p>
                        </div>
                        
                        <!-- Phone Number -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nomor Handphone (Nomor Whatsapp tanpa "+") <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required maxlength="13"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                   placeholder="628xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Authorization Letter (Prodi only) -->
                        <div id="field-authorization" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Download Template Surat Kuasa <span class="text-red-500">*</span></label>
                            <a href="https://dias.aptikom.org/assets/documents/template_surat_kuasa_anggota_prodi_aptikom.docx" 
                               target="_blank"
                               class="inline-block w-full px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold text-center transition-colors">
                                Unduh template surat kuasa
                            </a>
                        </div>

                        <!-- Website (Individu only) -->
                        <div id="field-website" style="display: none;">
                            <label class="block text-gray-700 font-medium mb-2">Website</label>
                            <input type="url" name="website" value="{{ old('website') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors">
                        Daftar
                    </button>
                    <button type="button" onclick="resetForm()" class="w-full md:w-auto px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition-colors">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
</section>

<script>
function selectType(type) {
    // Update radio button
    document.getElementById('type-' + type).checked = true;
    
    // Update card styles
    document.getElementById('card-individu').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-prodi').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-' + type).classList.add('border-purple-500', 'bg-purple-50');
    
    // Set form type
    document.getElementById('form-type').value = type;
    
    // Show form
    document.getElementById('registration-form').style.display = 'block';
    
    // Get all field elements
    const prodiFields = ['field-study-program', 'field-accreditation', 'field-accreditation-valid', 'field-province', 'field-authorization'];
    const individuFields = ['field-position', 'field-address', 'field-website'];
    
    if (type === 'prodi') {
        // Show prodi fields
        prodiFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            field.style.display = 'block';
            // Set required for inputs
            const inputs = field.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (!input.name.includes('accreditation_valid_until')) {
                    input.setAttribute('required', 'required');
                }
            });
        });
        
        // Hide individu fields
        individuFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            field.style.display = 'none';
            const inputs = field.querySelectorAll('input, textarea');
            inputs.forEach(input => input.removeAttribute('required'));
        });
        
        // Institution is required for both
        document.querySelector('[name="institution_name"]').setAttribute('required', 'required');
    } else {
        // Hide prodi fields
        prodiFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            field.style.display = 'none';
            const inputs = field.querySelectorAll('input, select');
            inputs.forEach(input => input.removeAttribute('required'));
        });
        
        // Show individu fields
        individuFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            field.style.display = 'block';
            if (fieldId === 'field-address') {
                const inputs = field.querySelectorAll('textarea');
                inputs.forEach(input => input.setAttribute('required', 'required'));
            }
        });
        
        // Institution is optional for individu
        document.querySelector('[name="institution_name"]').removeAttribute('required');
    }
    
    // Scroll to form
    document.getElementById('registration-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetForm() {
    document.getElementById('registration-form').style.display = 'none';
    document.getElementById('card-individu').classList.remove('border-purple-500', 'bg-purple-50');
    document.getElementById('card-prodi').classList.remove('border-purple-500', 'bg-purple-50');
    document.querySelectorAll('input[name="membership_type"]').forEach(radio => radio.checked = false);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Restore old values if validation fails
@if(old('type'))
    selectType('{{ old('type') }}');
@endif
</script>
@endsection
