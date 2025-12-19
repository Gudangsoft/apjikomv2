

<?php $__env->startSection('page-title', 'Kelola Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-2xl font-bold text-gray-900">Daftar Berita</h3>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="bg-[#00629B] text-white px-4 py-2 rounded hover:bg-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Berita</span>
    </a>
</div>

<!-- Tutorial Note -->
<div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-blue-800 mb-1">📰 Berita & Artikel</h3>
            <p class="text-sm text-blue-700 mb-2">
                Kelola <strong>berita dan artikel</strong> yang tampil di website. 
                Set status <strong>Published</strong> untuk tampilkan di publik, atau <strong>Draft</strong> untuk simpan dulu.
            </p>
        </div>
    </div>
</div>

<!-- Advanced Search & Filter with Alpine.js -->
<div class="mb-6 bg-white rounded-lg shadow p-6" x-data="newsFilter()">
    <form @submit.prevent="applyFilters">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" 
                       x-model.debounce.500ms="filters.search"
                       @input="applyFilters"
                       placeholder="Judul berita..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select x-model="filters.category" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select x-model="filters.status" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <!-- Featured Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Featured</label>
                <select x-model="filters.featured" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" 
                       x-model="filters.date_from"
                       @change="applyFilters"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Date To -->
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
                    <option value="title">Judul A-Z</option>
                    <option value="views">Views Tertinggi</option>
                </select>
            </div>

            <!-- Results per page -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Per Halaman</label>
                <select x-model="filters.per_page" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-600" x-html="recordInfo">
                Menampilkan <?php echo e($news->firstItem() ?? 0); ?> - <?php echo e($news->lastItem() ?? 0); ?> dari <?php echo e($news->total()); ?> berita
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

<div class="bg-white rounded-lg shadow overflow-hidden" id="tableContainer">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
            <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-6 py-4">
                    <?php if($item->image): ?>
                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->title); ?>" class="w-16 h-16 object-cover rounded">
                    <?php else: ?>
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <?php if($item->is_featured): ?>
                        <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <?php endif; ?>
                        <div class="text-sm font-medium text-gray-900"><?php echo e(Str::limit($item->title, 60)); ?></div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        <?php echo e($item->category->name); ?>

                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                        <?php echo e($item->is_published ? 'Published' : 'Draft'); ?>

                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo e($item->views); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo e($item->published_at?->format('d M Y') ?? '-'); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="<?php echo e(route('news.show', $item->slug)); ?>" target="_blank" class="text-gray-600 hover:text-gray-900 mr-3" title="Lihat">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a href="<?php echo e(route('admin.news.edit', $item)); ?>" class="text-[#00629B] hover:text-[#003A5D] mr-3" title="Edit">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.news.destroy', $item)); ?>" class="inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada berita</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-6" id="paginationContainer">
    <?php echo e($news->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function newsFilter() {
    return {
        loading: false,
        filters: {
            search: '<?php echo e(request("search")); ?>',
            category: '<?php echo e(request("category")); ?>',
            status: '<?php echo e(request("status")); ?>',
            featured: '<?php echo e(request("featured")); ?>',
            date_from: '<?php echo e(request("date_from")); ?>',
            date_to: '<?php echo e(request("date_to")); ?>',
            sort: '<?php echo e(request("sort", "latest")); ?>',
            per_page: '<?php echo e(request("per_page", 15)); ?>'
        },
        currentPage: 1,
        recordInfo: 'Menampilkan <?php echo e($news->firstItem() ?? 0); ?> - <?php echo e($news->lastItem() ?? 0); ?> dari <?php echo e($news->total()); ?> berita',
        
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
                category: '',
                status: '',
                featured: '',
                date_from: '',
                date_to: '',
                sort: 'latest',
                per_page: 15
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
            
            fetch(`<?php echo e(route("admin.news.index")); ?>?${params.toString()}`, {
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/news/index.blade.php ENDPATH**/ ?>