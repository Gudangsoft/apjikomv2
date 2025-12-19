

<?php $__env->startSection('page-title', 'Kelola Kegiatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-2xl font-bold text-gray-900">Daftar Kegiatan</h3>
    <a href="<?php echo e(route('admin.events.create')); ?>" class="bg-[#00629B] text-white px-4 py-2 rounded hover:bg-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Kegiatan</span>
    </a>
</div>

<!-- Advanced Search & Filter -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h4 class="text-lg font-semibold text-gray-900 mb-4">🔍 Pencarian & Filter</h4>
    <form method="GET" action="<?php echo e(route('admin.events.index')); ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Kegiatan</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                    placeholder="Judul, lokasi, deskripsi..." 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = \App\Models\Category::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    <option value="">Semua Status</option>
                    <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                </select>
            </div>

            <!-- Featured -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Featured</label>
                <select name="featured" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    <option value="">Semua</option>
                    <option value="1" <?php echo e(request('featured') == '1' ? 'selected' : ''); ?>>Ya</option>
                    <option value="0" <?php echo e(request('featured') == '0' ? 'selected' : ''); ?>>Tidak</option>
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    <option value="latest" <?php echo e(request('sort', 'latest') == 'latest' ? 'selected' : ''); ?>>Terbaru</option>
                    <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Terlama</option>
                    <option value="event_date_asc" <?php echo e(request('sort') == 'event_date_asc' ? 'selected' : ''); ?>>Tanggal Event (Terdekat)</option>
                    <option value="event_date_desc" <?php echo e(request('sort') == 'event_date_desc' ? 'selected' : ''); ?>>Tanggal Event (Terjauh)</option>
                    <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Judul (A-Z)</option>
                </select>
            </div>

            <!-- Per Page -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                <select name="per_page" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00629B]">
                    <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                    <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                </select>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <?php echo e($events->firstItem() ?? 0); ?> - <?php echo e($events->lastItem() ?? 0); ?> dari <?php echo e($events->total()); ?> kegiatan
            </div>
            <div class="flex space-x-2">
                <?php if(request()->hasAny(['search', 'category', 'status', 'featured', 'date_from', 'date_to', 'sort'])): ?>
                    <a href="<?php echo e(route('admin.events.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Reset
                    </a>
                <?php endif; ?>
                <button type="submit" class="px-4 py-2 bg-[#00629B] text-white rounded-md hover:bg-[#003A5D] flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-6 py-4">
                    <?php if($event->image): ?>
                    <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" class="w-20 h-14 object-cover rounded">
                    <?php else: ?>
                    <div class="w-20 h-14 bg-gray-200 rounded flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900"><?php echo e(Str::limit($event->title, 50)); ?></div>
                    <div class="flex flex-wrap gap-1 mt-1">
                        <?php if($event->category): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            <?php echo e($event->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($event->event_type === 'online'): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            🌐 Online
                        </span>
                        <?php elseif($event->event_type === 'hybrid'): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                            🔄 Hybrid
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            📍 Offline
                        </span>
                        <?php endif; ?>
                        <?php if($event->has_registration): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                            ✓ Pendaftaran
                        </span>
                        <?php endif; ?>
                        <?php if($event->has_certificate): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            🏆 Sertifikat
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        <?php if($event->event_type === 'offline' || $event->event_type === 'hybrid'): ?>
                            📍 <?php echo e(Str::limit($event->location, 30)); ?>

                        <?php endif; ?>
                        <?php if($event->event_type === 'online' || $event->event_type === 'hybrid'): ?>
                            <?php if($event->event_type === 'hybrid'): ?><br><?php endif; ?>
                            💻 <?php echo e(Str::limit($event->online_platform, 30)); ?>

                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo e($event->event_date->format('d M Y')); ?>

                    <?php if($event->event_time): ?>
                        <br><span class="text-xs"><?php echo e(date('H:i', strtotime($event->event_time))); ?> WIB</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex flex-col space-y-1">
                        <?php if($event->is_published): ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Published
                        </span>
                        <?php else: ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            Draft
                        </span>
                        <?php endif; ?>
                        
                        <?php if($event->is_featured): ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            ⭐ Featured
                        </span>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="<?php echo e(route('admin.events.participants', $event)); ?>" class="text-purple-600 hover:text-purple-900 mr-3" title="Lihat Peserta">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-xs">(<?php echo e($event->registered_count); ?>)</span>
                    </a>
                    <a href="<?php echo e(route('events.show', $event->slug)); ?>" target="_blank" class="text-gray-600 hover:text-gray-900 mr-3">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="text-[#00629B] hover:text-[#003A5D] mr-3">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.events.destroy', $event)); ?>" class="inline" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada kegiatan</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-6">
    <?php echo e($events->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/events/index.blade.php ENDPATH**/ ?>