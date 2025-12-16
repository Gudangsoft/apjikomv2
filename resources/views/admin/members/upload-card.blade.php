@extends('layouts.admin')

@section('title', 'Upload Kartu Anggota')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.members.show', $member) }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Detail Member</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-6 rounded-t-lg">
            <h1 class="text-2xl font-bold">Upload Kartu Anggota</h1>
            <p class="text-purple-100 mt-1">{{ $member->user->name }}</p>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <!-- Member Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-semibold text-gray-900">{{ $member->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold text-gray-900">{{ $member->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            @if($member->status == 'active') bg-green-100 text-green-800
                            @elseif($member->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($member->status) }}
                        </span>
                    </div>
                    @if($member->member_number)
                    <div>
                        <p class="text-sm text-gray-600">Nomor Anggota</p>
                        <p class="font-semibold text-gray-900">{{ $member->member_number }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Current Member Card -->
            @if($member->member_card)
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Kartu Anggota Saat Ini</h3>
                
                <div class="flex items-start space-x-4">
                    <div class="flex-1">
                        @if(Str::endsWith($member->member_card, '.pdf'))
                        <div class="flex items-center space-x-2 text-red-600">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">File PDF</p>
                                <a href="{{ asset('storage/' . $member->member_card) }}" target="_blank" 
                                   class="text-sm text-blue-600 hover:underline">
                                    Lihat PDF
                                </a>
                            </div>
                        </div>
                        @else
                        <img src="{{ asset('storage/' . $member->member_card) }}" 
                             alt="Member Card" 
                             class="max-w-md rounded shadow-lg">
                        @endif
                    </div>
                    
                    <form method="POST" action="{{ route('admin.members.delete-card', $member) }}" 
                          onsubmit="return confirm('Yakin ingin menghapus kartu anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Upload Form -->
            <form method="POST" action="{{ route('admin.members.upload-card.store', $member) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Anggota <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="member_number" 
                           value="{{ old('member_number', $member->member_number) }}" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('member_number') border-red-500 @enderror"
                           placeholder="Contoh: APJ-2025-001">
                    <p class="text-xs text-gray-500 mt-1">Format: APJ-TAHUN-NOMOR</p>
                    @error('member_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $member->member_card ? 'Upload Kartu Anggota Baru' : 'Upload Kartu Anggota' }} 
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="member_card" 
                           accept="image/*,.pdf" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('member_card') border-red-500 @enderror"
                           onchange="previewCard(event)">
                    <p class="text-xs text-gray-500 mt-1">
                        Format: JPG, PNG, PDF. Maksimal 2MB. 
                        @if($member->member_card)
                        File baru akan mengganti yang lama.
                        @endif
                    </p>
                    @error('member_card')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview -->
                    <div id="cardPreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <img id="preview" src="" alt="Preview" class="max-w-md rounded shadow-lg">
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 mb-2">📋 Panduan:</h4>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>✅ Pastikan file kartu anggota jelas dan terbaca</li>
                        <li>✅ Gunakan format gambar (JPG/PNG) atau PDF</li>
                        <li>✅ Ukuran file maksimal 2MB</li>
                        <li>✅ Nomor anggota harus unik</li>
                    </ul>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.members.show', $member) }}" 
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Upload Kartu Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewCard(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('cardPreview');
    const file = event.target.files[0];
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else if (file && file.type === 'application/pdf') {
        previewContainer.classList.add('hidden');
    }
}
</script>
@endsection
