

<?php $__env->startSection('page-title', 'Peserta - ' . $event->title); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.events.index')); ?>" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Daftar Kegiatan</span>
    </a>
</div>

<!-- Event Info Card -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-start gap-6">
        <?php if($event->image): ?>
        <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" 
             class="w-32 h-24 object-cover rounded-lg shadow">
        <?php endif; ?>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($event->title); ?></h2>
            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php echo e($event->event_date->format('d M Y')); ?>

                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <?php echo e($event->location ?? $event->online_platform); ?>

                </div>
                <?php if($event->is_paid): ?>
                <div class="flex items-center gap-1 text-blue-600 font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Rp <?php echo e(number_format($event->registration_fee, 0, ',', '.')); ?>

                </div>
                <?php else: ?>
                <span class="text-green-600 font-semibold">🆓 Gratis</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-right">
            <div class="text-3xl font-bold text-[#00629B]"><?php echo e($registrations->total()); ?></div>
            <div class="text-sm text-gray-600">Total Peserta</div>
            <?php if($event->participant_quota): ?>
            <div class="text-xs text-gray-500 mt-1">
                Kuota: <?php echo e($event->participant_quota); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if($event->is_paid): ?>
    <div class="mt-4 pt-4 border-t border-gray-200">
        <h4 class="font-semibold text-gray-700 mb-2">Informasi Pembayaran:</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Bank:</span>
                <span class="font-medium"><?php echo e($event->bank_name); ?></span>
            </div>
            <div>
                <span class="text-gray-500">No. Rekening:</span>
                <span class="font-medium"><?php echo e($event->bank_account); ?></span>
            </div>
            <div>
                <span class="text-gray-500">Atas Nama:</span>
                <span class="font-medium"><?php echo e($event->bank_account_name); ?></span>
            </div>
            <div>
                <span class="text-gray-500">Kontak:</span>
                <span class="font-medium"><?php echo e($event->payment_contact); ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">
            <?php echo e($registrations->where('status', 'registered')->count()); ?>

        </div>
        <div class="text-sm text-gray-600">Terdaftar</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-green-600">
            <?php echo e($registrations->where('status', 'attended')->count()); ?>

        </div>
        <div class="text-sm text-gray-600">Hadir</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-red-600">
            <?php echo e($registrations->where('status', 'cancelled')->count()); ?>

        </div>
        <div class="text-sm text-gray-600">Batal</div>
    </div>
    <?php if($event->is_paid): ?>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-yellow-600">
            <?php echo e($registrations->where('payment_status', 'pending')->count()); ?>

        </div>
        <div class="text-sm text-gray-600">Belum Bayar</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-emerald-600">
            <?php echo e($registrations->where('payment_status', 'verified')->count()); ?>

        </div>
        <div class="text-sm text-gray-600">Terverifikasi</div>
    </div>
    <?php endif; ?>
</div>

<!-- Participants Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Daftar Peserta</h3>
        <?php if($event->has_certificate && $registrations->count() > 0): ?>
        <form action="<?php echo e(route('admin.certificates.bulk-generate')); ?>" method="POST" class="inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
            <button type="submit" 
                    onclick="return confirm('Generate sertifikat untuk semua peserta yang memenuhi syarat?')"
                    class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                🎓 Generate Semua Sertifikat
            </button>
        </form>
        <?php endif; ?>
    </div>
    
    <?php if($registrations->count() > 0): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peserta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                    <?php if($event->is_paid): ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                    <?php endif; ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <?php if($event->has_certificate): ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sertifikat</th>
                    <?php endif; ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e(($registrations->currentPage() - 1) * $registrations->perPage() + $index + 1); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo e($registration->user->name); ?>

                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo e($registration->user->member->institution_name ?? '-'); ?>

                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo e($registration->user->email); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e($registration->user->member->phone ?? '-'); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($registration->created_at->format('d M Y H:i')); ?>

                    </td>
                    <?php if($event->is_paid): ?>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($registration->payment_proof): ?>
                            <a href="<?php echo e(asset('storage/' . $registration->payment_proof)); ?>" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 underline text-sm">
                                📎 Lihat Bukti
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400 text-sm">Belum upload</span>
                        <?php endif; ?>
                        
                        <?php if($registration->payment_status === 'pending'): ?>
                            <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                        <?php elseif($registration->payment_status === 'paid'): ?>
                            <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Sudah Bayar</span>
                        <?php elseif($registration->payment_status === 'verified'): ?>
                            <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">✓ Verified</span>
                        <?php elseif($registration->payment_status === 'rejected'): ?>
                            <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">✗ Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($registration->status === 'registered'): ?>
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Terdaftar</span>
                        <?php elseif($registration->status === 'attended'): ?>
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Hadir</span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Batal</span>
                        <?php endif; ?>
                    </td>
                    <?php if($event->has_certificate): ?>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($registration->hasCertificate()): ?>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">✓ Sudah</span>
                                <form action="<?php echo e(route('admin.certificates.destroy', $registration)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            onclick="return confirm('Hapus sertifikat ini?')"
                                            class="text-red-600 hover:text-red-900" 
                                            title="Hapus Sertifikat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        <?php elseif($registration->canDownloadCertificate()): ?>
                            <form action="<?php echo e(route('admin.certificates.generate', $registration)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">
                                    Generate
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-gray-400 text-xs">Belum eligible</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                        <?php if($event->is_paid && $registration->payment_proof && $registration->payment_status === 'paid'): ?>
                        <div class="flex gap-1">
                            <form action="<?php echo e(route('admin.events.verify-payment', [$event, $registration])); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="payment_status" value="verified">
                                <button type="submit" class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                                    ✓ Verifikasi
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.events.verify-payment', [$event, $registration])); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="payment_status" value="rejected">
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                    ✗ Tolak
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($registration->status === 'registered'): ?>
                        <form action="<?php echo e(route('admin.events.update-registration-status', [$event, $registration])); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="attended">
                            <button type="submit" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                Tandai Hadir
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-200">
        <?php echo e($registrations->links()); ?>

    </div>
    <?php else: ?>
    <div class="p-8 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <p class="text-lg font-medium">Belum ada peserta</p>
        <p class="text-sm">Peserta yang mendaftar akan muncul di sini</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/events/participants.blade.php ENDPATH**/ ?>