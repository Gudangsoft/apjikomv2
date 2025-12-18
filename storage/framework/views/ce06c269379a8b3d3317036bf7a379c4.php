

<?php $__env->startSection('page-title', 'Edit Kegiatan'); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.events.index')); ?>" class="text-[#00629B] hover:text-[#003A5D] flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Kegiatan</h3>
    
    <form method="POST" action="<?php echo e(route('admin.events.update', $event)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kegiatan *</label>
            <input type="text" name="title" value="<?php echo e(old('title', $event->title)); ?>" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select name="category_id" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="">-- Pilih Kategori --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $event->category_id) == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p class="text-xs text-gray-500 mt-1">Kategori untuk mengelompokkan jenis kegiatan (opsional)</p>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Event</label>
            
            <?php if($event->image): ?>
            <div class="mb-3">
                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" class="max-w-xs rounded shadow">
            </div>
            <?php endif; ?>
            
            <input type="file" name="image" accept="image/*"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   onchange="previewImage(event)">
            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</p>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            
            <!-- Preview Image -->
            <div id="imagePreview" class="mt-3 hidden">
                <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                <img id="preview" src="" alt="Preview" class="max-w-xs rounded shadow">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
            <textarea id="description" name="description" rows="6" required
                      class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $event->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                <input type="date" name="event_date" value="<?php echo e(old('event_date', $event->event_date->format('Y-m-d'))); ?>" required
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <input type="time" name="event_time" value="<?php echo e(old('event_time', $event->event_time)); ?>"
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
            </div>
        </div>
        
        <!-- Event Type -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pelaksanaan *</label>
            <div class="grid grid-cols-3 gap-4">
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 <?php echo e(old('event_type', $event->event_type ?? 'offline') == 'offline' ? 'border-purple-500 bg-purple-50' : ''); ?>">
                    <input type="radio" name="event_type" value="offline" <?php echo e(old('event_type', $event->event_type ?? 'offline') == 'offline' ? 'checked' : ''); ?> 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Offline</span>
                </label>
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 <?php echo e(old('event_type', $event->event_type) == 'online' ? 'border-purple-500 bg-purple-50' : ''); ?>">
                    <input type="radio" name="event_type" value="online" <?php echo e(old('event_type', $event->event_type) == 'online' ? 'checked' : ''); ?> 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Online</span>
                </label>
                <label class="flex items-center p-4 border rounded cursor-pointer hover:bg-gray-50 <?php echo e(old('event_type', $event->event_type) == 'hybrid' ? 'border-purple-500 bg-purple-50' : ''); ?>">
                    <input type="radio" name="event_type" value="hybrid" <?php echo e(old('event_type', $event->event_type) == 'hybrid' ? 'checked' : ''); ?> 
                           class="text-purple-600" onchange="toggleEventFields()">
                    <span class="ml-2 font-medium">Hybrid</span>
                </label>
            </div>
        </div>
        
        <!-- Location (for offline/hybrid) -->
        <div class="mb-6" id="locationField">
            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
            <input type="text" name="location" value="<?php echo e(old('location', $event->location)); ?>"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Online Platform (for online/hybrid) -->
        <div class="mb-6" id="platformField">
            <label class="block text-sm font-medium text-gray-700 mb-2">Platform Online <span class="text-red-500">*</span></label>
            <input type="text" name="online_platform" value="<?php echo e(old('online_platform', $event->online_platform)); ?>"
                   placeholder="Contoh: Zoom, Google Meet, Microsoft Teams"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
            <p class="text-xs text-gray-500 mt-1">Platform yang digunakan untuk event online</p>
        </div>
        
        <!-- Registration Section -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">Pengaturan Pendaftaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="has_registration" value="1" <?php echo e(old('has_registration', $event->has_registration) ? 'checked' : ''); ?>

                               class="w-4 h-4 text-purple-600 border-gray-300 rounded" onchange="toggleRegistrationFields()">
                        <span class="text-sm font-medium text-gray-700">Memerlukan Pendaftaran</span>
                    </label>
                </div>
                
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="has_certificate" value="1" <?php echo e(old('has_certificate', $event->has_certificate) ? 'checked' : ''); ?>

                               class="w-4 h-4 text-purple-600 border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-700">Menyediakan Sertifikat</span>
                    </label>
                </div>
            </div>
            
            <div id="registrationDetails" class="<?php echo e(old('has_registration', $event->has_registration) ? '' : 'hidden'); ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Peserta</label>
                        <input type="number" name="participant_quota" value="<?php echo e(old('participant_quota', $event->participant_quota)); ?>" min="1"
                               placeholder="Contoh: 100"
                               class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak terbatas</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Biaya</label>
                        <div class="flex gap-4">
                            <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 <?php echo e(!old('is_paid', $event->is_paid) ? 'border-green-500 bg-green-50' : ''); ?>">
                                <input type="radio" name="is_paid" value="0" <?php echo e(!old('is_paid', $event->is_paid) ? 'checked' : ''); ?> 
                                       class="text-green-600" onchange="togglePaymentFields()">
                                <span class="ml-2 font-medium text-green-700">🆓 Gratis</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-gray-50 <?php echo e(old('is_paid', $event->is_paid) ? 'border-blue-500 bg-blue-50' : ''); ?>">
                                <input type="radio" name="is_paid" value="1" <?php echo e(old('is_paid', $event->is_paid) ? 'checked' : ''); ?> 
                                       class="text-blue-600" onchange="togglePaymentFields()">
                                <span class="ml-2 font-medium text-blue-700">💰 Berbayar</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Details (show when paid) -->
                <div id="paymentDetails" class="bg-blue-50 border border-blue-200 rounded-lg p-4 space-y-4 mb-4 <?php echo e(old('is_paid', $event->is_paid) ? '' : 'hidden'); ?>">
                    <h4 class="font-semibold text-blue-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Informasi Pembayaran
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Biaya (Rp) *</label>
                            <input type="number" name="registration_fee" value="<?php echo e(old('registration_fee', $event->registration_fee)); ?>" min="0" step="1000"
                                   placeholder="Contoh: 50000"
                                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank *</label>
                            <input type="text" name="bank_name" value="<?php echo e(old('bank_name', $event->bank_name)); ?>"
                                   placeholder="Contoh: BCA, Mandiri, BNI"
                                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening *</label>
                            <input type="text" name="bank_account" value="<?php echo e(old('bank_account', $event->bank_account)); ?>"
                                   placeholder="Contoh: 1234567890"
                                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik Rekening *</label>
                            <input type="text" name="bank_account_name" value="<?php echo e(old('bank_account_name', $event->bank_account_name)); ?>"
                                   placeholder="Contoh: APJIKOM Indonesia"
                                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kontak Konfirmasi Pembayaran *</label>
                        <input type="text" name="payment_contact" value="<?php echo e(old('payment_contact', $event->payment_contact)); ?>"
                               placeholder="Contoh: 08123456789 (WhatsApp)"
                               class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]">
                        <p class="text-xs text-gray-500 mt-1">Nomor WhatsApp/telepon untuk konfirmasi pembayaran</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Persyaratan Pendaftaran</label>
                    <textarea name="registration_requirements" rows="3"
                              class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B]"
                              placeholder="Contoh: KTP, CV, Surat Rekomendasi"><?php echo e(old('registration_requirements', $event->registration_requirements)); ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Link Pendaftaran</label>
            <input type="url" name="registration_link" value="<?php echo e(old('registration_link', $event->registration_link)); ?>"
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#00629B] <?php $__errorArgs = ['registration_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="https://example.com/register">
            <p class="text-xs text-gray-500 mt-1">URL lengkap untuk pendaftaran kegiatan (opsional)</p>
            <?php $__errorArgs = ['registration_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" <?php echo e(old('is_published', $event->is_published) ? 'checked' : ''); ?>

                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Event akan tampil di halaman publik</p>
            </div>
            
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $event->is_featured) ? 'checked' : ''); ?>

                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Tampilkan di Homepage</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Event akan muncul di slider homepage</p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="<?php echo e(route('admin.events.index')); ?>" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-[#00629B] text-white rounded hover:bg-[#003A5D]">
                Update Kegiatan
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Initialize TinyMCE
tinymce.init({
    selector: '#description',
    height: 400,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
        'anchor', 'searchreplace', 'visualblocks', 'code',
        'insertdatetime', 'media', 'table', 'wordcount'
    ],
    toolbar: 'blocks | bold italic underline strikethrough | forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image media table | removeformat code',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; font-size: 14px; line-height: 1.6; } img { max-width: 100%; height: auto; }',
    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;',
    file_picker_types: 'image',
    automatic_uploads: true,
    paste_data_images: true,
    images_reuse_filename: true,
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/admin/upload-image');
        
        xhr.onload = function() {
            if (xhr.status === 403) {
                failure('HTTP Error: ' + xhr.status, { remove: true });
                return;
            }
            
            if (xhr.status < 200 || xhr.status >= 300) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            
            var json = JSON.parse(xhr.responseText);
            
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            
            success(json.location);
        };
        
        xhr.onerror = function () {
            failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('_token', '<?php echo e(csrf_token()); ?>');
        
        xhr.send(formData);
    },
    branding: false,
    promotion: false,
    statusbar: true,
    resize: true,
    contextmenu: 'link image table',
    quickbars_selection_toolbar: 'bold italic underline | forecolor backcolor | alignleft aligncenter alignright',
    quickbars_insert_toolbar: 'quickimage quicktable',
    object_resizing: true,
    extended_valid_elements: 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style]',
    convert_urls: false,
    remove_script_host: false,
    relative_urls: false
});

