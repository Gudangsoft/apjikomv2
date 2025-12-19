# Fitur Manajemen Media Sosial

## Deskripsi
Fitur ini memungkinkan admin untuk mengelola link media sosial yang akan ditampilkan di dashboard member. Admin dapat menambah, mengedit, menghapus, dan mengatur urutan tampilan media sosial secara dinamis.

## Teknologi yang Digunakan
- Laravel 12.37.0
- SortableJS (untuk drag & drop reorder)
- Alpine.js (untuk interaktivitas menu)
- Tailwind CSS (untuk styling)
- Font Awesome (untuk icon media sosial)

## Database

### Tabel: `social_media`

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | bigint unsigned | NO | AUTO_INCREMENT | Primary key |
| name | varchar(255) | NO | - | Nama platform media sosial |
| url | varchar(255) | NO | - | URL link media sosial |
| icon | varchar(255) | YES | NULL | Path file icon yang diupload |
| icon_class | varchar(255) | YES | NULL | Class icon (Font Awesome) |
| note | text | YES | NULL | Catatan/keterangan |
| order | integer | NO | 0 | Urutan tampilan |
| is_active | boolean | NO | true | Status aktif/nonaktif |
| created_at | timestamp | YES | NULL | Waktu dibuat |
| updated_at | timestamp | YES | NULL | Waktu diupdate |

## File yang Dibuat/Dimodifikasi

### 1. Model
- **`app/Models/SocialMedia.php`**
  - Model untuk mengelola data media sosial
  - Method:
    - `scopeActive($query)`: Filter data yang aktif
    - `scopeOrdered($query)`: Urutkan berdasarkan kolom order

### 2. Migration
- **`database/migrations/2025_12_19_043538_create_social_media_table.php`**
  - Membuat tabel `social_media` dengan kolom yang diperlukan

### 3. Controller
- **`app/Http/Controllers/Admin/SocialMediaController.php`**
  - CRUD operations untuk media sosial
  - Method:
    - `index()`: Menampilkan daftar media sosial
    - `create()`: Menampilkan form tambah
    - `store()`: Menyimpan data baru (dengan upload icon)
    - `edit()`: Menampilkan form edit
    - `update()`: Update data (dengan upload icon baru)
    - `destroy()`: Hapus data (dan hapus file icon)
    - `updateOrder()`: Update urutan tampilan via AJAX

### 4. Views Admin
- **`resources/views/admin/social-media/index.blade.php`**
  - Daftar media sosial dengan fitur drag & drop reorder
  - Menampilkan icon, nama, URL, note, dan status
  - Tombol edit dan hapus
  
- **`resources/views/admin/social-media/create.blade.php`**
  - Form tambah media sosial baru
  - Upload icon atau gunakan icon class
  - Validasi URL
  
- **`resources/views/admin/social-media/edit.blade.php`**
  - Form edit media sosial
  - Preview icon yang ada
  - Update icon atau icon class

### 5. Member Dashboard
- **`resources/views/member/dashboard.blade.php`**
  - Menampilkan section media sosial
  - Grid 6 kolom (responsive)
  - Hover effect dan animasi
  - Tooltip dengan note

### 6. Routes
- **`routes/web.php`**
  ```php
  Route::resource('social-media', App\Http\Controllers\Admin\SocialMediaController::class)->except(['show']);
  Route::post('social-media/update-order', [App\Http\Controllers\Admin\SocialMediaController::class, 'updateOrder'])->name('social-media.update-order');
  ```

### 7. Admin Sidebar
- **`resources/views/layouts/admin.blade.php`**
  - Menu "Media Sosial" di section "Pengaturan"
  - Alpine.js routing untuk active state

### 8. Controller Update
- **`app/Http/Controllers/Member/MemberDashboardController.php`**
  - Menambahkan query untuk mendapatkan social media aktif
  - Pass data `$socialMedia` ke view

### 9. Seeder
- **`database/seeders/SocialMediaSeeder.php`**
  - Data default untuk 6 platform media sosial
  - Facebook, Instagram, Twitter, YouTube, LinkedIn, TikTok

## Fitur Utama

### 1. Upload Icon atau Icon Class
Admin dapat memilih 2 metode untuk icon:
- **Upload Icon**: Upload file gambar (PNG, JPG, JPEG, SVG, max 2MB)
- **Icon Class**: Gunakan class Font Awesome (contoh: `fab fa-facebook`)

### 2. Drag & Drop Reorder
- Menggunakan SortableJS
- Admin dapat mengubah urutan tampilan dengan drag & drop
- Update otomatis via AJAX tanpa reload halaman

### 3. Status Aktif/Nonaktif
- Toggle untuk menampilkan/menyembunyikan media sosial
- Hanya yang aktif yang ditampilkan di dashboard member

### 4. Note/Keterangan
- Admin dapat menambahkan catatan untuk setiap media sosial
- Ditampilkan sebagai tooltip di dashboard member

### 5. Validasi URL
- Validasi format URL harus dimulai dengan `https://` atau `http://`
- Mencegah input URL yang tidak valid

## Cara Penggunaan

### A. Menambah Media Sosial Baru

