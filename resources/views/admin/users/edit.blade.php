@extends('layouts.admin')

@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl">

    <div class="mb-5">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Kelola User
        </a>
    </div>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <ul class="text-sm text-red-700 space-y-1">
            @foreach($errors->all() as $error)
                <li class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm">
        {{-- Header --}}
        <div class="p-5 border-b flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }} &middot;
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full
                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'editor' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-400 bg-red-50 @enderror">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('username') border-red-400 bg-red-50 @enderror">
                @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-400 bg-red-50 @enderror">
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <select name="role" required
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('role') border-red-400 bg-red-50 @enderror">
                    <option value="admin"  {{ old('role', $user->role) === 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                </select>
                @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="pt-2 border-t border-gray-100">
                <p class="text-sm font-semibold text-gray-700 mb-3">Ganti Password <span class="text-xs font-normal text-gray-400">(kosongkan jika tidak ingin mengubah)</span></p>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-400 bg-red-50 @enderror"
                                placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePass('password','eye1')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePass('password_confirmation','eye2')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info member --}}
            @if($user->member)
            <div class="pt-2 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Data Keanggotaan</p>
                <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-600 grid grid-cols-2 gap-2">
                    <div><span class="text-gray-400">No Anggota:</span> {{ $user->member->member_number ?? '-' }}</div>
                    <div><span class="text-gray-400">Status:</span>
                        <span class="font-medium {{ $user->member->status === 'active' ? 'text-green-600' : 'text-red-500' }}">
                            {{ ucfirst($user->member->status) }}
                        </span>
                    </div>
                    <div><span class="text-gray-400">Tipe:</span> {{ ucfirst($user->member->member_type ?? '-') }}</div>
                    <div><span class="text-gray-400">Institusi:</span> {{ $user->member->institution_name ?? '-' }}</div>
                </div>
                <a href="{{ route('admin.members.index') }}" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                    Edit data keanggotaan →
                </a>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2.5 px-4 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
@endsection
