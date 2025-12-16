@extends('layouts.admin')

@section('title', 'Edit Pengurus')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Pengurus</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.organizational-structure.update', $organizationalStructure) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="leadership" {{ old('type', $organizationalStructure->type) == 'leadership' ? 'checked' : '' }} 
                                   class="text-purple-600" onchange="toggleDivisionField()">
                            <span class="ml-2">Pengurus Inti</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="division" {{ old('type', $organizationalStructure->type) == 'division' ? 'checked' : '' }} 
                                   class="text-purple-600" onchange="toggleDivisionField()">
                            <span class="ml-2">Divisi</span>
                        </label>
                    </div>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="position" name="position" value="{{ old('position', $organizationalStructure->position) }}"
                           class="w-full px-3 py-2 border rounded-lg @error('position') border-red-500 @enderror" required>
                    @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $organizationalStructure->name) }}"
                           class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Division Name -->
                <div id="division-field" class="{{ $organizationalStructure->type == 'division' ? '' : 'hidden' }}">
                    <label for="division_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Divisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="division_name" name="division_name" value="{{ old('division_name', $organizationalStructure->division_name) }}"
                           class="w-full px-3 py-2 border rounded-lg">
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="order" name="order" value="{{ old('order', $organizationalStructure->order) }}" min="0"
                           class="w-32 px-3 py-2 border rounded-lg @error('order') border-red-500 @enderror" required>
                    @error('order')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Current Photo -->
                @if($organizationalStructure->photo)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                        <img src="{{ asset('storage/' . $organizationalStructure->photo) }}" alt="{{ $organizationalStructure->name }}" 
                             class="w-24 h-24 rounded-full object-cover">
                    </div>
                @endif

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $organizationalStructure->photo ? 'Ganti Foto (Opsional)' : 'Upload Foto (Opsional)' }}
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                           class="w-full px-3 py-2 border rounded-lg">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border rounded-lg">{{ old('description', $organizationalStructure->description) }}</textarea>
                </div>

                <!-- Is Active -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $organizationalStructure->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan pengurus ini</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.organizational-structure.index') }}" class="px-6 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDivisionField() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const divisionField = document.getElementById('division-field');
    const divisionInput = document.getElementById('division_name');
    
    if (type === 'division') {
        divisionField.classList.remove('hidden');
        divisionInput.required = true;
    } else {
        divisionField.classList.add('hidden');
        divisionInput.required = false;
    }
}
</script>
@endsection
