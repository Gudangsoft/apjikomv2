@extends('layouts.member')

@section('title', 'Tulis Testimoni')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('member.testimonials.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Tulis Testimoni</h1>
        <p class="text-gray-600 mt-1">Bagikan pengalaman Anda dengan APJIKOM</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('member.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Member Info Display -->
            <div class="mb-6 p-4 bg-purple-50 rounded-lg border border-purple-200">
                <div class="flex items-center gap-4">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ auth()->user()->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-purple-300">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-2xl border-2 border-purple-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $member->position ?? 'Member APJIKOM' }}</p>
                        @if($member->institution_name)
                        <p class="text-xs text-gray-500">{{ $member->institution_name }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Testimoni <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="6" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('content') border-red-500 @enderror"
                    placeholder="Ceritakan pengalaman Anda dengan APJIKOM... (minimal 20 karakter)"
                    required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    <span id="charCount">0</span> karakter (minimal 20 karakter)
                </p>
            </div>

            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" {{ old('rating', 5) == $i ? 'checked' : '' }} required>
                        <div class="flex items-center gap-1 px-4 py-2 border-2 border-gray-300 rounded-lg peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-purple-400 transition">
                            <span class="text-sm font-medium text-gray-700 peer-checked:text-purple-700">{{ $i }}</span>
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo (Optional) -->
            <div class="mb-6">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Testimoni (Opsional)
                </label>
                <input 
                    type="file" 
                    id="photo" 
                    name="photo" 
                    accept="image/jpeg,image/png,image/jpg"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('photo') border-red-500 @enderror">
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan untuk menggunakan foto profil.
                </p>
            </div>

            <!-- Info Box -->
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-blue-700 text-sm">
                        <p class="font-medium">Catatan:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs mt-1">
                            <li>Testimoni Anda akan ditinjau oleh admin sebelum dipublikasikan</li>
                            <li>Pastikan testimoni Anda sesuai dengan pengalaman nyata</li>
                            <li>Hindari konten yang bersifat SARA atau tidak pantas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Kirim Testimoni
                </button>
                <a href="{{ route('member.testimonials.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Character counter
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');
    
    function updateCharCount() {
        charCount.textContent = textarea.value.length;
        if (textarea.value.length < 20) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }
    
    textarea.addEventListener('input', updateCharCount);
    updateCharCount();
</script>
@endsection
