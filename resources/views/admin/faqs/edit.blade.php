@extends('layouts.admin')

@section('page-title', 'Edit FAQ')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.faqs.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit FAQ</h3>
    
    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
            <input type="text" id="question" name="question" value="{{ old('question', $faq->question) }}" maxlength="500" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('question') border-red-500 @enderror">
            @error('question')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
        </div>

        <div class="mb-6">
            <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Jawaban <span class="text-red-500">*</span></label>
            <textarea id="answer" name="answer" rows="5" required
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('answer') border-red-500 @enderror">{{ old('answer', $faq->answer) }}</textarea>
            @error('answer')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="category" name="category" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('category') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="general" {{ old('category', $faq->category) == 'general' ? 'selected' : '' }}>Umum</option>
                    <option value="membership" {{ old('category', $faq->category) == 'membership' ? 'selected' : '' }}>Keanggotaan</option>
                    <option value="payment" {{ old('category', $faq->category) == 'payment' ? 'selected' : '' }}>Pembayaran</option>
                    <option value="event" {{ old('category', $faq->category) == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="technical" {{ old('category', $faq->category) == 'technical' ? 'selected' : '' }}>Teknis</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" id="order" name="order" value="{{ old('order', $faq->order) }}" min="0"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-purple-500 @error('order') border-red-500 @enderror">
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Angka lebih kecil ditampilkan lebih dulu</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center space-x-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                       class="rounded text-purple-600 focus:ring-purple-500">
                <span class="text-sm font-medium text-gray-700">Aktifkan FAQ ini</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.faqs.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Update FAQ
            </button>
        </div>
    </form>
</div>
@endsection
