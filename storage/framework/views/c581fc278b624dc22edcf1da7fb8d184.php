

<?php $__env->startSection('page-title', 'Kelola Members'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h3 class="text-2xl font-bold text-gray-900">Daftar Members</h3>
</div>

<?php if(session('success')): ?>
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(session('info')): ?>
<div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-medium text-blue-800"><?php echo e(session('info')); ?></p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Tutorial Note -->
<div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-blue-800 mb-1">📚 Tutorial Penggunaan</h3>
            <p class="text-sm text-blue-700 mb-2">
                Halaman ini untuk <strong>mengelola member aktif</strong> yang sudah di-approve. 
                Gunakan <strong>✏️ Edit</strong> untuk update data member atau ubah status ACTIVE/INACTIVE.
            </p>
            <a href="<?php echo e(asset('TUTORIAL_ADMIN_MEMBER_REGISTRATION.md')); ?>" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium underline">
                📖 Baca Tutorial Lengkap →
            </a>
        </div>
    </div>
</div>

<!-- New Members Alert -->
<?php
    $newMembers = \App\Models\Member::where(function($query) {
        $query->whereNull('member_card')
              ->where('card_requested', true);
    })->orWhere(function($query) {
        $query->whereNull('member_card')
              ->whereNotNull('photo')
              ->whereNotNull('address')
              ->whereNotNull('phone');
    })->with('user')->get();
    
    // Card update requests
    $updateRequestMembers = \App\Models\Member::where('card_update_requested', true)
        ->whereNotNull('member_card')
        ->with('user')
        ->orderBy('card_update_requested_at', 'desc')
        ->get();
?>

<!-- Card Update Requests Alert -->
<?php if($updateRequestMembers->count() > 0): ?>
<div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-amber-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-800 mb-1">
                🔄 Ada <?php echo e($updateRequestMembers->count()); ?> Permintaan Update Kartu Anggota
            </h3>
            <p class="text-sm text-amber-700 mb-3">
                Member berikut meminta pembaruan kartu karena ada perubahan data:
            </p>
            <div class="bg-amber-100 rounded-lg p-3">
                <ul class="space-y-2">
                    <?php $__currentLoopData = $updateRequestMembers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $updateMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 bg-amber-600 text-white text-xs font-bold rounded">UPDATE</span>
                            <span class="text-amber-900 font-medium"><?php echo e($updateMember->user->name); ?></span>
                            <span class="text-amber-600 text-xs">(<?php echo e($updateMember->user->email); ?>)</span>
                            <span class="text-xs text-amber-600 italic">
                                - <?php echo e($updateMember->card_update_requested_at->diffForHumans()); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('admin.members.show', $updateMember->id)); ?>" 
                           class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded-lg transition">
                            Regenerate Kartu
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($updateRequestMembers->count() > 5): ?>
                    <li class="text-xs text-amber-600 italic">
                        ... dan <?php echo e($updateRequestMembers->count() - 5); ?> member lainnya
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($newMembers->count() > 0): ?>
<div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-blue-800 mb-1">
                🔔 Ada <?php echo e($newMembers->count()); ?> Permintaan Kartu Anggota (KTA)
            </h3>
            <p class="text-sm text-blue-700 mb-3">
                Member berikut sudah melengkapi data dan meminta pembuatan Kartu Anggota:
            </p>
            <div class="bg-blue-100 rounded-lg p-3">
                <ul class="space-y-2">
                    <?php $__currentLoopData = $newMembers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <?php if($newMember->card_requested): ?>
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">REQUEST</span>
                            <?php else: ?>
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            <?php endif; ?>
                            <span class="text-blue-900 font-medium"><?php echo e($newMember->user->name); ?></span>
                            <span class="text-blue-600 text-xs">(<?php echo e($newMember->user->email); ?>)</span>
                            <?php if($newMember->card_requested): ?>
                                <span class="text-xs text-blue-600 italic">
                                    - <?php echo e($newMember->card_requested_at->diffForHumans()); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('admin.members.show', $newMember->id)); ?>" 
                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition">
                            Generate Kartu
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($newMembers->count() > 5): ?>
                    <li class="text-xs text-blue-600 italic">
                        ... dan <?php echo e($newMembers->count() - 5); ?> member lainnya
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Advanced Search & Filter with Alpine.js -->
<div class="mb-6 bg-white rounded-lg shadow p-6" x-data="memberFilter()">
    <form @submit.prevent="applyFilters">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" 
                       x-model.debounce.500ms="filters.search"
                       @input="applyFilters"
                       placeholder="Nama, email, institusi..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select x-model="filters.status" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="active">Aktif</option>
                    <option value="rejected">Ditolak</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Verification Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Verifikasi</label>
                <select x-model="filters.verified" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1">Verified</option>
                    <option value="0">Unverified</option>
                </select>
            </div>

            <!-- Card Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Kartu</label>
                <select x-model="filters.has_card" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1">Sudah Ada Kartu</option>
                    <option value="0">Belum Ada Kartu</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" 
                       x-model="filters.date_from"
                       @change="applyFilters"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" 
                       x-model="filters.date_to"
                       @change="applyFilters"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                <select x-model="filters.sort" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-600" x-html="recordInfo">
                Menampilkan <?php echo e($members->firstItem() ?? 0); ?> - <?php echo e($members->lastItem() ?? 0); ?> dari <?php echo e($members->total()); ?> member
            </div>
            <div class="flex space-x-3">
                <button type="button" @click="resetFilters" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Reset Filter
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Bulk Actions -->
<?php
    $unverifiedCount = \App\Models\Member::where('is_verified', false)->count();
?>

