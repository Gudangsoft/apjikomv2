<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin - <?php echo e($globalSiteName); ?></title>
    
    <?php if($globalSiteFavicon): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/' . $globalSiteFavicon)); ?>">
    <?php endif; ?>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Fix untuk memastikan content tidak terhalang */
        .admin-wrapper {
            min-height: 100vh;
            display: flex;
        }
        
        .admin-sidebar {
            width: 16rem;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            flex-shrink: 0;
        }
        
        .admin-main {
            flex: 1;
            min-width: 0;
            background-color: #f9fafb;
            margin-left: 16rem;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar bg-gradient-to-b from-purple-900 to-purple-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-purple-700">
                <div class="flex items-center space-x-2">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center">
                        <?php if($globalSiteLogo): ?>
                            <img src="<?php echo e(asset('storage/' . $globalSiteLogo)); ?>" alt="<?php echo e($globalSiteName); ?>" class="w-7 h-7 object-contain">
                        <?php else: ?>
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="text-base font-bold"><?php echo e($globalSiteName); ?></h1>
                        <p class="text-xs text-purple-200">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-3 pb-8 space-y-0.5 overflow-y-auto" style="max-height: calc(100vh - 100px);" x-data="{ 
                openMenu: '<?php echo e(request()->routeIs("admin.dashboard") ? "" : (request()->routeIs("admin.news.*") || request()->routeIs("admin.events.*") || request()->routeIs("admin.categories.*") || request()->routeIs("admin.about-page.*") || request()->routeIs("admin.organizational-structure.*") || request()->routeIs("admin.services.*") ? "konten" : (request()->routeIs("admin.journals.*") ? "publikasi" : (request()->routeIs("admin.members.*") || request()->routeIs("admin.card-templates.*") || request()->routeIs("admin.certificate-templates.*") || request()->routeIs("admin.registrations.*") ? "keanggotaan" : (request()->routeIs("admin.sliders.*") || request()->routeIs("admin.pages.*") || request()->routeIs("admin.menus.*") || request()->routeIs("admin.partners.*") || request()->routeIs("admin.section-labels.*") ? "tampilan" : (request()->routeIs("admin.settings.*") || request()->routeIs("admin.about-settings.*") || request()->routeIs("admin.footer-settings.*") || request()->routeIs("admin.social-media.*") ? "pengaturan" : "")))))); ?>' 
            }"">
                <!-- Dashboard -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <!-- KELOMPOK: Konten Website -->
                <div class="mt-2">
                    <button @click="openMenu = openMenu === 'konten' ? '' : 'konten'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm hover:bg-white/5 transition-all" :class="openMenu === 'konten' ? 'bg-white/5' : ''">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold">Konten Website</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openMenu === 'konten' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openMenu === 'konten'" x-collapse class="ml-3 mt-1 space-y-0.5 border-l-2 border-white/10 pl-4">
                        <a href="<?php echo e(route('admin.news.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.news.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <span>Berita</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.events.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.events.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span>Kegiatan</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <span>Kategori</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.about-page.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.about-page.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span>Halaman Tentang</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.organizational-structure.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.organizational-structure.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <span>Struktur Organisasi</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.services.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.services.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span>Layanan & Program</span>
                        </a>
                    </div>
                </div>
                
                <!-- KELOMPOK: Keanggotaan -->
                <div class="mt-2">
                    <button @click="openMenu = openMenu === 'keanggotaan' ? '' : 'keanggotaan'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm hover:bg-white/5 transition-all" :class="openMenu === 'keanggotaan' ? 'bg-white/5' : ''">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold">Keanggotaan</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openMenu === 'keanggotaan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openMenu === 'keanggotaan'" x-collapse class="ml-3 mt-1 space-y-0.5 border-l-2 border-white/10 pl-4">
                        <a href="<?php echo e(route('admin.members.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.members.*') && !request()->routeIs('admin.card-templates.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <span>Members</span>
                            </div>
                            <?php
                                $newMembersCount = \App\Models\Member::where(function($query) {
                                    $query->whereNull('member_card')
                                          ->where('card_requested', true);
                                })->orWhere(function($query) {
                                    $query->whereNull('member_card')
                                          ->whereNotNull('photo')
                                          ->whereNotNull('address')
                                          ->whereNotNull('phone');
                                })->count();
                                
                                $pendingRegistrations = \App\Models\Registration::where('status', 'pending')->count();
                                
                                $totalNotifications = $newMembersCount + $pendingRegistrations;
                            ?>
                            <?php if($totalNotifications > 0): ?>
                                <span class="px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full <?php echo e($pendingRegistrations > 0 ? 'animate-pulse' : ''); ?>"><?php echo e($totalNotifications); ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <a href="<?php echo e(route('admin.card-templates.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.card-templates.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <span>Template Kartu</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.certificate-templates.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.certificate-templates.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span>Template Sertifikat</span>
                        </a>
                    </div>
                </div>
                
                <!-- KELOMPOK: Tampilan & UI -->
                <div class="mt-2">
                    <button @click="openMenu = openMenu === 'tampilan' ? '' : 'tampilan'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm hover:bg-white/5 transition-all" :class="openMenu === 'tampilan' ? 'bg-white/5' : ''">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold">Tampilan & UI</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openMenu === 'tampilan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openMenu === 'tampilan'" x-collapse class="ml-3 mt-1 space-y-0.5 border-l-2 border-white/10 pl-4">
                        <a href="<?php echo e(route('admin.sliders.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.sliders.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span>Slider</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.pages.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.pages.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span>Halaman</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.menus.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.menus.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </div>
                            <span>Menu Dinamis</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.partners.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.partners.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span>Partner</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.section-labels.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.section-labels.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <span>Label Section</span>
                        </a>
                    </div>
                </div>
                
                <hr class="my-3 border-white/10">
                
                <!-- KELOMPOK: Pengaturan -->
                <div class="mt-2">
                    <button @click="openMenu = openMenu === 'pengaturan' ? '' : 'pengaturan'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm hover:bg-white/5 transition-all" :class="openMenu === 'pengaturan' ? 'bg-white/5' : ''">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold">Pengaturan</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="openMenu === 'pengaturan' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openMenu === 'pengaturan'" x-collapse class="ml-3 mt-1 space-y-0.5 border-l-2 border-white/10 pl-4">
                        <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span>Pengaturan Umum</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.about-settings.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.about-settings.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span>Section Tentang</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.footer-settings.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.footer-settings.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </div>
                            <span>Menu Footer</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.social-media.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.social-media.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                            </div>
                            <span>Media Sosial</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.email-settings.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.email-settings.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span>Email & Notifikasi</span>
                        </a>
                    </div>
                </div>
                
                <hr class="my-3 border-white/10">
                
                <!-- Changelog Menu -->
                <a href="<?php echo e(route('admin.changelog.index')); ?>" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.changelog.*') || request()->routeIs('admin.update-requests.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="flex items-center space-x-3">
                        <div class="w-5 h-5 flex items-center justify-center <?php echo e(request()->routeIs('admin.changelog.*') || request()->routeIs('admin.update-requests.*') ? 'text-yellow-300' : 'text-white/60'); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Changelog & Updates</span>
                    </div>
                    <?php
                        try {
                            $pendingRequests = \App\Models\UpdateRequest::where('status', 'pending')->count();
                        } catch (\Exception $e) {
                            $pendingRequests = 0;
                        }
                    ?>
                    <?php if($pendingRequests > 0): ?>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                            <?php echo e($pendingRequests); ?>

                        </span>
                    <?php endif; ?>
                </a>
                
                <hr class="my-3 border-white/10">
                
                <!-- Users Menu -->
                <div x-data="{ openUsers: <?php echo e(request()->routeIs('admin.users.*') || request()->routeIs('admin.password-reset-requests.*') ? 'true' : 'false'); ?> }">
                    <button @click="openUsers = !openUsers" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-all hover:bg-white/5">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Users</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': openUsers }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="openUsers" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.users.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Kelola User</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.assignments.index')); ?>" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.assignments.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Penugasan Editor</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.password-reset-requests.index')); ?>" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.password-reset-requests.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                <span>Reset Password</span>
                            </div>
                            <?php
                                $pendingResetRequests = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
                            ?>
                            <?php if($pendingResetRequests > 0): ?>
                                <span class="px-2 py-0.5 text-xs font-bold bg-orange-500 text-white rounded-full"><?php echo e($pendingResetRequests); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                
                <!-- Data Instansi -->
                <a href="<?php echo e(route('admin.institutions.index')); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.institutions.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Data Instansi</span>
                </a>
                
                <!-- FAQ -->
                <a href="<?php echo e(route('admin.faqs.index')); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.faqs.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">FAQ</span>
                </a>
                
                <!-- Testimonials -->
                <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Testimoni</span>
                </a>
                
                <!-- Gallery -->
                <a href="<?php echo e(route('admin.galleries.index')); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all <?php echo e(request()->routeIs('admin.galleries.*') ? 'bg-white/10 shadow-lg' : 'hover:bg-white/5'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Gallery</span>
                </a>
                
                <hr class="my-3 border-white/10">
                
                <!-- Lihat Website -->
                <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 transition-all shadow-md">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Lihat Website</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="admin-main flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Update Request Badge -->
                        <?php
                            $pendingUpdateRequests = \App\Models\UpdateRequest::where('status', 'pending')->count();
                        ?>
                        <?php if($pendingUpdateRequests > 0): ?>
                        <a href="<?php echo e(route('admin.changelog.index')); ?>#requests" 
                           class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors group"
                           title="Update Requests Pending">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-orange-500 rounded-full animate-pulse">
                                <?php echo e($pendingUpdateRequests); ?>

                            </span>
                            <span class="absolute bottom-full mb-2 right-0 hidden group-hover:block px-3 py-2 text-xs text-white bg-gray-900 rounded-lg whitespace-nowrap">
                                <?php echo e($pendingUpdateRequests); ?> Update Request<?php echo e($pendingUpdateRequests > 1 ? 's' : ''); ?> Pending
                            </span>
                        </a>
                        <?php endif; ?>
                        
                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ 
                            open: false, 
                            unreadCount: 0,
                            notifications: [],
                            async fetchUnreadCount() {
                                try {
                                    const response = await fetch('<?php echo e(route("admin.notifications.unread-count")); ?>');
                                    const data = await response.json();
                                    this.unreadCount = data.count || 0;
                                } catch (error) {
                                    console.error('Error fetching unread count:', error);
                                }
                            },
                            async fetchNotifications() {
                                try {
                                    const response = await fetch('<?php echo e(route("admin.notifications.index")); ?>?ajax=1');
                                    const data = await response.json();
                                    this.notifications = data.notifications || [];
                                } catch (error) {
                                    console.error('Error fetching notifications:', error);
                                }
                            },
                            async markAsRead(id) {
                                try {
                                    await fetch(`<?php echo e(url('admin/notifications')); ?>/${id}/read`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                    this.fetchUnreadCount();
                                    this.fetchNotifications();
                                } catch (error) {
                                    console.error('Error marking as read:', error);
                                }
                            }
                        }" x-init="fetchUnreadCount(); fetchNotifications(); setInterval(() => { fetchUnreadCount(); fetchNotifications(); }, 30000)">
                            <button @click="open = !open; if(open) fetchNotifications()" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span x-show="unreadCount > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full" x-text="unreadCount"></span>
                            </button>
                            
                            <!-- Dropdown Notifikasi -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border z-50">
                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                                        <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                                    </div>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <p class="p-4 text-sm text-gray-500 text-center">Tidak ada notifikasi baru</p>
                                    </template>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div class="border-b hover:bg-gray-50 transition-colors" :class="notif.read_at ? 'bg-white' : 'bg-blue-50'">
                                            <div class="p-4" @click="markAsRead(notif.id)">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 rounded-full flex items-center justify-center" :class="notif.color === 'green' ? 'bg-green-100 text-green-600' : notif.color === 'blue' ? 'bg-blue-100 text-blue-600' : notif.color === 'orange' ? 'bg-orange-100 text-orange-600' : notif.color === 'yellow' ? 'bg-yellow-100 text-yellow-600' : 'bg-purple-100 text-purple-600'">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <template x-if="notif.icon === 'user'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </template>
                                                                <template x-if="notif.icon === 'id-card'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                                </template>
                                                                <template x-if="notif.icon === 'refresh'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                                </template>
                                                                <template x-if="notif.icon === 'key'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                                </template>
                                                                <template x-if="notif.icon === 'user-plus'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                                </template>
                                                                <template x-if="notif.icon === 'message'">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                                </template>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-gray-900" x-text="notif.title"></p>
                                                        <p class="text-xs text-gray-600 mt-1" x-text="notif.message"></p>
                                                        <p class="text-xs text-gray-400 mt-1" x-text="notif.time_ago"></p>
                                                    </div>
                                                    <template x-if="!notif.read_at">
                                                        <div class="flex-shrink-0">
                                                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                                <template x-if="notif.action_url">
                                                    <a :href="notif.action_url" class="inline-block mt-2 text-xs text-blue-600 hover:underline" x-text="notif.action_text || 'Lihat Detail'"></a>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        
                        <span class="text-sm text-gray-600"><?php echo e(auth()->user()->name); ?></span>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-sm text-red-600 hover:text-red-700">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <?php if(session('success')): ?>
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>
                
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/layouts/admin.blade.php ENDPATH**/ ?>