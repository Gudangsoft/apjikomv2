

<?php $__env->startSection('title', 'Event Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Event Saya</h1>
            <p class="text-gray-600 mt-1">Daftar event yang Anda ikuti</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="flex space-x-4 border-b">
            <a href="?status=all" class="pb-2 px-1 <?php echo e((!request('status') || request('status') == 'all') ? 'border-b-2 border-purple-600 text-purple-600 font-semibold' : 'text-gray-500 hover:text-gray-700'); ?>">
                Semua
            </a>
            <a href="?status=upcoming" class="pb-2 px-1 <?php echo e(request('status') == 'upcoming' ? 'border-b-2 border-purple-600 text-purple-600 font-semibold' : 'text-gray-500 hover:text-gray-700'); ?>">
                Akan Datang
            </a>
            <a href="?status=past" class="pb-2 px-1 <?php echo e(request('status') == 'past' ? 'border-b-2 border-purple-600 text-purple-600 font-semibold' : 'text-gray-500 hover:text-gray-700'); ?>">
                Selesai
            </a>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $event = $registration->event;
                $isPast = $event->event_date < now();
            ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 <?php echo e($registration->isCancelled() ? 'opacity-60' : ''); ?>">
                <?php if($event->image): ?>
                    <div class="h-48 overflow-hidden relative">
                        <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" 
                             class="w-full h-full object-cover">
                        <?php if($registration->isCancelled()): ?>
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold">DIBATALKAN</span>
                            </div>
                        <?php elseif($isPast): ?>
                            <div class="absolute top-2 right-2 flex gap-2">
                                <span class="bg-gray-800/80 text-white px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                                <?php if($event->has_certificate): ?>
                                    <?php if($registration->canDownloadCertificate()): ?>
                                        <?php if($registration->hasCertificate()): ?>
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Sertifikat Tersedia
                                        </span>
                                        <?php else: ?>
                                        <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Belum Tersedia
                                        </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Sertifikat
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="absolute top-2 right-2">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold animate-pulse">Terdaftar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                <?php endif; ?>

                <div class="p-5">
                    <?php if($event->category): ?>
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full mb-3">
                            <?php echo e($event->category->name); ?>

                        </span>
                    <?php endif; ?>

                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                        <?php echo e($event->title); ?>

                    </h3>

                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span><?php echo e($event->event_date->format('d M Y')); ?></span>
                        </div>
                        
                        <?php if($event->event_time): ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?php echo e(date('H:i', strtotime($event->event_time))); ?> WIB</span>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="line-clamp-1"><?php echo e($event->location); ?></span>
                        </div>

                        <div class="flex items-center text-xs text-gray-500 mt-2 pt-2 border-t">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Terdaftar <?php echo e($registration->registered_at->diffForHumans()); ?>

                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="<?php echo e(route('events.show', $event->slug)); ?>" 
                           class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-center rounded-lg font-medium text-sm transition">
                            Lihat Detail
                        </a>
                        
                        <?php if($registration->canDownloadCertificate()): ?>
                            <?php if($registration->hasCertificate()): ?>
                            <a href="<?php echo e(route('member.certificates.download', $registration)); ?>" 
                               class="flex-shrink-0 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-sm transition flex items-center gap-1"
                               title="Download Sertifikat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="hidden sm:inline">Sertifikat</span>
                            </a>
                            <?php else: ?>
                            <div class="relative group">
                                <span class="flex-shrink-0 px-4 py-2 bg-gray-400 text-white rounded-lg font-medium text-sm flex items-center gap-1 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Sertifikat</span>
                                </span>
                                <div class="hidden group-hover:block absolute bottom-full right-0 mb-2 w-64 bg-gray-900 text-white text-xs rounded-lg p-3 shadow-lg z-10">
                                    <div class="font-semibold mb-1">📋 Sertifikat Belum Tersedia</div>
                                    <div class="text-gray-300">Sertifikat belum digenerate oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.</div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if(!$registration->isCancelled() && !$isPast): ?>
                            <form action="<?php echo e(route('member.events.cancel', $event)); ?>" method="POST" class="flex-shrink-0">
                                <?php echo csrf_field(); ?>
                                <button type="submit" onclick="return confirm('Batalkan pendaftaran?')"
                                        class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium text-sm transition">
                                    Batal
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Event</h3>
                <p class="text-gray-600 mb-4">Anda belum mendaftar event apapun</p>
                <a href="<?php echo e(route('events.index')); ?>" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari Event
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($registrations->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($registrations->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/member/events/my-events.blade.php ENDPATH**/ ?>