<?php if($unverifiedCount > 0): ?>
<div class="mb-6 bg-white rounded-lg shadow p-4 border-l-4 border-green-500" x-data="{ showConfirm: false }">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div>
                <h4 class="text-sm font-semibold text-gray-900 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Verifikasi Member Massal</span>
                </h4>
                <p class="text-xs text-gray-600 mt-1">
                    Ada <strong class="text-green-600"><?php echo e($unverifiedCount); ?> member</strong> yang belum diverifikasi
                </p>
            </div>
        </div>
        
        <button type="button" 
                @click="showConfirm = true"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Verifikasi <?php echo e($unverifiedCount); ?> Member</span>
        </button>
    </div>
    
    <!-- Confirmation Modal -->
    <div x-show="showConfirm" 
         x-cloak
         @click.away="showConfirm = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">
                    Verifikasi Semua Member?
                </h3>
                <p class="text-sm text-gray-600 text-center mb-6">
                    Anda akan memverifikasi <strong class="text-green-600"><?php echo e($unverifiedCount); ?> member</strong> yang belum diverifikasi. 
                    Member yang sudah diverifikasi tidak akan terpengaruh.
                </p>
                
                <form action="<?php echo e(route('admin.members.bulk-verify')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="flex space-x-3">
                        <button type="button" 
                                @click="showConfirm = false"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Ya, Verifikasi Semua
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow overflow-hidden" id="tableContainer">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verified</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kartu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?php echo e($member->user->name); ?></div>
                    <?php if($member->institution_name): ?>
                    <div class="text-xs text-gray-500"><?php echo e($member->institution_name); ?></div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo e($member->user->email); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($member->status == 'pending'): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    <?php elseif($member->status == 'active'): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    <?php elseif($member->status == 'rejected'): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    <?php else: ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo e(ucfirst($member->status)); ?></span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if (isset($component)) { $__componentOriginal87dc609e8be1339321cb0d9211a32c54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87dc609e8be1339321cb0d9211a32c54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.verified-badge','data' => ['member' => $member,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('verified-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['member' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal87dc609e8be1339321cb0d9211a32c54)): ?>
<?php $attributes = $__attributesOriginal87dc609e8be1339321cb0d9211a32c54; ?>
<?php unset($__attributesOriginal87dc609e8be1339321cb0d9211a32c54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal87dc609e8be1339321cb0d9211a32c54)): ?>
<?php $component = $__componentOriginal87dc609e8be1339321cb0d9211a32c54; ?>
<?php unset($__componentOriginal87dc609e8be1339321cb0d9211a32c54); ?>
<?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <?php if($member->member_card): ?>
                        <span class="text-green-600" title="Kartu sudah diupload">
                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    <?php else: ?>
                        <span class="text-gray-400" title="Belum ada kartu">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo e($member->created_at->format('d M Y')); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="<?php echo e(route('admin.members.show', $member)); ?>" class="text-gray-600 hover:text-gray-900 mr-3" title="Detail">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    
                    <?php if($member->status == 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('admin.members.approve', $member)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3" title="Approve">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <form method="POST" action="<?php echo e(route('admin.members.reject', $member)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900 mr-3" title="Reject">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo e(route('admin.members.destroy', $member)); ?>" class="inline" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada member</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-6" id="paginationContainer">
    <?php echo e($members->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function memberFilter() {
    return {
        loading: false,
        filters: {
            search: '<?php echo e(request("search")); ?>',
            status: '<?php echo e(request("status")); ?>',
            verified: '<?php echo e(request("verified")); ?>',
            has_card: '<?php echo e(request("has_card")); ?>',
            date_from: '<?php echo e(request("date_from")); ?>',
            date_to: '<?php echo e(request("date_to")); ?>',
            sort: '<?php echo e(request("sort", "latest")); ?>'
        },
        currentPage: 1,
        recordInfo: 'Menampilkan <?php echo e($members->firstItem() ?? 0); ?> - <?php echo e($members->lastItem() ?? 0); ?> dari <?php echo e($members->total()); ?> member',
        
        init() {
            this.$nextTick(() => {
                this.bindPaginationLinks();
            });
        },
        
        applyFilters() {
            this.currentPage = 1;
            this.loadData();
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                status: '',
                verified: '',
                has_card: '',
                date_from: '',
                date_to: '',
                sort: 'latest'
            };
            this.currentPage = 1;
            this.loadData();
        },
        
        loadData(page = null) {
            if (page) this.currentPage = page;
            
            const params = new URLSearchParams({
                ...this.filters,
                page: this.currentPage
            });
            
            for (let [key, value] of [...params.entries()]) {
                if (!value) params.delete(key);
            }
            
            this.loading = true;
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><div class="mt-2 text-gray-600">Memuat data...</div></td></tr>';
            
            fetch(`<?php echo e(route("admin.members.index")); ?>?${params.toString()}`, {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTableBody = doc.querySelector('#tableBody');
                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                }
                
                const newPagination = doc.querySelector('#paginationContainer');
                const paginationContainer = document.getElementById('paginationContainer');
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                    this.bindPaginationLinks();
                }
                
                const newRecordInfo = doc.querySelector('#recordInfo');
                if (newRecordInfo) {
                    this.recordInfo = newRecordInfo.innerHTML;
                }
                
                this.loading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center text-red-600">Terjadi kesalahan saat memuat data. Silakan coba lagi.</td></tr>';
                this.loading = false;
            });
        },
        
        bindPaginationLinks() {
            document.querySelectorAll('#paginationContainer a').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = link.getAttribute('href');
                    if (url) {
                        const urlParams = new URLSearchParams(url.split('?')[1]);
                        const page = urlParams.get('page') || 1;
                        this.loadData(page);
                        
                        document.getElementById('tableContainer').scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                });
            });
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/members/index.blade.php ENDPATH**/ ?>