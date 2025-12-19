<!-- Registrations Tab Content -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <!-- Search & Quick Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="md:col-span-2">
            <input type="hidden" name="tab" value="registrations">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Cari nama, email, institusi..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>

        <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="flex gap-2">
            <input type="hidden" name="tab" value="registrations">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="reg_status" onchange="this.form.submit()" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Status</option>
                <option value="pending" <?php echo e(request('reg_status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('reg_status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="rejected" <?php echo e(request('reg_status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
            </select>
        </form>
    </div>

    <!-- Registrations Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama / Institusi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <?php if($registration->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $registration->photo)); ?>" class="w-10 h-10 rounded-full object-cover mr-3">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-bold"><?php echo e(substr($registration->full_name, 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="text-sm font-semibold text-gray-900"><?php echo e($registration->full_name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($registration->institution ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900"><?php echo e($registration->email); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($registration->phone ?? '-'); ?></div>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <?php if($registration->type == 'individual'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Individual</span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">Institutional</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <?php if($registration->status == 'pending'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                        <?php elseif($registration->status == 'approved'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Approved</span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-center text-sm text-gray-500">
                        <?php echo e($registration->created_at->format('d M Y')); ?>

                        <div class="text-xs text-gray-400"><?php echo e($registration->created_at->diffForHumans()); ?></div>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- View Detail -->
                            <a href="<?php echo e(route('admin.registrations.show', $registration)); ?>" 
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            <?php if($registration->status == 'pending'): ?>
                            <!-- Approve -->
                            <form action="<?php echo e(route('admin.registrations.update-status', $registration)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" 
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                        title="Approve"
                                        onclick="return confirm('Approve pendaftaran ini? Member baru akan dibuat.')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>

                            <!-- Reject -->
                            <form action="<?php echo e(route('admin.registrations.update-status', $registration)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Reject"
                                        onclick="return confirm('Reject pendaftaran ini?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                            <?php endif; ?>

                            <!-- Delete -->
                            <form action="<?php echo e(route('admin.registrations.destroy', $registration)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus pendaftaran ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium mb-1">Tidak ada pendaftaran</p>
                        <p class="text-sm">Belum ada pendaftaran baru atau data tidak sesuai filter</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($registrations->hasPages()): ?>
    <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
        <div class="text-sm text-gray-700">
            Menampilkan <span class="font-semibold"><?php echo e($registrations->firstItem()); ?></span>
            sampai <span class="font-semibold"><?php echo e($registrations->lastItem()); ?></span>
            dari <span class="font-semibold"><?php echo e($registrations->total()); ?></span> pendaftaran
        </div>
        <div>
            <?php echo e($registrations->appends(['tab' => 'registrations'])->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/members/partials/registrations-tab.blade.php ENDPATH**/ ?>