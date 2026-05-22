@extends('layouts.admin')

@section('page-title', 'Audit Trail')

@section('content')
<div class="max-w-7xl">

    @if(session('success'))
    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm mb-5 p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama user atau deskripsi..."
                       class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe</label>
                <select name="type" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">Semua Tipe</option>
                    @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="w-36">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
            <div class="w-36">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search','type','date_from','date_to']))
                <a href="{{ route('admin.activity-logs.index') }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        @php
            $allTypes = \App\Models\ActivityLog::select('type')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('type')
                ->orderByDesc('count')
                ->limit(4)
                ->get();
            $typeColors = ['auth'=>'blue','registration'=>'green','post'=>'purple','approve_registration'=>'emerald'];
        @endphp
        @foreach($allTypes as $t)
        @php $color = $typeColors[$t->type] ?? 'gray'; @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-{{ $color }}-500">
            <p class="text-2xl font-bold text-gray-900">{{ number_format($t->count) }}</p>
            <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ str_replace('_', ' ', $t->type) }}</p>
        </div>
        @endforeach
    </div>

    <!-- Log Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">
                Log Aktivitas
                <span class="ml-2 text-sm font-normal text-gray-500">({{ $logs->total() }} entri)</span>
            </h2>
            <!-- Hapus log lama -->
            <form action="{{ route('admin.activity-logs.clear') }}" method="POST"
                  onsubmit="return confirm('Hapus log yang lebih dari berapa hari?')">
                @csrf
                <div class="flex items-center gap-2">
                    <select name="older_than_days"
                            class="text-xs border border-gray-300 rounded px-2 py-1.5 focus:ring-1 focus:ring-purple-500 focus:outline-none">
                        <option value="30">Lebih dari 30 hari</option>
                        <option value="60">Lebih dari 60 hari</option>
                        <option value="90" selected>Lebih dari 90 hari</option>
                        <option value="180">Lebih dari 180 hari</option>
                        <option value="365">Lebih dari 1 tahun</option>
                    </select>
                    <button type="submit"
                            class="text-xs px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded transition-colors">
                        Hapus Log Lama
                    </button>
                </div>
            </form>
        </div>

        @if($logs->isEmpty())
        <div class="py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm">Tidak ada log yang cocok dengan filter</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Waktu</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Tipe</th>
                        <th class="px-5 py-3 text-left">Aksi</th>
                        <th class="px-5 py-3 text-left">Deskripsi</th>
                        <th class="px-3 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($logs as $log)
                    @php
                        $typeBadge = [
                            'auth'                 => 'bg-blue-100 text-blue-700',
                            'registration'         => 'bg-green-100 text-green-700',
                            'post'                 => 'bg-purple-100 text-purple-700',
                            'approve_registration' => 'bg-emerald-100 text-emerald-700',
                        ][$log->type] ?? 'bg-gray-100 text-gray-700';

                        $actionBadge = [
                            'login'    => 'bg-blue-50 text-blue-600',
                            'logout'   => 'bg-slate-100 text-slate-600',
                            'created'  => 'bg-green-50 text-green-600',
                            'updated'  => 'bg-yellow-50 text-yellow-700',
                            'deleted'  => 'bg-red-50 text-red-600',
                            'approved' => 'bg-emerald-50 text-emerald-600',
                            'rejected' => 'bg-red-50 text-red-600',
                        ][$log->action] ?? 'bg-gray-50 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3 text-gray-500 whitespace-nowrap">
                            <div>{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-5 py-3">
                            @if($log->user)
                            <div class="font-medium text-gray-800">{{ $log->user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $log->user->email }}</div>
                            @else
                            <span class="text-gray-400 italic">System</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $typeBadge }}">
                                {{ str_replace('_', ' ', $log->type) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded {{ $actionBadge }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-600 max-w-xs">
                            <span class="line-clamp-2">{{ $log->description ?? '—' }}</span>
                        </td>
                        <td class="px-3 py-3">
                            <form action="{{ route('admin.activity-logs.destroy', $log) }}" method="POST"
                                  onsubmit="return confirm('Hapus log ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-5 py-4 border-t bg-gray-50">
            {{ $logs->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
