# Fitur Sertifikat Peserta Event

Fitur ini memungkinkan admin untuk generate sertifikat otomatis untuk peserta event yang telah selesai. Konsepnya mirip dengan kartu anggota, menggunakan template gambar yang dapat disesuaikan.

## Fitur Utama

1. **Template Sertifikat yang Dapat Disesuaikan**
   - Admin dapat upload template sertifikat sendiri
   - Template menggunakan format gambar (PNG/JPG) dengan ukuran rekomendasi 1064x662px (landscape)
   - Satu template aktif dapat dipilih dari berbagai template

2. **Generate Sertifikat Otomatis**
   - Sertifikat di-generate menggunakan GD Library (sama dengan kartu anggota)
   - Nama peserta dan nama event otomatis ditempatkan pada posisi yang sudah ditentukan
   - Generate per peserta atau bulk generate untuk semua peserta eligible

3. **Eligibility Sertifikat**
   - Event sudah selesai (event_date < now)
   - Event memiliki fitur certificate enabled (has_certificate = true)
   - Peserta tidak cancelled
   - Jika event berbayar, pembayaran harus terverifikasi

4. **Download Sertifikat oleh Member**
   - Member dapat melihat dan download sertifikat dari dashboard My Events
   - Sertifikat hanya tersedia jika sudah digenerate oleh admin

## Cara Penggunaan

### A. Setup Template Sertifikat (Admin)

1. Login sebagai Admin
2. Akses menu **Sertifikat → Template Sertifikat** (atau `/admin/certificates/templates`)
3. Klik **"Tambah Template"**
4. Upload gambar template sertifikat:
   - Format: PNG, JPG, JPEG
   - Max size: 10MB
   - Ukuran rekomendasi: 1064x662px (landscape)
5. Centang **"Jadikan template aktif"** untuk menggunakan template ini
6. Klik **"Simpan Template"**

**Template Design Guidelines:**
- Buat template dengan area kosong untuk nama peserta dan nama event
- Nama peserta akan ditempatkan di posisi Y: 390px (center)
- Nama event akan ditempatkan di posisi Y: 495px (center)
- Gunakan warna merah untuk text (seperti contoh template)
- Sertakan header dengan logo organisasi
- Tambahkan tanda tangan ketua/pejabat di bagian bawah

### B. Mengaktifkan Certificate untuk Event

1. Saat membuat/edit event, aktifkan checkbox **"Sediakan Sertifikat"**
2. Pastikan event memiliki tanggal selesai yang jelas

### C. Generate Sertifikat (Admin)

#### Generate per Peserta:
1. Buka **Kegiatan → Lihat Peserta** untuk event tertentu
2. Pada kolom "Sertifikat", klik tombol **"Generate"** untuk peserta yang eligible
3. Sertifikat akan ter-generate otomatis

#### Bulk Generate:
1. Buka **Kegiatan → Lihat Peserta** untuk event tertentu
2. Klik tombol **"🎓 Generate Semua Sertifikat"** di atas tabel
3. Sistem akan generate sertifikat untuk semua peserta yang memenuhi syarat

### D. Download Sertifikat (Member)

1. Login sebagai Member
2. Akses **Dashboard → Event Saya**
3. Pada event yang sudah selesai, klik icon download (hijau) jika sertifikat tersedia
4. Sertifikat akan terdownload sebagai file PNG

## Struktur Database

### Tabel: `certificate_templates`
```sql
- id: bigint (PK)
- name: varchar(255)
- template_image: varchar(255) - path to template image
- is_active: boolean - active template flag
- description: text (nullable)
- created_at: timestamp
- updated_at: timestamp
```

### Tabel: `event_registrations` (kolom tambahan)
```sql
- certificate_path: varchar(255) (nullable) - path to generated certificate
- certificate_generated_at: timestamp (nullable)
```

### Tabel: `events` (kolom tambahan)
```sql
- has_certificate: boolean - whether event provides certificate
- certificate_template: varchar(255) (nullable) - unused for now, for future custom template per event
```

## File-file yang Dibuat/Dimodifikasi

### Models
- `app/Models/CertificateTemplate.php` - Model untuk template sertifikat

### Services
- `app/Services/CertificateGenerator.php` - Service untuk generate sertifikat menggunakan GD Library

