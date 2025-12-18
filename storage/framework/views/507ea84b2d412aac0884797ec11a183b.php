

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Birthday Greeting Component -->
<?php echo $__env->make('components.birthday-greeting', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="space-y-6">
    <!-- First Login Welcome Message -->
    <?php if(session('first_login')): ?>
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold text-blue-800">
                    🎉 Selamat Datang di APJIKOM!
                </h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2">Terima kasih telah bergabung. Password default Anda adalah <strong>password123</strong></p>
                    <p class="font-medium">Untuk keamanan, segera:</p>
                    <ol class="list-decimal list-inside space-y-1 ml-2 mt-1">
                        <li>Lengkapi profil dan upload foto Anda</li>
                        <li>Ubah password default ke password yang lebih aman</li>
                        <li>Pastikan data kontak Anda benar</li>
                    </ol>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="<?php echo e(route('member.profile')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                        Lengkapi Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Profile Incomplete Alert -->
    <?php if(isset($needsProfileUpdate) && $needsProfileUpdate): ?>
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-semibold text-orange-800">
                    Lengkapi Profil Anda untuk Kartu Anggota (KTA)
                </h3>
                <div class="mt-2 text-sm text-orange-700">
                    <p class="mb-2">Data profil Anda belum lengkap. Silakan lengkapi:</p>
                    <ul class="list-disc list-inside space-y-1 ml-2">
                        <?php $__currentLoopData = $missingItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($item); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <p class="mt-3 font-medium">
                        Data lengkap diperlukan untuk pembuatan Kartu Tanda Anggota (KTA) yang valid.
                    </p>
                </div>
                <div class="mt-4">
                    <a href="<?php echo e(route('member.profile')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Lengkapi Profil Sekarang
                    </a>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 flex-shrink-0 text-orange-400 hover:text-orange-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Welcome Card -->
    <div class="bg-white rounded-xl card-shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, <?php echo e(Auth::user()->name); ?>!</h2>
                <p class="text-gray-600 mt-1">No. Anggota: <span class="font-semibold text-purple-600"><?php echo e($member->member_number ?? 'Belum ada'); ?></span></p>
            </div>
            <div class="w-20 h-20 gradient-purple rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Anggota -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Status Keanggotaan</h3>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800"><?php echo e(ucfirst($member->status)); ?></p>
            <p class="text-sm text-gray-500 mt-1">Member sejak <?php echo e($member->created_at->format('d M Y')); ?></p>
        </div>

        <!-- Masa Berlaku -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Masa Berlaku</h3>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <?php if(true): ?>
                <p class="text-2xl font-bold text-green-600">Seumur Hidup</p>
                <?php
                    $daysLeft = 999999; // Lifetime membership
                ?>
                <?php if($daysLeft > 0): ?>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($daysLeft); ?> hari lagi</p>
                <?php else: ?>
                    <p class="text-sm text-red-500 mt-1">Sudah berakhir</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-500">Belum diatur</p>
            <?php endif; ?>
        </div>

        <!-- Kartu Anggota -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-600 font-medium">Kartu Anggota</h3>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
            <?php if($member->member_card): ?>
                <p class="text-2xl font-bold text-green-600">Tersedia</p>
                <a href="<?php echo e(route('member.card')); ?>" class="text-sm text-purple-600 hover:text-purple-800 mt-1 inline-block">
                    Lihat kartu →
                </a>
            <?php else: ?>
                <p class="text-2xl font-bold text-orange-600">Belum Ada</p>
                <p class="text-sm text-gray-500 mt-1">Hubungi admin</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Member Card Preview -->
    <?php if($member->member_card): ?>
    <div class="bg-white rounded-xl card-shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Kartu Anggota Anda</h3>
        <div class="max-w-2xl mx-auto">
            <img src="<?php echo e(Storage::url($member->member_card)); ?>" 
                 alt="Kartu Anggota" 
                 class="w-full rounded-lg shadow-lg">
            <div class="mt-4 text-center">
                <a href="<?php echo e(route('member.card')); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Kartu
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profile Info -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Profil</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="font-medium text-gray-800"><?php echo e(Auth::user()->name); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Institusi</span>
                    <span class="font-medium text-gray-800"><?php echo e($member->institution_name ?? '-'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email</span>
                    <span class="font-medium text-gray-800"><?php echo e(Auth::user()->email); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kontak</span>
                    <span class="font-medium text-gray-800"><?php echo e($member->phone ?? '-'); ?></span>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <?php if($member->cv_file): ?>
                <a href="<?php echo e(asset('storage/' . $member->cv_file)); ?>" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Lihat CV Saya
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('member.profile')); ?>" 
                   class="block text-purple-600 hover:text-purple-800 font-medium">
                    Lihat Detail Profil →
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Menu Cepat</h3>
            <div class="space-y-3">
                <a href="<?php echo e(route('member.profile')); ?>" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Edit Profil</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="<?php echo e(route('member.card')); ?>" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Download Kartu</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="<?php echo e(route('news.index')); ?>" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Lihat Berita</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="<?php echo e(route('events.index')); ?>" 
                   class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Lihat Event</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold"><?php echo e($stats['total_members'] ?? 0); ?></p>
            <p class="text-blue-100 text-sm mt-1">Total Anggota Aktif</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold"><?php echo e($stats['total_news'] ?? 0); ?></p>
            <p class="text-green-100 text-sm mt-1">Berita Tersedia</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold"><?php echo e($stats['upcoming_events'] ?? 0); ?></p>
            <p class="text-purple-100 text-sm mt-1">Event Mendatang</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold"><?php echo e($stats['total_journals'] ?? 0); ?></p>
            <p class="text-orange-100 text-sm mt-1">Jurnal Ilmiah</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Member Growth Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">📈 Pertumbuhan Anggota</h3>
                <span class="text-xs text-gray-500">6 Bulan Terakhir</span>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="memberGrowthChart"></canvas>
            </div>
        </div>

        <!-- Activity Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">📊 Ringkasan Konten</h3>
                <span class="text-xs text-gray-500">Total Publikasi</span>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Recent News -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Berita Terbaru</h3>
                <a href="<?php echo e(route('news.index')); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentNews ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('news.show', $news)); ?>" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2"><?php echo e($news->title); ?></p>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($news->published_at->diffForHumans()); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada berita</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Event Mendatang</h3>
                <a href="<?php echo e(route('events.index')); ?>" class="text-purple-600 hover:text-purple-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('events.show', $event)); ?>" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2"><?php echo e($event->title); ?></p>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e(\Carbon\Carbon::parse($event->event_date)->format('d M Y')); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada event</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Journals -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Jurnal Terbaru</h3>
                <a href="<?php echo e(route('journals.index')); ?>" class="text-orange-600 hover:text-orange-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentJournals ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('journals.show', $journal)); ?>" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <p class="font-medium text-gray-800 text-sm line-clamp-2"><?php echo e($journal->title); ?></p>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($journal->published_date->format('Y')); ?> - Vol. <?php echo e($journal->volume); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada jurnal</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Member Growth Chart
    const memberGrowthCtx = document.getElementById('memberGrowthChart').getContext('2d');
    new Chart(memberGrowthCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(($memberGrowth ?? collect())->pluck('month')->map(function($m) {
                return \Carbon\Carbon::parse($m)->format('M Y');
            })); ?>,
            datasets: [{
                label: 'Anggota Baru',
                data: <?php echo json_encode(($memberGrowth ?? collect())->pluck('count')); ?>,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(99, 102, 241)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Activity Overview Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'doughnut',
        data: {
            labels: ['Berita', 'Event', 'Jurnal'],
            datasets: [{
                data: [
                    <?php echo e($stats['total_news'] ?? 0); ?>,
                    <?php echo e($stats['total_events'] ?? 0); ?>,
                    <?php echo e($stats['total_journals'] ?? 0); ?>

                ],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(168, 85, 247)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/member/dashboard.blade.php ENDPATH**/ ?>