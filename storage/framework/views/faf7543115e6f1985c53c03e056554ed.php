<!-- Dynamic Mobile Menu Component -->
<?php if($globalMenus && $globalMenus->count() > 0): ?>
    <?php $__currentLoopData = $globalMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($menu->type == 'dropdown' && $menu->children->count() > 0): ?>
            <!-- Dropdown Menu for Mobile -->
            <div class="border-b border-gray-200">
                <button onclick="toggleMobileSubmenu('mobile-menu-<?php echo e($menu->id); ?>')" 
                        class="w-full flex items-center justify-between py-3 text-sm text-gray-700 hover:text-purple-600">
                    <span>
                        <?php if($menu->icon): ?>
                            <i class="<?php echo e($menu->icon); ?> mr-2"></i>
                        <?php endif; ?>
                        <?php echo e($menu->title); ?>

                    </span>
                    <svg class="w-4 h-4 transition-transform" id="mobile-menu-<?php echo e($menu->id); ?>-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Level 1 Submenu -->
                <div id="mobile-menu-<?php echo e($menu->id); ?>" class="hidden pl-4 pb-2">
                    <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($childMenu->type == 'dropdown' && $childMenu->children->count() > 0): ?>
                            <!-- Level 2 with children -->
                            <div class="border-l border-gray-300 ml-2">
                                <button onclick="toggleMobileSubmenu('mobile-menu-<?php echo e($childMenu->id); ?>')" 
                                        class="w-full flex items-center justify-between py-2 pl-3 text-sm text-gray-600 hover:text-purple-600">
                                    <span>
                                        <?php if($childMenu->icon): ?>
                                            <i class="<?php echo e($childMenu->icon); ?> mr-2"></i>
                                        <?php endif; ?>
                                        <?php echo e($childMenu->title); ?>

                                    </span>
                                    <svg class="w-4 h-4 transition-transform" id="mobile-menu-<?php echo e($childMenu->id); ?>-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Level 2 Submenu -->
                                <div id="mobile-menu-<?php echo e($childMenu->id); ?>" class="hidden pl-4">
                                    <?php $__currentLoopData = $childMenu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grandChildMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($grandChildMenu->type == 'page' && $grandChildMenu->page ? route('page.show', $grandChildMenu->page->slug) : ($grandChildMenu->url ?? '#')); ?>" 
                                           target="<?php echo e($grandChildMenu->target); ?>"
                                           class="block py-2 pl-3 text-sm text-gray-600 hover:text-purple-600 border-l border-gray-300 ml-2">
                                            <?php if($grandChildMenu->icon): ?>
                                                <i class="<?php echo e($grandChildMenu->icon); ?> mr-2"></i>
                                            <?php endif; ?>
                                            <?php echo e($grandChildMenu->title); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Level 2 without children -->
                            <a href="<?php echo e($childMenu->type == 'page' && $childMenu->page ? route('page.show', $childMenu->page->slug) : ($childMenu->url ?? '#')); ?>" 
                               target="<?php echo e($childMenu->target); ?>"
                               class="block py-2 pl-3 text-sm text-gray-600 hover:text-purple-600 border-l border-gray-300 ml-2">
                                <?php if($childMenu->icon): ?>
                                    <i class="<?php echo e($childMenu->icon); ?> mr-2"></i>
                                <?php endif; ?>
                                <?php echo e($childMenu->title); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Simple Link for Mobile -->
            <a href="<?php echo e($menu->type == 'page' && $menu->page ? route('page.show', $menu->page->slug) : ($menu->url ?? '#')); ?>" 
               target="<?php echo e($menu->target); ?>"
               class="block py-3 text-sm text-gray-700 hover:text-purple-600 border-b border-gray-200">
                <?php if($menu->icon): ?>
                    <i class="<?php echo e($menu->icon); ?> mr-2"></i>
                <?php endif; ?>
                <?php echo e($menu->title); ?>

            </a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/components/dynamic-menu-mobile.blade.php ENDPATH**/ ?>