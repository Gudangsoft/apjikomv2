<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Member - APJIKOM</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }
        
        .login-body {
            padding: 2.5rem 2rem;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-group svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .checkbox-custom:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <div class="login-container">
        <div class="login-card">
            <!-- Header with Logo -->
            <div class="login-header">
                <div class="flex items-center justify-center mb-4">
                    @if(site_logo())
                        <img src="{{ site_logo() }}" alt="APJIKOM" class="h-12 w-auto object-contain bg-white p-2 rounded mr-3">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="APJIKOM" class="h-12 mr-3">
                    @endif
                    <div class="text-left">
                        <h1 class="text-2xl font-bold">APJIKOM</h1>
                        <p class="text-white/90 text-xs">Member Dashboard</p>
                    </div>
                </div>
                <p class="text-white/80 text-sm mt-2">Asosiasi Pendidikan Jurnalistik dan Komunikasi</p>
            </div>

            <!-- Login Form -->
            <div class="login-body">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">Selamat Datang</h2>
                    <p class="text-gray-600 text-sm">Login ke dashboard member Anda</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif

                @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-sm mb-4">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('member.login.post') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="input-group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Email"
                            required 
                            autofocus>
                    </div>

                    <!-- Password Input -->
                    <div class="input-group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Password"
                            required>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="checkbox-custom mr-2">
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            Lupa password?
                        </a>
                        @endif
                    </div>

                    <!-- CAPTCHA -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Keamanan: Berapa hasil dari 
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-lg font-bold text-lg mx-1">
                                {{ session('member_captcha_num1', rand(1, 10)) }} + {{ session('member_captcha_num2', rand(1, 10)) }}
                            </span>
                            ?
                        </label>
                        <div class="input-group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <input 
                                type="number" 
                                name="captcha_answer" 
                                placeholder="Masukkan jawaban"
                                required>
                        </div>
                        @error('captcha_answer')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('registration.create') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
