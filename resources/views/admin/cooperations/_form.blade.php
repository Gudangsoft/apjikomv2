@csrf
@isset($cooperation)
    @method('PUT')
@endisset

<!-- Nama -->
<div class="mb-6">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
        Nama Institusi / Mitra <span class="text-red-500">*</span>
    </label>
    <input type="text" name="name" id="name"
           value="{{ old('name', $cooperation->name ?? '') }}"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
           required>
    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<!-- Logo -->
<div class="mb-6">
    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
        Logo <span class="text-gray-400 font-normal">(opsional)</span>
    </label>
    <input type="file" name="logo" id="logo" accept="image/*"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('logo') border-red-500 @enderror"
           onchange="previewImage(event, 'logo-preview', 'logo-preview-img')">
    <p class="mt-1 text-xs text-gray-500">JPG, PNG, SVG, atau WebP — maksimal 2MB.</p>
    @error('logo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

    @isset($cooperation)
        @if($cooperation->logo)
        <div class="mt-3">
            <p class="text-xs text-gray-500 mb-1">Logo saat ini:</p>
            <img src="{{ asset('storage/' . $cooperation->logo) }}" alt="Logo" class="w-24 h-24 object-contain bg-gray-50 border border-gray-200 rounded-lg p-2">
        </div>
        @endif
    @endisset
    <div id="logo-preview" class="mt-3 hidden">
        <p class="text-xs text-gray-500 mb-1">Preview logo baru:</p>
        <img id="logo-preview-img" src="" alt="Preview" class="w-24 h-24 object-contain bg-gray-50 border border-gray-200 rounded-lg p-2">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Kategori -->
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
            Program Studi / Bidang Kerjasama <span class="text-gray-400 font-normal">(opsional)</span>
        </label>
        <input type="text" name="category" id="category"
               value="{{ old('category', $cooperation->category ?? '') }}"
               placeholder="Contoh: Teknik Informatika"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('category') border-red-500 @enderror">
        @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <!-- Website -->
    <div>
        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
            Website <span class="text-gray-400 font-normal">(opsional)</span>
        </label>
        <input type="text" name="website" id="website"
               value="{{ old('website', $cooperation->website ?? '') }}"
               placeholder="https://contoh.ac.id"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('website') border-red-500 @enderror">
        @error('website')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<!-- Dokumen MoU / MoA -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-green-900 mb-3">Dokumen MoU</h4>
        <label for="mou_file" class="block text-xs font-medium text-gray-700 mb-1.5">File MoU (PDF/JPG/PNG)</label>
        <input type="file" name="mou_file" id="mou_file" accept=".pdf,image/*"
               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('mou_file') border-red-500 @enderror">
        @error('mou_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @isset($cooperation)
            @if($cooperation->mou_file)
            <a href="{{ asset('storage/' . $cooperation->mou_file) }}" target="_blank" class="inline-block mt-2 text-xs text-green-700 underline">Lihat file saat ini</a>
            @endif
        @endisset

        <label for="mou_date" class="block text-xs font-medium text-gray-700 mb-1.5 mt-3">Tanggal MoU</label>
        <input type="date" name="mou_date" id="mou_date"
               value="{{ old('mou_date', isset($cooperation) && $cooperation->mou_date ? $cooperation->mou_date->format('Y-m-d') : '') }}"
               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('mou_date') border-red-500 @enderror">
        @error('mou_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-blue-900 mb-3">Dokumen MoA</h4>
        <label for="moa_file" class="block text-xs font-medium text-gray-700 mb-1.5">File MoA (PDF/JPG/PNG)</label>
        <input type="file" name="moa_file" id="moa_file" accept=".pdf,image/*"
               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('moa_file') border-red-500 @enderror">
        @error('moa_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @isset($cooperation)
            @if($cooperation->moa_file)
            <a href="{{ asset('storage/' . $cooperation->moa_file) }}" target="_blank" class="inline-block mt-2 text-xs text-blue-700 underline">Lihat file saat ini</a>
            @endif
        @endisset

        <label for="moa_date" class="block text-xs font-medium text-gray-700 mb-1.5 mt-3">Tanggal MoA</label>
        <input type="date" name="moa_date" id="moa_date"
               value="{{ old('moa_date', isset($cooperation) && $cooperation->moa_date ? $cooperation->moa_date->format('Y-m-d') : '') }}"
               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('moa_date') border-red-500 @enderror">
        @error('moa_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<!-- Deskripsi -->
<div class="mb-6">
    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
        Lingkup / Deskripsi Kerjasama <span class="text-gray-400 font-normal">(opsional)</span>
    </label>
    <textarea name="description" id="description" rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $cooperation->description ?? '') }}</textarea>
    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Order -->
    <div>
        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
        <input type="number" name="order" id="order" min="0"
               value="{{ old('order', $cooperation->order ?? 0) }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('order') border-red-500 @enderror"
               required>
        <p class="mt-1 text-xs text-gray-500">Semakin kecil angka, semakin awal ditampilkan.</p>
        @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <!-- Is Active -->
    <div class="flex items-end pb-2">
        <label class="flex items-center">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $cooperation->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
            <span class="ml-2 text-sm text-gray-700">Aktif (tampilkan di website)</span>
        </label>
    </div>
</div>

<!-- Buttons -->
<div class="flex items-center space-x-4 pt-4 border-t">
    <button type="submit" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
        {{ isset($cooperation) ? 'Simpan Perubahan' : 'Simpan Kerjasama' }}
    </button>
    <a href="{{ route('admin.cooperations.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
        Batal
    </a>
</div>

<script>
function previewImage(event, containerId, imgId) {
    const preview = document.getElementById(containerId);
    const previewImage = document.getElementById(imgId);
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
