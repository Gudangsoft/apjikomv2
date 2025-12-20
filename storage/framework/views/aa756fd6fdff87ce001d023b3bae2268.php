<!-- Members Tab Content -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <!-- Search & Quick Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="md:col-span-2">
            <input type="hidden" name="tab" value="members">
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
            <input type="hidden" name="tab" value="members">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="status" onchange="this.form.submit()" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Status</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
            </select>
        </form>

        <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="flex gap-2">
            <input type="hidden" name="tab" value="members">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="verified" onchange="this.form.submit()" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Verifikasi</option>
                <option value="1" <?php echo e(request('verified') == '1' ? 'selected' : ''); ?>>Terverifikasi</option>
                <option value="0" <?php echo e(request('verified') == '0' ? 'selected' : ''); ?>>Belum Verifikasi</option>
            </select>
        </form>
    </div>

    <!-- Members Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama / Institusi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Verifikasi</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Kartu</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <?php if($member->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $member->photo)); ?>" class="w-10 h-10 rounded-full object-cover mr-3">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-bold"><?php echo e(substr($member->user->name, 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="text-sm font-semibold text-gray-900"><?php echo e($member->user->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($member->institution_name ?? 'N/A'); ?></div>
                                <?php if($member->member_number): ?>
                                    <div class="text-xs text-purple-600 font-mono"><?php echo e($member->member_number); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900"><?php echo e($member->user->email); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($member->phone ?? '-'); ?></div>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <?php if($member->status == 'active'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                        <?php elseif($member->status == 'inactive'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">Inactive</span>
                        <?php elseif($member->status == 'pending'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700"><?php echo e(ucfirst($member->status)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <?php if($member->is_verified): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Unverified</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <?php if($member->member_card): ?>
                            <span class="text-green-600" title="Kartu tersedia">
                                <svg class="w-6 h-6 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        <?php else: ?>
                            <?php if($member->card_requested): ?>
                                <span class="text-orange-500 animate-pulse" title="Diminta member">
                                    <svg class="w-6 h-6 inline" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-300" title="Belum ada">
                                    <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?php echo e(route('admin.members.show', $member)); ?>" 
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <form action="<?php echo e(route('admin.members.destroy', $member)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus member ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-lg font-medium mb-1">Tidak ada data member</p>
                        <p class="text-sm">Belum ada member yang terdaftar atau data tidak sesuai filter</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($members->hasPages()): ?>
    <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
        <div class="text-sm text-gray-700">
            Menampilkan <span class="font-semibold"><?php echo e($members->firstItem()); ?></span>
            sampai <span class="font-semibold"><?php echo e($members->lastItem()); ?></span>
            dari <span class="font-semibold"><?php echo e($members->total()); ?></span> member
        </div>
        <div>
            <?php echo e($members->appends(['tab' => 'members'])->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/wwwroot/apjikomv2/resources/views/admin/members/partials/members-tab.blade.php ENDPATH**/ ?>