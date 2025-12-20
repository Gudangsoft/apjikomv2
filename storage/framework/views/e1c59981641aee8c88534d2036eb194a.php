<div class="mb-8 <?php echo e($align === 'center' ? 'text-center' : ''); ?>">
    <?php if($title): ?>
    <h2 class="text-3xl font-bold mb-3 <?php echo e($darkMode ? 'text-white' : 'text-gray-900'); ?>">
        <?php echo e($title); ?>

    </h2>
    <?php endif; ?>
    
    <?php if($subtitle): ?>
    <p class="text-lg <?php echo e($darkMode ? 'text-gray-300' : 'text-gray-600'); ?>">
        <?php echo e($subtitle); ?>

    </p>
    <?php endif; ?>
</div>
<?php /**PATH /home/wwwroot/apjikomv2/resources/views/components/section-heading.blade.php ENDPATH**/ ?>