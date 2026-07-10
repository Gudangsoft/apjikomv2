@extends('layouts.main')

@section('title', 'Direktori Anggota')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white py-16 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="text-6xl mb-4">👥</div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Direktori Anggota</h1>
            <p class="text-xl text-blue-100 mb-8">Temukan dan terhubung dengan anggota {{ site_name() }}</p>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('directory.index') }}" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan nama, institusi, posisi, atau keahlian..." 
                           class="w-full px-6 py-4 pr-12 rounded-full text-gray-900 text-lg shadow-2xl focus:ring-4 focus:ring-white/30 focus:outline-none">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-3 rounded-full hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Statistics Bar -->
<div class="bg-white shadow-md border-b">
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-3 gap-6 max-w-3xl mx-auto text-center">
            <div>
                <div class="text-3xl font-bold text-blue-600">{{ $statistics['total'] }}</div>
                <div class="text-sm text-gray-600 mt-1">Total Anggota</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-indigo-600">{{ $statistics['individual'] }}</div>
                <div class="text-sm text-gray-600 mt-1">Anggota Perorangan</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-600">{{ $statistics['institution'] }}</div>
                <div class="text-sm text-gray-600 mt-1">Institusi</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="py-12 bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter & Urutan
                    </h3>
                    
                    <form method="GET" action="{{ route('directory.index') }}" id="filterForm">
                        @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <!-- Member Type Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Anggota</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Jenis</option>
                                <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Perorangan</option>
                                <option value="institution" {{ request('type') == 'institution' ? 'selected' : '' }}>Institusi</option>
                            </select>
                        </div>
                        
                        <!-- Institution Filter -->
                        @if($institutions->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Institusi</label>
                            <select name="institution" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Institusi</option>
                                @foreach($institutions as $institution)
                                <option value="{{ $institution }}" {{ request('institution') == $institution ? 'selected' : '' }}>
                                    {{ $institution }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <!-- Sort Options -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan Berdasarkan</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="document.getElementById('filterForm').submit()">
                                <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="institution" {{ request('sort') == 'institution' ? 'selected' : '' }}>Institusi</option>
                            </select>
                        </div>
                        
                        <!-- Clear Filters -->
                        @if(request()->hasAny(['search', 'type', 'institution', 'sort']))
                        <a href="{{ route('directory.index') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            Reset Filter
                        </a>
                        @endif
                    </form>
                </div>

                {{-- ── Sebaran Anggota Chart ── --}}
                @if($institutionChart->count() > 0 || $provinceChart->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-5 mt-4">

                    {{-- Header --}}
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Sebaran Anggota</span>
                    </div>

                    {{-- Tabs --}}
                    @if($institutionChart->count() > 0 && $provinceChart->count() > 0)
                    <div class="flex gap-1 mb-4 bg-gray-100 rounded-lg p-1">
                        <button onclick="switchMemberChart('institution')" id="mctab-institution"
                                class="flex-1 py-1 px-2 rounded-md text-xs font-semibold transition-all bg-white text-blue-600 shadow-sm">
                            Institusi
                        </button>
                        <button onclick="switchMemberChart('province')" id="mctab-province"
                                class="flex-1 py-1 px-2 rounded-md text-xs font-semibold transition-all text-gray-500 hover:text-gray-700">
                            Provinsi
                        </button>
                    </div>
                    @elseif($provinceChart->count() > 0)
                    <p class="text-xs font-semibold text-gray-500 mb-3">Berdasarkan Provinsi</p>
                    @else
                    <p class="text-xs font-semibold text-gray-500 mb-3">Berdasarkan Institusi</p>
                    @endif

                    {{-- Institution Panel --}}
                    @if($institutionChart->count() > 0)
                    @php $maxInst = $institutionChart->max(); @endphp
                    <div id="mc-panel-institution" class="space-y-2.5">
                        @foreach($institutionChart as $instName => $instCount)
                        @php $instPct = $maxInst > 0 ? round($instCount / $maxInst * 100) : 0; @endphp
                        <div>
                            <div class="flex items-baseline justify-between gap-1 mb-1">
                                <span class="text-xs text-gray-700 leading-tight truncate" style="max-width:78%"
                                      title="{{ $instName }}">
                                    {{ \Illuminate\Support\Str::limit($instName, 28) }}
                                </span>
                                <span class="text-xs font-bold text-gray-900 flex-shrink-0">{{ $instCount }}</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 chart-bar"
                                     data-width="{{ $instPct }}" style="width:0%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Province Panel --}}
                    @if($provinceChart->count() > 0)
                    @php $maxProv = $provinceChart->max(); @endphp
                    <div id="mc-panel-province" class="{{ $institutionChart->count() > 0 ? 'hidden' : '' }} space-y-2.5">
                        @foreach($provinceChart as $provName => $provCount)
                        @php $provPct = $maxProv > 0 ? round($provCount / $maxProv * 100) : 0; @endphp
                        <div>
                            <div class="flex items-baseline justify-between gap-1 mb-1">
                                <span class="text-xs text-gray-700 leading-tight truncate" style="max-width:78%"
                                      title="{{ $provName }}">
                                    {{ \Illuminate\Support\Str::limit($provName, 28) }}
                                </span>
                                <span class="text-xs font-bold text-gray-900 flex-shrink-0">{{ $provCount }}</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-purple-500 to-pink-500 chart-bar"
                                     data-width="{{ $provPct }}" style="width:0%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <p class="text-[10px] text-gray-400 mt-3 text-center">Hanya anggota terverifikasi</p>
                </div>
                @endif
            </div>
            
            <!-- Members Grid -->
            <div class="flex-1">
                @if($members->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    @foreach($members as $member)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 h-24"></div>
                        
                        <div class="relative -mt-12 px-6">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-xl overflow-hidden bg-white">
                                @php
                                    $photoUrl = null;
                                    $photoPath = $member->user->photo ?? $member->photo;
                                    
                                    if ($photoPath) {
                                        if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
                                            $photoUrl = $photoPath;
                                        } else {
                                            if (strpos($photoPath, 'member-photos/') === 0) {
                                                $photoUrl = asset('storage/' . $photoPath);
                                            } elseif (strpos($photoPath, 'storage/') === 0) {
                                                $photoUrl = asset($photoPath);
                                            } else {
                                                $photoUrl = asset('storage/' . $photoPath);
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if($photoUrl)
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $member->user->name ?? $member->institution_name }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full hidden items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                    </svg>
                                </div>
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-100">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-6 pt-4 text-center">
                            <!-- Name -->
                            <h3 class="text-lg font-bold text-gray-900 mb-1">
                                {{ $member->user->name ?? $member->institution_name }}
                            </h3>
                            
                            <!-- Badges -->
                            <div class="flex items-center justify-center gap-2 mb-2 flex-wrap">
                                <!-- Member Type Badge -->
                                @if($member->member_type === 'individual')
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                    Anggota Perorangan
                                </span>
                                @else
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                    Institusi
                                </span>
                                @endif
                                
                                <!-- Verified Badge -->
                                <x-verified-badge :member="$member" size="sm" />
                            </div>
                            
                            <!-- Position & Institution -->
                            @if($member->position || $member->institution_name)
                            <p class="text-sm text-gray-600 mb-1">
                                @if($member->position)
                                <span class="font-medium">{{ $member->position }}</span>
                                @endif
                                @if($member->position && $member->institution_name)
                                <span class="text-gray-400"> · </span>
                                @endif
                                @if($member->institution_name)
                                <span>{{ $member->institution_name }}</span>
                                @endif
                            </p>
                            @endif
                            
                            <!-- Expertise Tags -->
                            @if($member->expertise)
                            <div class="mt-3 flex flex-wrap gap-2 justify-center">
                                @foreach(array_slice(explode(',', $member->expertise), 0, 3) as $skill)
                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-md">
                                    {{ trim($skill) }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Member Since -->
                            <p class="text-xs text-gray-500 mt-3">
                                Bergabung {{ $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('M Y') : '-' }}
                            </p>
                            
                            <!-- View Profile Button -->
                            <a href="{{ route('directory.show', $member) }}" 
                               class="mt-4 inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-full hover:shadow-lg transition-all duration-300 hover:scale-105">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $members->withQueryString()->links() }}
                </div>
                
                @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Anggota Ditemukan</h3>
                    <p class="text-gray-600 mb-6">
                        @if(request()->hasAny(['search', 'type', 'institution']))
                        Coba sesuaikan filter atau kata kunci pencarian Anda.
                        @else
                        Belum ada anggota yang ditampilkan di direktori.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'type', 'institution']))
                    <a href="{{ route('directory.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-full hover:shadow-lg transition-all">
                        Reset Filter
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
// Animate bars on load using IntersectionObserver
(function () {
    const animateBars = (panel) => {
        if (!panel) return;
        panel.querySelectorAll('.chart-bar').forEach(bar => {
            const target = bar.dataset.width || 0;
            requestAnimationFrame(() => {
                bar.style.transition = 'width 0.6s cubic-bezier(.4,0,.2,1)';
                bar.style.width = target + '%';
            });
        });
    };

    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                animateBars(e.target);
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('#mc-panel-institution, #mc-panel-province').forEach(el => {
        if (el) observer.observe(el);
    });
})();

function switchMemberChart(tab) {
    const panels  = { institution: document.getElementById('mc-panel-institution'), province: document.getElementById('mc-panel-province') };
    const tabs    = { institution: document.getElementById('mctab-institution'),    province: document.getElementById('mctab-province') };
    const active  = 'flex-1 py-1 px-2 rounded-md text-xs font-semibold transition-all bg-white text-blue-600 shadow-sm';
    const passive = 'flex-1 py-1 px-2 rounded-md text-xs font-semibold transition-all text-gray-500 hover:text-gray-700';

    Object.keys(panels).forEach(key => {
        if (!panels[key]) return;
        panels[key].classList.toggle('hidden', key !== tab);
        if (tabs[key]) tabs[key].className = key === tab ? active : passive;
    });

    // Animate bars when tab is shown
    if (panels[tab]) {
        panels[tab].querySelectorAll('.chart-bar').forEach(bar => {
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 0.6s cubic-bezier(.4,0,.2,1)';
                bar.style.width = (bar.dataset.width || 0) + '%';
            }, 30);
        });
    }
}
</script>
@endpush

@endsection
