@extends('layouts.admin')
@section('title', 'Struktur Organisasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Struktur Organisasi</h1>
        <p class="text-gray-600 mt-1">Kelola pengurus dan struktur organisasi APJIKOM</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.organizational-divisions.index') }}"
           class="px-4 py-2 border border-purple-200 text-purple-700 rounded-lg hover:bg-purple-50 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Kelola Bidang
        </a>
        <a href="{{ route('admin.organizational-structure.create') }}"
           class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengurus
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
@endif

{{-- PENGURUS INTI --}}
<div class="mb-8">
    <h2 class="text-base font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-purple-500 inline-block"></span>
        Pengurus Inti
    </h2>
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        @php $leadership = $structures->where('type', 'leadership'); @endphp
        @if($leadership->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">Urut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-20">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($leadership as $person)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $person->order }}</td>
                        <td class="px-4 py-3">
                            @if($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                     class="w-9 h-9 rounded-full object-cover">
                            @else
                                <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $person->position }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $person->name }}</div>
                            @if($person->description)
                                <div class="text-xs text-gray-400">{{ Str::limit($person->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $person->institusi ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($person->is_active)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.organizational-structure.edit', $person) }}"
                                   class="text-purple-600 hover:text-purple-900 text-sm">Edit</a>
                                <form action="{{ route('admin.organizational-structure.destroy', $person) }}" method="POST"
                                      onsubmit="return confirm('Hapus {{ addslashes($person->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-8 text-center text-gray-400 text-sm">Belum ada pengurus inti.</div>
        @endif
    </div>
</div>

{{-- DIVISI --}}
<div>
    <h2 class="text-base font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-indigo-400 inline-block"></span>
        Divisi
    </h2>
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        @php $divisions = $structures->where('type', 'division'); @endphp
        @if($divisions->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">Urut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-36">Bidang/Divisi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan & Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-20">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($divisions as $person)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $person->order }}</td>
                        <td class="px-4 py-3">
                            @if($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                     class="w-9 h-9 rounded-full object-cover">
                            @else
                                <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($person->division_name)
                                <span class="inline-block px-2 py-0.5 text-xs rounded bg-indigo-50 text-indigo-700 font-medium">
                                    {{ $person->division_name }}
                                </span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $person->position }}</div>
                            <div class="text-sm text-gray-600">{{ $person->name }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $person->institusi ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($person->is_active)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.organizational-structure.edit', $person) }}"
                                   class="text-purple-600 hover:text-purple-900 text-sm">Edit</a>
                                <form action="{{ route('admin.organizational-structure.destroy', $person) }}" method="POST"
                                      onsubmit="return confirm('Hapus {{ addslashes($person->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-8 text-center text-gray-400 text-sm">Belum ada anggota divisi.</div>
        @endif
    </div>
</div>
@endsection
