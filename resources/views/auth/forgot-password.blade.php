<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - {{ $siteName }}</title>

    @if($globalSiteFavicon ?? null)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSiteFavicon) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes gradient {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #7C3AED, #5B21B6, #6366F1, #8B5CF6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-3 sm:p-4">
    <div class="w-full max-w-md">

        {{-- Logo & Title --}}
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl shadow-lg mb-3 sm:mb-4">
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="w-12 h-12 sm:w-16 sm:h-16 object-contain">
                @else
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ $siteName }}</h1>
            <p class="text-sm sm:text-base text-purple-100">Reset Password</p>
        </div>

        {{-- Card --}}
        <div class="glass-effect rounded-2xl shadow-2xl p-6 sm:p-8 border border-white/20">

            {{-- Success status --}}
            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Instruction --}}
            <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-purple-700">Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk mereset password Anda.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border {{ $errors->get('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="email@contoh.com">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-xl text-sm font-semibold hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transform transition-all hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Kirim Link Reset Password
                </button>
            </form>

            {{-- Back to login --}}
            <div class="mt-5 text-center">
                <a href="{{ route('member.login') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center justify-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke halaman login
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-5 text-white text-xs">
            <p>{!! $globalCopyrightText ?? '&copy; ' . date('Y') . ' ' . $siteName !!}</p>
        </div>
    </div>
</body>
</html>
