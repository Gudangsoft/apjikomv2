

<?php $__env->startSection('title', 'Template Kartu Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Template Kartu Anggota</h1>
            <p class="text-gray-600 mt-1">Kelola template background untuk generate kartu anggota otomatis</p>
        </div>
        <a href="<?php echo e(route('admin.card-templates.create')); ?>" 
           class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Template
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden <?php echo e($template->is_active ? 'ring-4 ring-green-500' : ''); ?>">
            <div class="relative">
                <img src="<?php echo e(asset('storage/' . $template->template_image)); ?>" 
                     alt="<?php echo e($template->name); ?>" 
                     class="w-full h-64 object-cover">
                
                <?php if($template->is_active): ?>
                <div class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                    ✓ Aktif
                </div>
                <?php endif; ?>
            </div>
            
            <div class="p-4">
                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($template->name); ?></h3>
                
                <?php if($template->description): ?>
                <p class="text-sm text-gray-600 mb-4"><?php echo e($template->description); ?></p>
                <?php endif; ?>
                
                <div class="text-xs text-gray-500 mb-4">
                    <p>Dibuat: <?php echo e($template->created_at->format('d M Y')); ?></p>
                </div>
                
                <div class="flex space-x-2">
                    <?php if(!$template->is_active): ?>
                    <form method="POST" action="<?php echo e(route('admin.card-templates.activate', $template)); ?>" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                                class="w-full px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm">
                            Aktifkan
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('admin.card-templates.edit', $template)); ?>" 
                       class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                        Edit
                    </a>
                    
                    <?php if(!$template->is_active): ?>
                    <form method="POST" action="<?php echo e(route('admin.card-templates.destroy', $template)); ?>" 
                          onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                            Hapus
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-yellow-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="text-gray-700 font-semibold mb-2">Belum ada template</p>
            <p class="text-sm text-gray-600 mb-4">Upload template background kartu anggota untuk mulai generate kartu otomatis</p>
            <a href="<?php echo e(route('admin.card-templates.create')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Template
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">📖 Cara Menggunakan:</h3>
        <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800">
            <li>Upload gambar template/background kartu anggota (format PNG/JPG)</li>
            <li>Pastikan template memiliki area kosong untuk teks data member</li>
            <li>Aktifkan salah satu template yang akan digunakan</li>
            <li>Sistem akan otomatis generate kartu dengan data member di atas template</li>
            <li>Data yang ditampilkan: Nomor Anggota, Nama, PT, Kontak, Alamat, Masa Berlaku, Tanggal Disahkan</li>
        </ol>
        
        <div class="mt-4 p-4 bg-white rounded border border-blue-200">
            <p class="font-semibold text-blue-900 mb-2">💡 Tips Desain Template:</p>
            <ul class="space-y-1 text-sm text-blue-800">
                <li>• Ukuran rekomendasi: 1200x800px atau 1500x1000px</li>
                <li>• Sisakan area kosong di bagian tengah/kiri untuk teks</li>
                <li>• Gunakan background terang agar teks mudah dibaca</li>
                <li>• Tambahkan logo APJIKOM di template untuk hasil terbaik</li>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/member-card-templates/index.blade.php ENDPATH**/ ?>