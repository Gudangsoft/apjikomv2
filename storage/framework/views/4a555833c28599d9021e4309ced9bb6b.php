<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | APJIKOM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #DC2626, #B91C1C, #EF4444, #F87171);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-8 md:p-12 text-center">
            <!-- Icon -->
            <div class="mb-8 flex justify-center">
                <div class="float-animation">
                    <svg class="w-32 h-32 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Code -->
            <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 mb-4">
                403
            </h1>

            <!-- Message -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                Akses Ditolak
            </h2>
            <p class="text-gray-600 text-lg mb-8">
                <?php echo e($exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.'); ?>

            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard Admin
                        </a>
                    <?php elseif(auth()->user()->isMember()): ?>
                        <a href="<?php echo e(route('member.dashboard')); ?>" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard Member
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                
                <a href="<?php echo e(url('/')); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-200 border-2 border-gray-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem.
                </p>
            </div>
        </div>

        <!-- Footer Text -->
        <div class="text-center mt-8">
            <p class="text-white/90 text-sm">
                &copy; <?php echo e(date('Y')); ?> APJIKOM. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/wwwroot/apjikomv2/resources/views/errors/403.blade.php ENDPATH**/ ?>