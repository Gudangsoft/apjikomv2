<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ $siteName }} Admin</title>
    
    @if($globalSiteFavicon ?? null)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSiteFavicon) }}">
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
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
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="w-16 h-16 object-contain">
                @else
                    <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                @endif
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">{{ $siteName }}</h1>
            <p class="text-purple-100">Admin Panel Login</p>
        </div>

        <!-- Login Card -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 border border-white/20">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="admin@apjikom.or.id">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- CAPTCHA -->
                <div class="mb-6">
                    <label for="captcha" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keamanan: Berapa hasil dari 
                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-lg font-bold text-lg mx-1">
                            {{ session('captcha_num1', rand(1, 10)) }} + {{ session('captcha_num2', rand(1, 10)) }}
                        </span>
                        ?
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <input id="captcha" type="number" name="captcha_answer" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="Masukkan jawaban">
                    </div>
                    @error('captcha_answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transform transition-all hover:scale-[1.02] shadow-lg">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        LOG IN
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white text-sm">
            <p>&copy; 2025 APJIKOM. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Handle CSRF token refresh on page load
        window.addEventListener('DOMContentLoaded', function() {
            // Check if page has been open too long and refresh token
            const pageLoadTime = Date.now();
            
            // Refresh token every 2 hours automatically
            setInterval(() => {
                fetch('/login')
                    .then(() => {
                        console.log('Token refreshed');
                    })
                    .catch(() => {
                        console.log('Failed to refresh token');
                    });
            }, 7200000); // 2 hours
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        function loginDefault() {
            // Refresh page first to get new CSRF token
            if (!sessionStorage.getItem('tokenRefreshed')) {
                sessionStorage.setItem('tokenRefreshed', 'true');
                window.location.reload();
                return;
            }
            
            sessionStorage.removeItem('tokenRefreshed');
            document.getElementById('email').value = 'admin@apjikom.or.id';
            document.getElementById('password').value = 'password';
            
            // Auto submit form
            setTimeout(() => {
                document.getElementById('loginForm').submit();
            }, 300);
        }

        // Auto-fill on page load if error exists (untuk memudahkan testing)
        window.addEventListener('DOMContentLoaded', function() {
            const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
            if (hasErrors && !document.getElementById('email').value) {
                document.getElementById('email').value = 'admin@apjikom.or.id';
            }
        });
    </script>
</body>
</html>