### Controllers
- `app/Http/Controllers/Admin/CertificateTemplateController.php` - CRUD template sertifikat
- `app/Http/Controllers/Admin/EventCertificateController.php` - Generate dan delete sertifikat
- `app/Http/Controllers/MemberCertificateController.php` - Download dan view sertifikat oleh member

### Views - Admin
- `resources/views/admin/certificates/templates/index.blade.php` - List template
- `resources/views/admin/certificates/templates/create.blade.php` - Form tambah template
- `resources/views/admin/certificates/templates/edit.blade.php` - Form edit template
- `resources/views/admin/events/participants.blade.php` - Ditambahkan kolom sertifikat dan bulk generate

### Views - Member
- `resources/views/member/certificates/view.blade.php` - Halaman view sertifikat
- `resources/views/member/events/my-events.blade.php` - Ditambahkan button download sertifikat

### Routes
```php
// Admin Routes
Route::resource('certificates.templates', AdminCertificateTemplateController::class);
Route::post('certificates/templates/{template}/activate', [AdminCertificateTemplateController::class, 'setActive']);
Route::post('certificates/{registration}/generate', [AdminEventCertificateController::class, 'generate']);
Route::post('certificates/bulk-generate', [AdminEventCertificateController::class, 'bulkGenerate']);
Route::delete('certificates/{registration}', [AdminEventCertificateController::class, 'destroy']);

// Member Routes
Route::get('/certificates/{registration}/download', [MemberCertificateController::class, 'download']);
Route::get('/certificates/{registration}/view', [MemberCertificateController::class, 'view']);
```

### Migrations
- `2025_12_19_023053_create_certificate_templates_table.php`

## Posisi Text pada Certificate

Default positions yang digunakan di `CertificateGenerator.php`:

```php
// Nama Peserta (center, merah, bold, 32px)
$participantNameY = 390;

// Nama Event (center, merah, bold, 28px, max 2 baris)
$eventNameY = 495;
$lineHeight = 38; // untuk baris ke-2 jika teks terlalu panjang
```

Jika perlu adjust posisi, edit file `app/Services/CertificateGenerator.php` pada bagian posisi Y.

## Contoh Template

Template harus memiliki struktur seperti pada gambar yang diberikan:
1. Header dengan logo dan nama organisasi
2. Judul "SERTIFIKAT" di tengah atas
3. Text "diberikan kepada :" di atas area nama peserta
4. Area kosong untuk nama peserta (Y: 390)
5. Text "Sebagai Peserta Dalam" di tengah
6. Area kosong untuk nama event (Y: 495)
7. Tanda tangan dan nama ketua di bagian bawah kanan

## Catatan Teknis

1. **Font yang Digunakan**: Arial (jika tersedia di `storage/fonts/`)
   - Bold: `storage/fonts/arialbd.ttf`
   - Regular: `storage/fonts/arial.ttf`
   - Fallback ke default GD font jika tidak ada

2. **Warna Text**: #FF0000 (merah) untuk nama peserta dan event

3. **Text Wrapping**: Nama event otomatis dibagi menjadi 2 baris jika lebih dari 60 karakter

4. **File Storage**: 
   - Template: `storage/app/public/certificate-templates/`
   - Generated certificates: `storage/app/public/certificates/`

5. **Eligibility Check**: Method `canDownloadCertificate()` pada model `EventRegistration`

## Troubleshooting

### Sertifikat tidak ter-generate
- Pastikan template aktif sudah diupload
- Periksa file template ada di storage
- Pastikan GD Library terinstall di PHP
- Cek logs di `storage/logs/laravel.log`

### Posisi text tidak sesuai
- Edit nilai `$participantNameY` dan `$eventNameY` di `CertificateGenerator.php`
- Adjust berdasarkan template yang digunakan

### Font tidak muncul dengan benar
- Pastikan file font ada di `storage/fonts/`
- Atau biarkan menggunakan default GD font

## Testing

1. Upload template sertifikat dengan ukuran 1064x662px
2. Buat event dengan checkbox "Sediakan Sertifikat" aktif
3. Daftarkan peserta ke event
4. Set tanggal event ke masa lalu (atau ubah manual di database)
5. Generate sertifikat dari halaman participants
6. Download sebagai member

---

**Dibuat:** 19 Desember 2025
**Konsep:** Mirip dengan sistem kartu anggota, menggunakan template gambar + auto text overlay
