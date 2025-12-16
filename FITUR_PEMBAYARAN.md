# Fitur Baru: Pengaturan Pembayaran & Mode Pendaftaran

## 📋 Fitur yang Ditambahkan

### 1. Mode Pendaftaran (Registration Mode)
- **Berbayar (Paid)**: Pendaftaran memerlukan pembayaran sesuai biaya yang ditentukan
- **Gratis (Free)**: Pendaftaran tanpa biaya, cocok untuk periode promosi atau open registration

### 2. Upload Bukti Bayar
- **Wajib Upload**: Member harus mengupload bukti pembayaran saat mendaftar
- **Tidak Perlu Upload**: Bukti pembayaran bersifat opsional atau tidak ditampilkan

## 🚀 Cara Menggunakan

### Akses Pengaturan
1. Login sebagai admin di http://127.0.0.1:8000/login
   - Email: admin@apjikom.or.id
   - Password: password

2. Buka halaman Settings di http://127.0.0.1:8000/admin/settings

3. Scroll ke bagian **"Pengaturan Pembayaran & Keanggotaan"**

### Mengubah Mode Pendaftaran

#### Untuk Mode GRATIS:
1. Pilih **"🆓 Gratis (Free)"** pada dropdown "Jenis Pendaftaran"
2. Biaya akan otomatis di-set ke Rp 0
3. Form pendaftaran akan menampilkan badge "GRATIS" dengan background hijau
4. Informasi transfer bank akan disembunyikan

#### Untuk Mode BERBAYAR:
1. Pilih **"💳 Berbayar (Paid)"** pada dropdown "Jenis Pendaftaran"
2. Atur biaya untuk:
   - Biaya Individu (default: Rp 250.000)
   - Biaya Program Studi (default: Rp 750.000)
3. Form pendaftaran akan menampilkan informasi biaya dan rekening bank

### Mengatur Upload Bukti Bayar

#### Wajib Upload:
1. Pilih **"✅ Wajib Upload"** pada dropdown "Upload Bukti Bayar"
2. Field upload akan muncul di form pendaftaran dengan tanda bintang merah (*)
3. Member HARUS mengupload bukti pembayaran

#### Tidak Perlu Upload:
1. Pilih **"❌ Tidak Perlu Upload"** pada dropdown "Upload Bukti Bayar"
2. Field upload bukti bayar tidak akan ditampilkan di form pendaftaran
3. Proses pendaftaran lebih cepat tanpa verifikasi pembayaran

## 💡 Kombinasi Pengaturan

### Skenario 1: Pendaftaran Gratis Tanpa Bukti Bayar
- Mode: Free
- Upload: Tidak Perlu Upload
- **Hasil**: Pendaftaran sangat mudah, hanya isi data diri tanpa pembayaran

### Skenario 2: Pendaftaran Gratis Dengan Bukti Bayar (Opsional)
- Mode: Free
- Upload: Wajib Upload
- **Hasil**: Pendaftaran gratis, tapi masih bisa upload dokumen jika diperlukan (opsional)

### Skenario 3: Pendaftaran Berbayar Tanpa Bukti Bayar
- Mode: Paid
- Upload: Tidak Perlu Upload
- **Hasil**: Menampilkan biaya & rekening, tapi tidak perlu upload bukti (verifikasi manual)

### Skenario 4: Pendaftaran Berbayar Dengan Bukti Bayar (DEFAULT)
- Mode: Paid
- Upload: Wajib Upload
- **Hasil**: Standar - tampilkan biaya, rekening, dan WAJIB upload bukti pembayaran

## 🔧 Instalasi Setting Database

Jalankan salah satu cara berikut untuk menambahkan setting ke database:

### Cara 1: Via Tinker (Recommended)
```bash
php artisan tinker
```
Lalu paste kode berikut:
```php
App\Models\Setting::updateOrCreate(
    ['key' => 'registration_mode', 'group' => 'payment'],
    ['value' => 'paid', 'type' => 'text']
);

App\Models\Setting::updateOrCreate(
    ['key' => 'require_payment_proof', 'group' => 'payment'],
    ['value' => '1', 'type' => 'boolean']
);
```

### Cara 2: Via Migration
```bash
php artisan migrate
```

### Cara 3: Manual SQL
Jalankan file `insert_payment_mode_settings.sql` di database Anda

## 📁 File yang Diubah

1. ✅ `resources/views/admin/settings/index.blade.php` - Tambah form setting
2. ✅ `app/Http/Controllers/Admin/SettingController.php` - Update validasi & save
3. ✅ `resources/views/registration/create.blade.php` - Conditional display
4. ✅ `app/Http/Controllers/RegistrationController.php` - Dynamic validation
5. ✅ `database/migrations/2025_11_12_155820_add_registration_mode_and_payment_proof_to_settings.php` - Migration

## 🎨 Tampilan UI

### Admin Settings:
- Section baru dengan background amber (kuning)
- Dropdown dengan emoji untuk UX yang lebih baik
- JavaScript auto-hide biaya saat mode Free dipilih

### Form Pendaftaran:
- Badge "GRATIS" hijau atau biaya dengan background ungu
- Informasi bank hanya tampil di mode Paid
- Upload bukti bayar conditional

## ⚠️ Catatan Penting

1. **Default Setting**: 
   - Mode: Paid (berbayar)
   - Upload: Wajib (required)

2. **Perubahan Real-time**: 
   - Saat admin ubah setting, langsung berlaku di form pendaftaran
   - Tidak perlu restart server atau clear cache

3. **Validasi**: 
   - Mode Free + Upload Required = upload opsional (tidak error jika kosong)
   - Mode Paid + Upload Required = upload wajib (error jika kosong)

4. **Backward Compatibility**: 
   - Semua data pendaftaran lama tetap valid
   - Migration bisa dijalankan kapan saja

## 🚀 Testing

1. Buka halaman settings: http://127.0.0.1:8000/admin/settings
2. Ubah mode ke "Free" dan "Tidak Perlu Upload"
3. Klik "Simpan Pengaturan"
4. Buka form pendaftaran: http://127.0.0.1:8000/daftar-anggota
5. Verifikasi tampilan berubah (badge gratis, tanpa upload field)
6. Coba daftar tanpa upload bukti bayar
7. Seharusnya berhasil! ✅

---

**Dibuat oleh**: GitHub Copilot  
**Tanggal**: 12 November 2025  
**Versi Laravel**: 11.x
