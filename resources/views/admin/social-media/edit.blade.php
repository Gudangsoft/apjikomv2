@extends('layouts.admin')

@section('title', 'Edit Media Sosial')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-4 mb-1">Edit Media Sosial</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.social-media.index') }}">Media Sosial</a></li>
                    <li class="breadcrumb-item active">Edit - {{ $socialMedium->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-warning text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Form Edit Media Sosial
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.social-media.update', $socialMedium) }}" method="POST" enctype="multipart/form-data" id="socialMediaForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Platform -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-tag text-warning me-1"></i>
                                Nama Platform <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $socialMedium->name) }}"
                                   placeholder="Contoh: Facebook, Instagram, Twitter"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- URL -->
                        <div class="mb-4">
                            <label for="url" class="form-label fw-bold">
                                <i class="fas fa-link text-warning me-1"></i>
                                URL Link <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-globe text-muted"></i>
                                </span>
                                <input type="url" 
                                       class="form-control @error('url') is-invalid @enderror" 
                                       id="url" 
                                       name="url" 
                                       value="{{ old('url', $socialMedium->url) }}"
                                       placeholder="https://facebook.com/apjikom"
                                       required>
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle"></i> Format lengkap dengan https:// atau http://</small>
                        </div>

                        <!-- Icon Section -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-image text-warning me-1"></i>
                                Icon/Logo Media Sosial
                            </label>

                            <!-- Current Icon Display -->
                            @if($socialMedium->icon || $socialMedium->icon_class)
                                <div class="alert alert-info mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <strong><i class="fas fa-info-circle"></i> Icon Saat Ini:</strong>
                                        </div>
                                        <div>
                                            @if($socialMedium->icon)
                                                <img src="{{ asset('storage/' . $socialMedium->icon) }}" 
                                                     alt="{{ $socialMedium->name }}" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 80px; max-height: 80px;">
                                            @elseif($socialMedium->icon_class)
                                                <i class="{{ $socialMedium->icon_class }}" style="font-size: 48px;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row g-3">
                                <!-- Upload Icon -->
                                <div class="col-md-6">
                                    <div class="card border-2 border-dashed h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-warning mb-2"></i>
                                                <h6 class="fw-bold">Upload Icon Baru</h6>
                                            </div>
                                            <input type="file" 
                                                   class="form-control @error('icon') is-invalid @enderror" 
                                                   id="icon" 
                                                   name="icon"
                                                   accept="image/png,image/jpg,image/jpeg,image/svg+xml"
                                                   onchange="previewIcon(event)">
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-check-circle text-success"></i> PNG, JPG, SVG<br>
                                                <i class="fas fa-weight-hanging"></i> Max: 2MB
                                            </small>
                                            
                                            <!-- Preview Upload -->
                                            <div id="iconPreview" class="mt-3" style="display: none;">
                                                <img id="iconPreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Icon Class -->
                                <div class="col-md-6">
                                    <div class="card border-2 border-dashed h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-icons fa-3x text-success mb-2"></i>
                                                <h6 class="fw-bold">Atau Icon Class</h6>
                                            </div>
                                            <input type="text" 
                                                   class="form-control text-center @error('icon_class') is-invalid @enderror" 
                                                   id="icon_class" 
                                                   name="icon_class" 
                                                   value="{{ old('icon_class', $socialMedium->icon_class) }}"
                                                   placeholder="fab fa-facebook"
                                                   oninput="previewIconClass()">
                                            @error('icon_class')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-2">
                                                Font Awesome Class
                                            </small>
                                            
                                            <!-- Preview Icon Class -->
                                            <div id="iconClassPreview" class="mt-3" style="display: {{ $socialMedium->icon_class ? 'block' : 'none' }};">
                                                <i id="iconClassPreviewIcon" class="{{ $socialMedium->icon_class }}" style="font-size: 48px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="mb-4">
                            <label for="note" class="form-label fw-bold">
                                <i class="fas fa-sticky-note text-warning me-1"></i>
                                Note/Keterangan
                            </label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" 
                                      name="note" 
                                      rows="3"
                                      placeholder="Keterangan tambahan tentang media sosial ini...">{{ old('note', $socialMedium->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><i class="fas fa-lightbulb"></i> Akan ditampilkan sebagai tooltip di dashboard member</small>
                        </div>

                        <div class="row">
                            <!-- Urutan -->
                            <div class="col-md-6 mb-4">
                                <label for="order" class="form-label fw-bold">
                                    <i class="fas fa-sort-numeric-down text-warning me-1"></i>
                                    Urutan Tampilan <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('order') is-invalid @enderror" 
                                       id="order" 
                                       name="order" 
                                       value="{{ old('order', $socialMedium->order) }}"
                                       min="0"
                                       required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted"><i class="fas fa-arrow-up"></i> Angka kecil = awal tampilan</small>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-toggle-on text-warning me-1"></i>
                                    Status
                                </label>
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active"
                                                   value="1"
                                                   {{ old('is_active', $socialMedium->is_active) ? 'checked' : '' }}
                                                   style="width: 3em; height: 1.5em;">
                                            <label class="form-check-label fw-bold" for="is_active">
                                                <span id="statusLabel">{{ $socialMedium->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                                <span class="badge {{ $socialMedium->is_active ? 'bg-success' : 'bg-secondary' }} ms-2" id="statusBadge">
                                                    {{ $socialMedium->is_active ? 'Tampil di Dashboard' : 'Tidak Tampil' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.social-media.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg px-5 text-white">
                                <i class="fas fa-save me-2"></i> Update Media Sosial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Panduan -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Panduan Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold text-primary"><i class="fas fa-image me-1"></i> Tentang Icon</h6>
                    <p class="small text-muted">Pilih salah satu metode:</p>
                    <ol class="small">
                        <li class="mb-2"><strong>Upload Icon Baru</strong>: Replace icon yang ada</li>
                        <li><strong>Icon Class</strong>: Gunakan Font Awesome</li>
                    </ol>
                    
                    <div class="alert alert-warning small mb-3">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Upload icon baru akan menggantikan icon lama
                    </div>

                    <hr>

                    <h6 class="fw-bold text-success"><i class="fab fa-font-awesome-flag me-1"></i> Contoh Icon Class</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-2">
                            <i class="fab fa-facebook text-primary fa-lg me-2"></i>
                            <code class="small">fab fa-facebook</code>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <i class="fab fa-instagram text-danger fa-lg me-2"></i>
                            <code class="small">fab fa-instagram</code>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <i class="fab fa-twitter text-info fa-lg me-2"></i>
                            <code class="small">fab fa-twitter</code>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <i class="fab fa-linkedin text-primary fa-lg me-2"></i>
                            <code class="small">fab fa-linkedin</code>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="https://fontawesome.com/icons?d=gallery&s=brands" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Semua Icon
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold text-warning"><i class="fas fa-lightbulb me-1"></i> Tips</h6>
                    <ul class="small mb-0 ps-3">
                        <li>Upload icon baru akan hapus icon lama otomatis</li>
                        <li>Kosongkan icon class jika pakai upload</li>
                        <li>Urutan bisa diubah dengan drag & drop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview uploaded icon
function previewIcon(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('iconPreviewImg').src = e.target.result;
            document.getElementById('iconPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Preview icon class
function previewIconClass() {
    const iconClass = document.getElementById('icon_class').value.trim();
    const preview = document.getElementById('iconClassPreview');
    const icon = document.getElementById('iconClassPreviewIcon');
    
    if (iconClass) {
        icon.className = iconClass;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

// Toggle status label
document.getElementById('is_active').addEventListener('change', function() {
    const label = document.getElementById('statusLabel');
    const badge = document.getElementById('statusBadge');
    
    if (this.checked) {
        label.textContent = 'Aktif';
        badge.textContent = 'Tampil di Dashboard';
        badge.className = 'badge bg-success ms-2';
    } else {
        label.textContent = 'Nonaktif';
        badge.textContent = 'Tidak Tampil';
        badge.className = 'badge bg-secondary ms-2';
    }
});
</script>
@endpush
@endsection
