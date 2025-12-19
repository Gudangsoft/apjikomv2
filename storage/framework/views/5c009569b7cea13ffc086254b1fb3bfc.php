

<?php $__env->startSection('title', 'Berita'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<section class="bg-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Berita APJIKOM</h1>
        <p class="text-lg text-purple-100">Informasi terkini seputar informatika dan komputer</p>
    </div>
</section>

<!-- News List -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="news-card bg-white rounded overflow-hidden">
                        <?php if($article->image): ?>
                            <div class="h-48 overflow-hidden">
                                <img src="<?php echo e(asset('storage/' . $article->image)); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700"></div>
                        <?php endif; ?>
                        <div class="p-5">
                            <div class="flex items-center text-xs text-gray-500 mb-3">
                                <span class="bg-purple-50 text-purple-600 px-3 py-1 rounded-full font-medium mr-2">
                                    <?php echo e($article->category->name); ?>

                                </span>
                                <span><?php echo e($article->published_at->format('d M Y')); ?></span>
                            </div>
                            <h3 class="text-lg font-bold mb-2 text-gray-900 line-clamp-2">
                                <a href="<?php echo e(route('news.show', $article->slug)); ?>" class="hover:text-purple-600">
                                    <?php echo e($article->title); ?>

                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?php echo e(Str::limit($article->excerpt, 150)); ?></p>
                            <div class="flex items-center justify-between">
                                <a href="<?php echo e(route('news.show', $article->slug)); ?>" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                    Baca Selengkapnya →
                                </a>
                                <span class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <?php echo e($article->views); ?>

                                </span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-2 text-center py-12 text-gray-500">
                        Belum ada berita tersedia.
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if($news->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($news->links()); ?>

                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <aside class="w-full md:w-80">
                <!-- Categories -->
                <div class="bg-white rounded shadow-sm p-6 mb-6 border">
                    <h3 class="text-lg font-bold mb-4 text-gray-900">Kategori</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo e(route('news.index')); ?>" class="flex justify-between items-center text-sm text-gray-700 hover:text-purple-600 <?php echo e(!request('category') ? 'text-purple-600 font-medium' : ''); ?>">
                                <span>Semua</span>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded"><?php echo e($totalNews); ?></span>
                            </a>
                        </li>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('news.index', ['category' => $cat->slug])); ?>" 
                               class="flex justify-between items-center text-sm text-gray-700 hover:text-purple-600 <?php echo e(request('category') == $cat->slug ? 'text-purple-600 font-medium' : ''); ?>">
                                <span><?php echo e($cat->name); ?></span>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded"><?php echo e($cat->news_count); ?></span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                
                <!-- Latest News -->
                <div class="bg-white rounded shadow-sm p-6 border">
                    <h3 class="text-lg font-bold mb-4 text-gray-900">Berita Terbaru</h3>
                    <ul class="space-y-4">
                        <?php $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="pb-4 border-b last:border-0 last:pb-0">
                            <a href="<?php echo e(route('news.show', $latest->slug)); ?>" class="block hover:text-purple-600">
                                <h4 class="font-medium mb-1 text-sm"><?php echo e(Str::limit($latest->title, 60)); ?></h4>
                                <p class="text-xs text-gray-500"><?php echo e($latest->published_at->format('d M Y')); ?></p>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/news/index.blade.php ENDPATH**/ ?>