1. Login sebagai admin
2. Buka menu **Pengaturan > Media Sosial**
3. Klik tombol **Tambah Media Sosial**
4. Isi form:
   - **Nama Platform**: Contoh: Facebook
   - **URL**: Contoh: https://facebook.com/apjikom
   - **Icon**: Upload file atau isi icon class
   - **Note**: Keterangan opsional
   - **Urutan**: Angka urutan (0, 1, 2, dst)
   - **Status**: Centang untuk aktif
5. Klik **Simpan**

### B. Mengedit Media Sosial

1. Buka menu **Pengaturan > Media Sosial**
2. Klik tombol **Edit** (icon pensil) pada media sosial yang ingin diedit
3. Ubah data yang diperlukan
4. Klik **Update**

### C. Mengubah Urutan Tampilan

1. Buka menu **Pengaturan > Media Sosial**
2. Drag & drop baris pada icon grip (⋮⋮)
3. Urutan akan tersimpan otomatis

### D. Menghapus Media Sosial

1. Buka menu **Pengaturan > Media Sosial**
2. Klik tombol **Hapus** (icon trash) pada media sosial yang ingin dihapus
3. Konfirmasi penghapusan
4. File icon (jika ada) akan terhapus otomatis

## Contoh Icon Class (Font Awesome)

```
fab fa-facebook        → Facebook
fab fa-instagram       → Instagram
fab fa-twitter         → Twitter/X
fab fa-linkedin        → LinkedIn
fab fa-youtube         → YouTube
fab fa-tiktok          → TikTok
fab fa-whatsapp        → WhatsApp
fab fa-telegram        → Telegram
fab fa-discord         → Discord
fab fa-github          → GitHub
```

## Tampilan di Member Dashboard

Media sosial yang aktif akan ditampilkan sebagai:
- **Grid responsive**: 2 kolom (mobile), 3 kolom (tablet), 6 kolom (desktop)
- **Card dengan hover effect**: Animasi scale dan perubahan warna
- **Icon/Logo**: Dari upload atau icon class
- **Nama platform**: Teks bold di bawah icon
- **Note**: Tooltip singkat (max 40 karakter)
- **Link eksternal**: Buka di tab baru

## Testing

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder (Opsional)
```bash
php artisan db:seed --class=SocialMediaSeeder
```

### 3. Akses Admin Panel
```
URL: http://yourdomain.com/admin/social-media
```

### 4. Lihat Dashboard Member
```
URL: http://yourdomain.com/member/dashboard
```

## Validasi Form

### Store/Update Validation Rules:
- **name**: required, string, max 255 karakter
- **url**: required, valid URL, max 255 karakter
- **icon**: nullable, image (png/jpg/jpeg/svg), max 2MB
- **icon_class**: nullable, string, max 255 karakter
- **note**: nullable, text
- **order**: required, integer, minimum 0
- **is_active**: boolean

## Error Handling

- **Upload Icon Gagal**: Validasi ukuran dan tipe file
- **URL Tidak Valid**: Validasi format URL
- **Order Update Gagal**: Rollback dan tampilkan error message
- **Delete dengan Icon**: Hapus file dari storage secara otomatis

## Security

1. **Authorization**: Hanya admin yang dapat mengakses management
2. **CSRF Protection**: Token di semua form POST/PUT/DELETE
3. **File Upload Validation**: Tipe dan ukuran file divalidasi
4. **XSS Protection**: Blade templating auto-escape output
5. **SQL Injection Prevention**: Query builder dan Eloquent ORM

## Performa

1. **Eager Loading**: Query optimal dengan indexing
2. **Cache**: Bisa ditambahkan cache untuk query social media
3. **Lazy Load Images**: Icon dimuat secara efficient
4. **AJAX Order Update**: Tanpa reload halaman penuh

## Future Enhancements

1. **Social Media Analytics**: Tracking klik pada setiap link
2. **Multi-language Support**: Nama dan note dalam berbagai bahasa
3. **Custom Styling**: Admin dapat mengatur warna theme per platform
4. **API Integration**: Tampilkan follower count dari API media sosial
5. **Scheduling**: Aktifkan/nonaktifkan media sosial berdasarkan jadwal

## Troubleshooting

### Icon Tidak Muncul
- Pastikan Font Awesome sudah di-load di layout
- Cek path storage untuk uploaded icon
- Verifikasi permission folder storage

### Drag & Drop Tidak Berfungsi
- Pastikan SortableJS sudah ter-load
- Cek console browser untuk JavaScript errors
- Verifikasi route `social-media.update-order` terdaftar

### Media Sosial Tidak Muncul di Dashboard
- Pastikan status `is_active` = true
- Cek query di MemberDashboardController
- Verifikasi data seeder sudah berjalan

## Catatan Penting

- Pastikan storage link sudah dibuat: `php artisan storage:link`
- Icon yang diupload disimpan di `storage/app/public/social-media-icons/`
- Maksimal ukuran file icon: 2MB
- Format URL harus lengkap dengan protocol (https:// atau http://)
- Urutan dimulai dari 0 (paling awal)

## Support

Untuk pertanyaan atau issue, hubungi tim development APJIKOM.

---

**Created**: 19 Desember 2025  
**Version**: 1.0.0  
**Laravel**: 12.37.0  
**PHP**: 8.3.24
