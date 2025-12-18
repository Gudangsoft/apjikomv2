

<?php $__env->startSection('title', 'Agenda Kegiatan'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<section class="bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 text-white py-16 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay opacity-10 blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center mb-4">
            <div class="text-5xl mr-4">📅</div>
            <div>
                <h1 class="text-4xl font-bold mb-2">Agenda Kegiatan</h1>
                <p class="text-lg text-purple-100">Ikuti berbagai kegiatan dan acara APJIKOM</p>
            </div>
        </div>
        
        <!-- Category Filter -->
        <?php if($categories->count() > 0): ?>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="<?php echo e(route('events.index')); ?>" 
               class="px-5 py-2 rounded-full transition-all <?php echo e(!request('category') ? 'bg-white text-purple-700 shadow-lg' : 'bg-white/20 text-white hover:bg-white/30'); ?>">
                Semua Kategori
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('events.index', ['category' => $category->id])); ?>" 
               class="px-5 py-2 rounded-full transition-all <?php echo e(request('category') == $category->id ? 'bg-white text-purple-700 shadow-lg' : 'bg-white/20 text-white hover:bg-white/30'); ?>">
                <?php echo e($category->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-16 bg-gradient-to-br from-purple-50 via-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900">
                <span class="text-purple-600"><?php echo e($upcomingEvents->total()); ?></span> Kegiatan Mendatang
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                <!-- Event Image/Gradient -->
                <?php if($event->image): ?>
                <div class="h-48 overflow-hidden relative">
                    <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    
                    <!-- Date Badge on Image -->
                    <div class="absolute top-4 left-4 bg-white rounded-xl shadow-lg p-3 text-center">
                        <div class="text-3xl font-bold text-purple-600"><?php echo e($event->event_date->format('d')); ?></div>
                        <div class="text-xs font-semibold text-gray-600 uppercase"><?php echo e($event->event_date->format('M')); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($event->event_date->format('Y')); ?></div>
                    </div>
                    
                    <?php if($event->category): ?>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center bg-purple-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                            <?php echo e($event->category->name); ?>

                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    
                    <!-- Date Badge -->
                    <div class="absolute top-4 left-4 bg-white rounded-xl shadow-lg p-3 text-center">
                        <div class="text-3xl font-bold text-purple-600"><?php echo e($event->event_date->format('d')); ?></div>
                        <div class="text-xs font-semibold text-gray-600 uppercase"><?php echo e($event->event_date->format('M')); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($event->event_date->format('Y')); ?></div>
                    </div>
                    
                    <?php if($event->category): ?>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center bg-white text-purple-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                            <?php echo e($event->category->name); ?>

                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-900 line-clamp-2 group-hover:text-purple-600 transition min-h-[3.5rem]">
                        <a href="<?php echo e(route('events.show', $event->slug)); ?>">
                            <?php echo e($event->title); ?>

                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 text-sm line-clamp-3 min-h-[4.5rem]"><?php echo e(Str::limit($event->description, 120)); ?></p>
                    
                    <!-- Event Info -->
                    <div class="space-y-2 mb-5">
                        <?php if($event->event_time): ?>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium"><?php echo e(date('H:i', strtotime($event->event_time))); ?> WIB</span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium line-clamp-1"><?php echo e($event->location ?? 'TBA'); ?></span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('events.show', $event->slug)); ?>" 
                           class="flex-1 text-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-lg transition-all font-semibold text-sm group-hover:shadow-lg">
                            Lihat Detail →
                        </a>
                        
                        <?php if($event->registration_link): ?>
                        <a href="<?php echo e($event->registration_link); ?>" target="_blank"
                           class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-lg transition-all font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum Ada Kegiatan</h3>
                <p class="text-gray-500">Nantikan update kegiatan menarik dari APJIKOM</p>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($upcomingEvents->hasPages()): ?>
        <div class="mt-12">
            <div class="flex justify-center">
                <?php echo e($upcomingEvents->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Past Events -->
<?php if($pastEvents->count() > 0): ?>
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-gray-900">Kegiatan Sebelumnya</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php $__currentLoopData = $pastEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('events.show', $event->slug)); ?>" class="group">
                <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200 hover:border-purple-300 transition-all hover:shadow-lg">
                    <?php if($event->image): ?>
                    <div class="aspect-square overflow-hidden">
                        <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 opacity-70">
                    </div>
                    <?php else: ?>
                    <div class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300"></div>
                    <?php endif; ?>
                    <div class="p-3">
                        <h3 class="font-semibold text-xs mb-1 line-clamp-2 group-hover:text-purple-600 transition">
                            <?php echo e($event->title); ?>

                        </h3>
                        <p class="text-xs text-gray-500"><?php echo e($event->event_date->format('d M Y')); ?></p>
                    </div>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/events/index.blade.php ENDPATH**/ ?>