// Toggle event type fields
function toggleEventFields() {
    const eventType = document.querySelector('input[name="event_type"]:checked').value;
    const locationField = document.getElementById('locationField');
    const platformField = document.getElementById('platformField');
    const locationInput = document.querySelector('input[name="location"]');
    const platformInput = document.querySelector('input[name="online_platform"]');
    
    if (eventType === 'offline') {
        locationField.classList.remove('hidden');
        platformField.classList.add('hidden');
        locationInput.required = true;
        platformInput.required = false;
    } else if (eventType === 'online') {
        locationField.classList.add('hidden');
        platformField.classList.remove('hidden');
        locationInput.required = false;
        platformInput.required = true;
    } else { // hybrid
        locationField.classList.remove('hidden');
        platformField.classList.remove('hidden');
        locationInput.required = true;
        platformInput.required = true;
    }
}

// Toggle registration fields
function toggleRegistrationFields() {
    const hasRegistration = document.querySelector('input[name="has_registration"]').checked;
    const registrationDetails = document.getElementById('registrationDetails');
    
    if (hasRegistration) {
        registrationDetails.classList.remove('hidden');
    } else {
        registrationDetails.classList.add('hidden');
    }
}

// Toggle payment fields
function togglePaymentFields() {
    const isPaid = document.querySelector('input[name="is_paid"]:checked')?.value === '1';
    const paymentDetails = document.getElementById('paymentDetails');
    
    if (isPaid) {
        paymentDetails.classList.remove('hidden');
    } else {
        paymentDetails.classList.add('hidden');
    }
}

// Initialize on page load
toggleEventFields();
toggleRegistrationFields();
togglePaymentFields();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/admin/events/edit.blade.php ENDPATH**/ ?>