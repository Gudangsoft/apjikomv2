

<?php $__env->startSection('title', 'Kelola Media Sosial'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header dengan Gradient & Breadcrumbs -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm mb-2" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center text-purple-100">
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-white transition-colors">Dashboard</a>
                            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </li>
                        <li class="flex items-center text-white font-semibold">
                            <span>Media Sosial</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Kelola Media Sosial
                </h1>
                <p class="text-purple-100 mt-1">Atur tautan media sosial yang ditampilkan di website</p>
            </div>
            <a href="<?php echo e(route('admin.social-media.create')); ?>" class="bg-white text-purple-700 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 flex items-center space-x-2 hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Media Sosial</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-800 font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if($socialMedia->isEmpty()): ?>
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Media Sosial</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan akun media sosial organisasi Anda</p>
            <a href="<?php echo e(route('admin.social-media.create')); ?>" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Media Sosial Pertama
            </a>
        </div>
    <?php else: ?>
        <!-- Info Box: Drag & Drop -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-800 font-medium">Tips: Atur Urutan Tampilan</p>
                    <p class="text-blue-700 text-sm mt-1">Drag & drop icon <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg> untuk mengubah urutan tampilan media sosial di website</p>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Media Sosial</h3>
                            <p class="text-sm text-gray-600">Total: <?php echo e($socialMedia->count()); ?> platform</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg border border-gray-200">
                        Aktif: <span class="font-bold text-green-600"><?php echo e($socialMedia->where('is_active', true)->count()); ?></span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-20">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                    <span>Order</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Icon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Platform</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">URL & Note</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable" class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $socialMedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-id="<?php echo e($item->id); ?>" class="hover:bg-gray-50 transition-colors cursor-move group">
                                <!-- Order & Drag Handle -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="handle cursor-move text-gray-400 group-hover:text-purple-600 transition-colors">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-lg font-bold text-gray-600"><?php echo e($item->order); ?></span>
                                    </div>
                                </td>

                                <!-- Icon -->
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <?php if($item->icon): ?>
                                            <div class="w-14 h-14 rounded-xl border-2 border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                                <img src="<?php echo e(asset('storage/' . $item->icon)); ?>" 
                                                     alt="<?php echo e($item->name); ?>" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                        <?php elseif($item->icon_class): ?>
                                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                                <i class="<?php echo e($item->icon_class); ?> text-3xl text-purple-700"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Platform Name -->
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-800 text-lg"><?php echo e($item->name); ?></div>
                                </td>

                                <!-- URL & Note -->
                                <td class="px-6 py-5">
                                    <div class="space-y-2">
                                        <a href="<?php echo e($item->url); ?>" target="_blank" class="flex items-center space-x-2 text-purple-600 hover:text-purple-800 font-medium text-sm group/link">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            <span class="group-hover/link:underline"><?php echo e(Str::limit($item->url, 45)); ?></span>
                                        </a>
                                        <?php if($item->note): ?>
                                            <div class="flex items-start space-x-2 text-gray-600 text-sm">
                                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                <span><?php echo e($item->note); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-sm italic">Tidak ada catatan</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <?php if($item->is_active): ?>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Nonaktif
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="<?php echo e(route('admin.social-media.edit', $item)); ?>" 
                                           class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                           title="Edit">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.social-media.destroy', $item)); ?>" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus <?php echo e($item->name); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                                    title="Hapus">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Script untuk Sortable -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        <?php if(!$socialMedia->isEmpty()): ?>
        // Sortable untuk drag & drop reorder
        const sortable = new Sortable(document.getElementById('sortable'), {
            handle: '.handle',
            animation: 200,
            ghostClass: 'bg-purple-100',
            dragClass: 'opacity-50',
            onStart: function(evt) {
                evt.item.classList.add('shadow-2xl', 'scale-105');
            },
            onEnd: function(evt) {
                evt.item.classList.remove('shadow-2xl', 'scale-105');
                
                // Get all rows and their IDs
                const rows = document.querySelectorAll('#sortable tr');
                const orders = {};
                
                rows.forEach((row, index) => {
                    orders[row.dataset.id] = index + 1;
                });
                
                // Send AJAX request to update order
                fetch('<?php echo e(route('admin.social-media.update-order')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ orders: orders })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Show success notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                        notification.innerHTML = `
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Urutan berhasil diperbarui!</span>
                            </div>
                        `;
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.remove();
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memperbarui urutan. Silakan coba lagi.');
                    location.reload();
                });
            }
        });
        <?php endif; ?>

        // Auto hide success message
        setTimeout(function() {
            const successAlert = document.querySelector('.animate-fade-in');
            if(successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/social-media/index.blade.php ENDPATH**/ ?>