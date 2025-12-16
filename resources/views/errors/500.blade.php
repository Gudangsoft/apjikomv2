<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | APJIKOM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #DC2626, #B91C1C, #991B1B, #7F1D1D);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .shake-animation {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-8 md:p-12 text-center">
            <!-- Icon -->
            <div class="mb-8 flex justify-center">
                <div class="w-32 h-32 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center shake-animation">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Code -->
            <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-600 mb-4">
                500
            </h1>

            <!-- Message -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                Server Error
            </h2>
            <p class="text-gray-600 text-lg mb-8">
                Maaf, terjadi kesalahan pada server. Tim kami telah diberitahu dan sedang memperbaikinya.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl hover:from-red-700 hover:to-red-800 transform transition-all hover:scale-105 shadow-lg">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Coba Lagi
                    </span>
                </button>
                <a href="{{ url('/') }}" class="px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transform transition-all hover:scale-105">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Jika masalah berlanjut, hubungi 
                    <a href="mailto:admin@apjikom.or.id" class="text-red-600 hover:text-red-700 font-medium">
                        admin@apjikom.or.id
                    </a>
                </p>
            </div>
        </div>

        <div class="text-center mt-6 text-white text-sm">
            <p>&copy; 2025 APJIKOM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
