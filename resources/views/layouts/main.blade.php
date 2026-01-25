<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ setting('site_name', 'APJIKOM') }} - @yield('title', setting('site_tagline', 'Asosiasi Pengelola Jurnal Informatika dan Komputer'))</title>
    <meta name="description" content="{{ setting('meta_description', setting('site_description', 'APJIKOM - Asosiasi Pengelola Jurnal Informatika dan Komputer Indonesia')) }}">
    <meta name="keywords" content="{{ setting('meta_keywords', 'apjikom, jurnal ilmiah, informatika, komputer, teknologi informasi, publikasi ilmiah') }}">
    @if(setting('site_favicon'))
    <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_favicon')) }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Dark mode configuration for Tailwind
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Analytics -->
    @if(setting('google_analytics'))
    {!! setting('google_analytics') !!}
    @endif
    
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .dark body {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);
        }
        
        .apjikom-purple {
            background-color: #7C3AED;
        }
        
        .apjikom-dark-purple {
            background-color: #5B21B6;
        }
        
        .news-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .dark .news-card {
            background-color: #1e293b;
            border-color: #334155;
        }
        
        .news-card:hover {
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
            border-color: #7C3AED;
        }
        
        .navbar-fixed {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: background-color 0.3s ease;
        }
        
        .dark .navbar-fixed {
            background: #1e293b;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .stats-card {
            background: white;
            border: 2px solid #7C3AED;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .dark .stats-card {
            background: #1e293b;
            border-color: #7C3AED;
        }
        
        .btn-apjikom {
            background-color: #7C3AED;
            transition: background-color 0.3s ease;
        }
        
        .btn-apjikom:hover {
            background-color: #5B21B6;
        }
        
        /* Dark mode transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        
        /* Fix untuk mencegah overlap */
        .container {
            width: 100%;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        main {
            display: block;
            width: 100%;
            overflow-x: hidden;
        }
        
        /* Dark mode toggle animation */
        .dark-mode-toggle {
            transition: transform 0.3s ease;
        }
        
        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }
    </style>
    
    <!-- Dark Mode Script (must be in head to prevent flash) -->
    <script>
        // Check for saved theme preference or default to light mode
        const theme = localStorage.getItem('theme') || 'light';
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body class="antialiased bg-gray-50 dark:bg-dark-900 text-gray-900 dark:text-gray-100">
    <!-- Top Bar -->
    <div class="apjikom-dark-purple text-white text-xs dark:bg-dark-800">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between items-center">
                <div class="flex space-x-4">
                    @if(setting('contact_email'))
                    <span class="flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        {{ setting('contact_email') }}
                    </span>
                    @endif
                    @if(setting('contact_phone'))
                    <span class="flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        {{ setting('contact_phone') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar-fixed bg-white dark:bg-dark-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center space-x-3">
                    @if(site_logo())
                        <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-12 w-auto object-contain">
                    @else
                        <div class="w-10 h-10 apjikom-purple rounded flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr(site_name(), 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ site_name() }}</h1>
                        <p class="text-xs text-gray-600 dark:text-gray-400 hidden sm:block">{{ setting('site_tagline', 'Asosiasi Pengelola Jurnal Informatika dan Komputer') }}</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Static Menu Items -->
                    <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('home') ? 'text-purple-600 dark:text-purple-400' : '' }}">Beranda</a>
                    <a href="{{ route('about.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('about.*') ? 'text-purple-600 dark:text-purple-400' : '' }}">Tentang</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('news.*') ? 'text-purple-600 dark:text-purple-400' : '' }}">Berita</a>
                    <a href="{{ route('events.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('events.*') ? 'text-purple-600 dark:text-purple-400' : '' }}">Kegiatan</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('services.*') ? 'text-purple-600 dark:text-purple-400' : '' }}">Layanan</a>
                    <a href="{{ route('directory.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium text-sm {{ request()->routeIs('directory.*') ? 'text-purple-600 dark:text-purple-400' : '' }}">Anggota</a>
                    
                    <!-- Dynamic Menu Items -->
                    @include('components.dynamic-menu')
                    
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="dark-mode-toggle p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle Dark Mode">
                        <svg id="sunIcon" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="moonIcon" class="w-5 h-5 text-gray-700 dark:text-gray-300 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    
                    @auth
                        @if(!Auth::user()->isAdmin())
                            @if(Auth::user()->member)
                                <a href="{{ route('member.dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium text-sm {{ request()->routeIs('member.*') ? 'text-purple-600' : '' }}">
                                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium text-sm">Dashboard</a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('member.login') }}" class="text-gray-700 hover:text-purple-600 font-medium text-sm {{ request()->routeIs('member.login') ? 'text-purple-600' : '' }}">Login Member</a>
                        <a href="{{ route('registration.create') }}" class="apjikom-purple text-white px-5 py-2 rounded text-sm font-medium hover:bg-purple-700">Bergabung</a>
                    @endauth
                </div>
                
                <button class="md:hidden text-gray-700" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="md:hidden hidden pb-4" id="mobile-menu">
                <!-- Static Menu Items -->
                <a href="{{ route('home') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Beranda</a>
                <a href="{{ route('about.index') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Tentang</a>
                <a href="{{ route('news.index') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Berita</a>
                <a href="{{ route('events.index') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Kegiatan</a>
                <a href="{{ route('services.index') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Layanan</a>
                <a href="{{ route('directory.index') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Anggota</a>
                
                <!-- Dynamic Menu Items -->
                @include('components.dynamic-menu-mobile')
                
                @auth
                    @if(!Auth::user()->isAdmin())
                        @if(Auth::user()->member)
                            <a href="{{ route('member.dashboard') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Dashboard Member</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Dashboard</a>
                        @endif
                    @endif
                @else
                    <a href="{{ route('member.login') }}" class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">Login Member</a>
                    <a href="{{ route('registration.create') }}" class="block py-3 text-sm text-purple-600 font-medium border-b border-gray-200">Bergabung</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->

    <main>
        @if(session('success'))
            <div class="max-w-2xl mx-auto mt-6">
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4 text-center font-semibold">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-2xl mx-auto mt-6">
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-4 text-center font-semibold">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if(session('info'))
            <div class="max-w-2xl mx-auto mt-6">
                <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded-lg mb-4 text-center font-semibold">
                    {{ session('info') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="apjikom-dark-purple text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto object-contain bg-white p-1 rounded">
                        @else
                            <div class="w-10 h-10 bg-white rounded flex items-center justify-center text-purple-600 font-bold">
                                {{ strtoupper(substr(site_name(), 0, 2)) }}
                            </div>
                        @endif
                        <span class="text-xl font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-purple-200 text-sm mb-4">{{ setting('site_description', setting('site_tagline', 'Asosiasi Pengelola Jurnal Informatika dan Komputer Indonesia')) }}</p>
                    <div class="flex space-x-3">
                        @if(setting('facebook_url'))
                        <a href="{{ setting('facebook_url') }}" target="_blank" class="w-8 h-8 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-opacity-20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if(setting('twitter_url'))
                        <a href="{{ setting('twitter_url') }}" target="_blank" class="w-8 h-8 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-opacity-20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        @endif
                        @if(setting('linkedin_url'))
                        <a href="{{ setting('linkedin_url') }}" target="_blank" class="w-8 h-8 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-opacity-20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        @endif
                        @if(setting('instagram_url'))
                        <a href="{{ setting('instagram_url') }}" target="_blank" class="w-8 h-8 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-opacity-20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                        @if(setting('youtube_url'))
                        <a href="{{ setting('youtube_url') }}" target="_blank" class="w-8 h-8 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-opacity-20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm">{{ setting('footer_menu1_title', 'Menu') }}</h4>
                    <ul class="space-y-2 text-purple-200 text-sm">
                        @if(setting('footer_menu1_item1_label'))
                        <li><a href="{{ setting('footer_menu1_item1_url', '#') }}" class="hover:text-white">{{ setting('footer_menu1_item1_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu1_item2_label'))
                        <li><a href="{{ setting('footer_menu1_item2_url', '#') }}" class="hover:text-white">{{ setting('footer_menu1_item2_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu1_item3_label'))
                        <li><a href="{{ setting('footer_menu1_item3_url', '#') }}" class="hover:text-white">{{ setting('footer_menu1_item3_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu1_item4_label'))
                        <li><a href="{{ setting('footer_menu1_item4_url', '#') }}" class="hover:text-white">{{ setting('footer_menu1_item4_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu1_item5_label'))
                        <li><a href="{{ setting('footer_menu1_item5_url', '#') }}" class="hover:text-white">{{ setting('footer_menu1_item5_label') }}</a></li>
                        @endif
                        
                        @if(!setting('footer_menu1_item1_label'))
                        <!-- Default menu jika belum diatur -->
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white">Kegiatan</a></li>
                        <li><a href="{{ route('directory.index') }}" class="hover:text-white">Direktori Anggota</a></li>
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        @endif
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm">{{ setting('footer_menu2_title', 'Layanan') }}</h4>
                    <ul class="space-y-2 text-purple-200 text-sm">
                        @if(setting('footer_menu2_item1_label'))
                        <li><a href="{{ setting('footer_menu2_item1_url', '#') }}" class="hover:text-white">{{ setting('footer_menu2_item1_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu2_item2_label'))
                        <li><a href="{{ setting('footer_menu2_item2_url', '#') }}" class="hover:text-white">{{ setting('footer_menu2_item2_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu2_item3_label'))
                        <li><a href="{{ setting('footer_menu2_item3_url', '#') }}" class="hover:text-white">{{ setting('footer_menu2_item3_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu2_item4_label'))
                        <li><a href="{{ setting('footer_menu2_item4_url', '#') }}" class="hover:text-white">{{ setting('footer_menu2_item4_label') }}</a></li>
                        @endif
                        @if(setting('footer_menu2_item5_label'))
                        <li><a href="{{ setting('footer_menu2_item5_url', '#') }}" class="hover:text-white">{{ setting('footer_menu2_item5_label') }}</a></li>
                        @endif
                        
                        @if(!setting('footer_menu2_item1_label'))
                        <!-- Default menu jika belum diatur -->
                        <li><a href="#" class="hover:text-white">Konsultasi Jurnal</a></li>
                        <li><a href="#" class="hover:text-white">Akreditasi</a></li>
                        <li><a href="#" class="hover:text-white">Pelatihan</a></li>
                        <li><a href="#" class="hover:text-white">Publikasi</a></li>
                        @endif
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm">Kontak</h4>
                    <ul class="space-y-2 text-purple-200 text-sm">
                        @if(setting('contact_address'))
                            @foreach(explode("\n", setting('contact_address')) as $line)
                            <li>{{ $line }}</li>
                            @endforeach
                        @endif
                        @if(setting('contact_email'))
                        <li class="pt-2">
                            <a href="mailto:{{ setting('contact_email') }}" class="hover:text-white">{{ setting('contact_email') }}</a>
                        </li>
                        @endif
                        @if(setting('contact_phone'))
                        <li>
                            <a href="tel:{{ setting('contact_phone') }}" class="hover:text-white">{{ setting('contact_phone') }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-200 text-xs">
                <p>{{ setting('footer_copyright_text', '© ' . date('Y') . ' ' . site_name() . '. All Rights Reserved.') }}</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Mobile submenu toggle
        function toggleMobileSubmenu(id) {
            const submenu = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Partners Slider
        if (document.querySelector('.partnersSwiper')) {
            new Swiper('.partnersSwiper', {
                slidesPerView: 2,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                speed: 1000,
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 50,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 60,
                    },
                    1280: {
                        slidesPerView: 6,
                        spaceBetween: 60,
                    },
                },
            });
        }
    </script>
    
    <!-- Dark Mode Toggle Script -->
    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const htmlElement = document.documentElement;
        
        // Function to set theme
        function setTheme(theme) {
            if (theme === 'dark') {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
        
        // Toggle dark mode
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                if (htmlElement.classList.contains('dark')) {
                    setTheme('light');
                } else {
                    setTheme('dark');
                }
            });
        }
    </script>
</body>
</html>
