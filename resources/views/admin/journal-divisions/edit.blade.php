@extends('layouts.admin')

@section('page-title', 'Edit Divisi Jurnal')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Divisi Jurnal</h2>
                    </div>

                    <form action="{{ route('admin.journal-divisions.update', $journalDivision) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="division" class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Divisi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="division" id="division" value="{{ old('division', $journalDivision->division) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('division') border-red-500 @enderror" 
                                required>
                            @error('division')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="main_focus" class="block text-gray-700 text-sm font-bold mb-2">
                                Main Focus <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="main_focus" id="main_focus" value="{{ old('main_focus', $journalDivision->main_focus) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('main_focus') border-red-500 @enderror" 
                                required>
                            @error('main_focus')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="journal_potential" class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Jurnal/Cluster <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="journal_potential" id="journal_potential" value="{{ old('journal_potential', $journalDivision->journal_potential) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('journal_potential') border-red-500 @enderror" 
                                required>
                            @error('journal_potential')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cover" class="block text-gray-700 text-sm font-bold mb-2">
                                Cover
                            </label>
                            @if($journalDivision->cover)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $journalDivision->cover) }}" alt="Current Cover" class="w-32 h-32 object-cover rounded">
                                    <p class="text-sm text-gray-500 mt-1">Cover saat ini</p>
                                </div>
                            @endif
                            <input type="file" name="cover" id="cover" accept="image/jpeg,image/png,image/jpg"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cover') border-red-500 @enderror">
                            <p class="text-gray-500 text-xs mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah cover.</p>
                            @error('cover')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-gray-700 text-sm font-bold mb-2">
                                Urutan
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $journalDivision->order) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order') border-red-500 @enderror">
                            @error('order')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $journalDivision->is_active) ? 'checked' : '' }}
                                    class="mr-2 leading-tight">
                                <span class="text-sm text-gray-700 font-bold">Aktif</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.journal-divisions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
