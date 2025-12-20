<!-- Dynamic Menu Component -->
<?php if($globalMenus && $globalMenus->count() > 0): ?>
    <?php $__currentLoopData = $globalMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($menu->type == 'dropdown' && $menu->children->count() > 0): ?>
            <!-- Dropdown Menu -->
            <div class="relative group">
                <button class="text-gray-700 hover:text-purple-600 font-medium text-sm flex items-center">
                    <?php if($menu->icon): ?>
                        <i class="<?php echo e($menu->icon); ?> mr-1"></i>
                    <?php endif; ?>
                    <?php echo e($menu->title); ?>

                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Level 1 Dropdown -->
                <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2">
                        <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($childMenu->type == 'dropdown' && $childMenu->children->count() > 0): ?>
                                <!-- Level 2 with children -->
                                <div class="relative group/sub">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 flex items-center justify-between">
                                        <span>
                                            <?php if($childMenu->icon): ?>
                                                <i class="<?php echo e($childMenu->icon); ?> mr-2"></i>
                                            <?php endif; ?>
                                            <?php echo e($childMenu->title); ?>

                                        </span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Level 2 Dropdown -->
                                    <div class="absolute left-full top-0 mt-0 w-56 bg-white rounded-md shadow-lg opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200">
                                        <div class="py-2">
                                            <?php $__currentLoopData = $childMenu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grandChildMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e($grandChildMenu->type == 'page' && $grandChildMenu->page ? route('page.show', $grandChildMenu->page->slug) : ($grandChildMenu->url ?? '#')); ?>" 
                                                   target="<?php echo e($grandChildMenu->target); ?>"
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                                    <?php if($grandChildMenu->icon): ?>
                                                        <i class="<?php echo e($grandChildMenu->icon); ?> mr-2"></i>
                                                    <?php endif; ?>
                                                    <?php echo e($grandChildMenu->title); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Level 2 without children -->
                                <a href="<?php echo e($childMenu->type == 'page' && $childMenu->page ? route('page.show', $childMenu->page->slug) : ($childMenu->url ?? '#')); ?>" 
                                   target="<?php echo e($childMenu->target); ?>"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                    <?php if($childMenu->icon): ?>
                                        <i class="<?php echo e($childMenu->icon); ?> mr-2"></i>
                                    <?php endif; ?>
                                    <?php echo e($childMenu->title); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Simple Link -->
            <a href="<?php echo e($menu->type == 'page' && $menu->page ? route('page.show', $menu->page->slug) : ($menu->url ?? '#')); ?>" 
               target="<?php echo e($menu->target); ?>"
               class="text-gray-700 hover:text-purple-600 font-medium text-sm <?php echo e(request()->is(ltrim($menu->url ?? '', '/')) ? 'text-purple-600' : ''); ?>">
                <?php if($menu->icon): ?>
                    <i class="<?php echo e($menu->icon); ?> mr-1"></i>
                <?php endif; ?>
                <?php echo e($menu->title); ?>

            </a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/wwwroot/apjikomv2/resources/views/components/dynamic-menu.blade.php ENDPATH**/ ?>