# Pengamanan Akses Admin dan Member

## Ringkasan
Implementasi middleware untuk memisahkan akses antara Admin dan Member, sehingga:
- Member tidak dapat mengakses halaman `/admin/*` dengan mengubah URL
- Admin tidak dapat mengakses halaman `/member/*` dengan mengubah URL
- Pengguna akan mendapat halaman error 403 (Forbidden) jika mencoba mengakses halaman yang tidak sesuai dengan role mereka

## File yang Dibuat

### 1. Middleware AdminMiddleware
**File:** `app/Http/Middleware/AdminMiddleware.php`

Middleware ini memastikan hanya user dengan role `admin` yang dapat mengakses route admin:
- Memeriksa apakah user sudah login
- Memeriksa apakah user memiliki role admin menggunakan method `isAdmin()`
- Menolak akses dengan error 403 jika bukan admin

### 2. Middleware MemberMiddleware
**File:** `app/Http/Middleware/MemberMiddleware.php`

Middleware ini memastikan hanya user dengan role `member` yang dapat mengakses route member:
- Memeriksa apakah user sudah login
- Memeriksa apakah user memiliki role member menggunakan method `isMember()`
- Menolak akses dengan error 403 jika bukan member

### 3. Halaman Error 403
**File:** `resources/views/errors/403.blade.php`

Halaman error yang ditampilkan ketika user mencoba mengakses halaman yang tidak sesuai dengan role mereka:
- Menampilkan pesan error yang jelas
- Menyediakan tombol untuk kembali ke dashboard yang sesuai dengan role user
- Design yang konsisten dengan error page lainnya (404, 500, dll)

## File yang Dimodifikasi

### 1. bootstrap/app.php
**Perubahan:** Registrasi middleware alias

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'member' => \App\Http\Middleware\MemberMiddleware::class,
    ]);
})
```

### 2. routes/web.php
**Perubahan:** Penambahan middleware pada route groups

#### Route Member (Baris ~92)
```php
// Sebelum
Route::prefix('member')->name('member.')->middleware('auth')->group(function () {

// Sesudah
Route::prefix('member')->name('member.')->middleware(['auth', 'member'])->group(function () {
```

#### Route Admin (Baris ~161)
```php
// Sebelum
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

// Sesudah
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
```

## Cara Kerja

### Skenario 1: Member mencoba akses halaman Admin
1. User login sebagai member dengan role `member`
2. User mengubah URL menjadi `http://127.0.0.1:8000/admin/dashboard`
3. Middleware `AdminMiddleware` dijalankan
4. Middleware memeriksa: `auth()->user()->isAdmin()` → return `false`
5. Sistem menolak akses dengan `abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.')`
6. User melihat halaman error 403 dengan tombol kembali ke dashboard member

### Skenario 2: Admin mencoba akses halaman Member
1. User login sebagai admin dengan role `admin`
2. User mengubah URL menjadi `http://127.0.0.1:8000/member/dashboard`
3. Middleware `MemberMiddleware` dijalankan
4. Middleware memeriksa: `auth()->user()->isMember()` → return `false`
5. Sistem menolak akses dengan `abort(403, 'Akses ditolak. Halaman ini hanya untuk Member.')`
6. User melihat halaman error 403 dengan tombol kembali ke dashboard admin

## Testing

### Test 1: Login sebagai Member
1. Login ke sistem sebagai member
2. Akses: `http://127.0.0.1:8000/member/dashboard` → ✅ Berhasil
3. Ubah URL ke: `http://127.0.0.1:8000/admin/dashboard` → ❌ Error 403

### Test 2: Login sebagai Admin
1. Login ke sistem sebagai admin
2. Akses: `http://127.0.0.1:8000/admin/dashboard` → ✅ Berhasil
3. Ubah URL ke: `http://127.0.0.1:8000/member/dashboard` → ❌ Error 403

### Test 3: Belum Login
1. Akses: `http://127.0.0.1:8000/member/dashboard` → Redirect ke login member
2. Akses: `http://127.0.0.1:8000/admin/dashboard` → Redirect ke login

## Keamanan yang Diterapkan

1. **Role-Based Access Control (RBAC)**
   - Setiap route dilindungi berdasarkan role user
   - Menggunakan method `isAdmin()` dan `isMember()` dari model User

2. **Middleware Protection**
   - Middleware dijalankan sebelum controller
   - Tidak ada kemungkinan bypass melalui URL manipulation

3. **Graceful Error Handling**
   - Error 403 yang informatif
   - Pengguna diarahkan ke dashboard yang sesuai

4. **Authentication Check**
   - Middleware memeriksa status login terlebih dahulu
   - User yang belum login akan di-redirect ke halaman login

## Maintenance

### Menambahkan Route Baru untuk Admin
```php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Route baru akan otomatis terproteksi
    Route::get('/new-page', [Controller::class, 'method'])->name('new-page');
});
```

### Menambahkan Route Baru untuk Member
```php
Route::prefix('member')->name('member.')->middleware(['auth', 'member'])->group(function () {
    // Route baru akan otomatis terproteksi
    Route::get('/new-page', [Controller::class, 'method'])->name('new-page');
});
```

## Command yang Dijalankan

Setelah perubahan, jalankan:
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

## Catatan Penting

- ✅ Middleware sudah terdaftar dan aktif
- ✅ Semua route admin dan member sudah terproteksi
- ✅ Halaman error 403 sudah dibuat dengan design yang baik
- ✅ Cache sudah dibersihkan

## Tanggal Implementasi
18 Desember 2025
