<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Member Dashboard') - APJIKOM</title>
    
    @php
        $globalSiteFavicon = \App\Models\Setting::where('key', 'site_favicon')->value('value');
    @endphp
    
    @if($globalSiteFavicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSiteFavicon) }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-blue {
            background: linear-gradient(135deg, #667eea 0%, #4facfe 100%);
        }
        
        .card-shadow {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .dark .card-shadow {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
    </style>
    
    <!-- Dark Mode Script -->
    <script>
        const theme = localStorage.getItem('theme') || 'light';
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="gradient-purple text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-4">
                    @if(site_logo())
                        <img src="{{ site_logo() }}" alt="APJIKOM" class="h-12 w-auto object-contain bg-white p-1 rounded">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="APJIKOM" class="h-12">
                    @endif
                    <div>
                        <h1 class="text-xl font-bold">{{ site_name() }}</h1>
                        <p class="text-xs text-purple-200">{{ site_tagline() }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggleMember" class="p-2 rounded-lg hover:bg-purple-700 transition-colors" title="Toggle Dark Mode">
                        <svg id="sunIconMember" class="w-5 h-5 text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="moonIconMember" class="w-5 h-5 text-white block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    
                    <a href="{{ route('home') }}" class="hover:text-purple-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                    
                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ open: false }">
                        <a href="{{ route('member.notifications.index') }}" class="relative hover:text-purple-200 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php
                                $unreadCount = \App\Services\NotificationService::getUnreadCount(Auth::user());
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 hover:text-purple-200 transition">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-lg font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('member.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 transition">
                                Profile
                            </a>
                            <a href="{{ route('member.notifications.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 transition">
                                Notifikasi
                                @if($unreadCount > 0)
                                    <span class="ml-2 px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full">{{ $unreadCount }}</span>
                                @endif
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-purple-50 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg">
            <nav class="p-4 space-y-2">
                <a href="{{ route('member.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.dashboard') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('member.profile') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.profile') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Profil Saya</span>
                </a>
                
                <a href="{{ route('member.card') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.card') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="font-medium">Kartu Anggota</span>
                </a>
                
                <a href="{{ route('member.events.my') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.events.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span class="font-medium">Event Saya</span>
                </a>
                
                <a href="{{ route('member.testimonials.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.testimonials.*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span class="font-medium">Testimoni</span>
                </a>
                
                <a href="{{ route('member.update-requests.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.update-requests.*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="font-medium">Request Update</span>
                    @php
                        $myPendingRequests = \App\Models\UpdateRequest::where('user_id', Auth::id())->where('status', 'pending')->count();
                    @endphp
                    @if($myPendingRequests > 0)
                        <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $myPendingRequests }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('member.assignments.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('member.assignments.*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Penugasan Editor</span>
                    @php
                        $myPendingAssignments = \App\Models\Assignment::where('assigned_to_user_id', Auth::id())->whereIn('status', ['pending', 'in_progress'])->count();
                    @endphp
                    @if($myPendingAssignments > 0)
                        <span class="ml-auto bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $myPendingAssignments }}
                        </span>
                    @endif
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Dark Mode Toggle Script -->
    <script>
        const darkModeToggleMember = document.getElementById('darkModeToggleMember');
        const htmlElement = document.documentElement;
        
        function setTheme(theme) {
            if (theme === 'dark') {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
        
        if (darkModeToggleMember) {
            darkModeToggleMember.addEventListener('click', () => {
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
