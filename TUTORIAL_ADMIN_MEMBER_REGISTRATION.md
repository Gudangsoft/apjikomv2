# Tutorial Admin: Mengelola Pendaftaran & Member

## Daftar Isi
1. [Alur Proses Keanggotaan](#alur-proses-keanggotaan)
2. [Mengelola Pendaftaran](#mengelola-pendaftaran)
3. [Mengelola Member](#mengelola-member)
4. [FAQ & Tips](#faq--tips)

---

## Alur Proses Keanggotaan

```
┌─────────────────┐
│  User Daftar    │
│  (Public Form)  │
└────────┬────────┘
         │
         ▼
┌─────────────────────┐
│  Status: PENDING    │ ◄── Masuk ke /admin/registrations
│  (Menunggu Review)  │
└────────┬────────────┘
         │
         ├──► Admin Review & Verifikasi Data
         │
         ▼
    ┌────────┐
    │ Approve│ atau │ Reject │
    └───┬────┘      └───┬────┘
        │               │
        ▼               ▼
┌─────────────┐   ┌──────────────┐
│ Member      │   │ Registration │
│ (ACTIVE)    │   │ (REJECTED)   │
│             │   │              │
│ Masuk ke    │   │ Tetap di     │
│ /admin/     │   │ /admin/      │
│ members     │   │ registrations│
└─────────────┘   └──────────────┘
```

---

## Mengelola Pendaftaran

### 🔗 URL: `/admin/registrations`

### Tujuan
Halaman ini untuk **mereview dan memproses pendaftaran baru** yang masuk dari publik.

### Fitur Utama

#### 1. **Filter & Pencarian**
- **Pencarian**: Cari berdasarkan nama pendaftar
- **Filter Status**:
  - `PENDING` - Pendaftaran baru yang menunggu review
  - `APPROVED` - Sudah disetujui (otomatis menjadi member)
  - `REJECTED` - Ditolak

#### 2. **Tabel Pendaftaran**
Kolom yang ditampilkan:
- **Nama** - Nama lengkap pendaftar
- **Email** - Email pendaftar
- **Institusi** - Nama instansi/organisasi
- **Tanggal Daftar** - Waktu pengajuan
- **Status** - Status pendaftaran (badge berwarna)
- **Aksi** - Tombol untuk melihat detail

#### 3. **Detail Pendaftaran**
Klik tombol **👁️ Lihat** untuk melihat semua data:
- Data Pribadi (nama, email, telepon, alamat)
- Data Institusi (nama, alamat, website)
- Data Jurnal (jika ada)
- Dokumen pendukung (jika ada)
- Motivasi bergabung

#### 4. **Approve Pendaftaran**

**Langkah-langkah:**

1. Klik tombol **👁️ Lihat** pada pendaftaran dengan status `PENDING`
2. Review semua data yang diinput:
   - ✅ Pastikan data lengkap dan valid
   - ✅ Cek email tidak duplikat
   - ✅ Verifikasi institusi legitimate
   - ✅ Periksa dokumen pendukung (jika ada)
3. Klik tombol **✅ Approve** (hijau) di bagian bawah
4. Konfirmasi approval

**Apa yang Terjadi Setelah Approve:**
- Status berubah dari `PENDING` → `APPROVED`
- ✨ **Otomatis membuat record Member baru** dengan status `ACTIVE`
- Member baru muncul di `/admin/members`
- Email notifikasi dikirim ke pendaftar (jika sudah dikonfigurasi)

#### 5. **Reject Pendaftaran**

**Langkah-langkah:**

1. Klik tombol **👁️ Lihat** pada pendaftaran
2. Review data dan tentukan alasan penolakan
3. Klik tombol **❌ Reject** (merah) di bagian bawah
4. **(Opsional)** Masukkan alasan penolakan
5. Konfirmasi rejection

**Apa yang Terjadi Setelah Reject:**
- Status berubah menjadi `REJECTED`
- Pendaftaran tetap ada di database untuk arsip
- TIDAK membuat member baru
- Notifikasi penolakan (jika sudah dikonfigurasi)

#### 6. **Statistik Dashboard**
Di bagian atas halaman terdapat card statistik:
- 📊 **Total Pendaftaran**
- ⏳ **Menunggu Review** (PENDING)
- ✅ **Disetujui** (APPROVED)
- ❌ **Ditolak** (REJECTED)

---

## Mengelola Member

### 🔗 URL: `/admin/members`

### Tujuan
Halaman ini untuk **mengelola member yang sudah aktif** (sudah di-approve).

### Fitur Utama

#### 1. **Filter & Pencarian**
- **Pencarian**: Cari berdasarkan nama member
- **Filter Status**:
  - `ACTIVE` - Member aktif (bisa akses sistem)
  - `INACTIVE` - Member non-aktif (tidak bisa login)
  - `PENDING` - Member yang sedang dalam proses (jarang digunakan)

> **Catatan**: Filter "Type Member" sudah dihapus karena tidak digunakan.

#### 2. **Tabel Member**
Kolom yang ditampilkan:
- **Nama** - Nama lengkap member
- **Email** - Email member (untuk login)
- **No. Anggota** - Nomor anggota unik (auto-generated)
- **Institusi** - Nama instansi
- **Status** - Status keanggotaan
- **Tanggal Bergabung** - Tanggal pertama kali menjadi member
- **Aksi** - Tombol aksi (lihat, edit, hapus)

#### 3. **Detail Member**
Klik tombol **👁️ Lihat** untuk melihat:
- Profil lengkap member
- History aktivitas
- Data institusi
- Kartu anggota digital
- Log perubahan data

#### 4. **Edit Member**

**Langkah-langkah:**

1. Klik tombol **✏️ Edit**
2. Ubah data yang diperlukan:
   - Data pribadi (nama, email, telepon, alamat)
   - Data institusi
   - Status keanggotaan (ACTIVE/INACTIVE)
3. Klik **Simpan Perubahan**

**Perubahan Status:**
- `ACTIVE` → `INACTIVE`: Member tidak bisa login lagi
- `INACTIVE` → `ACTIVE`: Member bisa login kembali

#### 5. **Hapus Member**

⚠️ **HATI-HATI**: Menghapus member bersifat permanen!

**Kapan Boleh Hapus:**
- Member duplikat
- Data testing
- Permintaan member untuk dihapus

**Langkah-langkah:**
1. Klik tombol **🗑️ Hapus** (merah)
2. Konfirmasi penghapusan
3. Member terhapus dari database

#### 6. **Export Data**
Klik tombol **📥 Export** untuk download data member dalam format:
- Excel (.xlsx)
- CSV (.csv)
- PDF (untuk printing)

#### 7. **Statistik Dashboard**
Card statistik menampilkan:
- 👥 **Total Member**
- ✅ **Member Aktif**
- ❌ **Member Tidak Aktif**

---

## FAQ & Tips

### ❓ Pertanyaan Umum

**Q: Apa bedanya Registrations dan Members?**
- **Registrations**: Pendaftaran yang masih dalam proses review (calon member)
- **Members**: Member yang sudah di-approve dan bisa akses sistem

**Q: Bisakah member kembali jadi registration?**
- Tidak. Sekali menjadi member, tidak bisa mundur ke registration.
- Tapi bisa ubah status member jadi INACTIVE.

**Q: Apa yang terjadi jika reject registration?**
- Registration tetap ada dengan status REJECTED
- TIDAK membuat member
- User bisa mendaftar ulang dengan email berbeda

**Q: Bagaimana jika ada data member yang salah?**
- Bisa diedit lewat `/admin/members` dengan klik tombol Edit
- Atau minta member update sendiri lewat dashboard member

**Q: Apakah bisa approve/reject banyak registration sekaligus?**
- Saat ini harus satu-persatu
- Fitur bulk action bisa ditambahkan di masa depan

**Q: Member yang di-INACTIVE apakah datanya hilang?**
- Tidak, data tetap tersimpan
- Hanya tidak bisa login
- Bisa diaktifkan kembali kapan saja

### 💡 Tips & Best Practices

#### Untuk Mengelola Registrations:

1. **Review Rutin**
   - Cek pendaftaran baru minimal 2x seminggu
   - Jangan biarkan pendaftaran pending terlalu lama

2. **Verifikasi Data**
   - Pastikan email valid dan tidak duplikat
   - Cek institusi benar-benar ada
   - Verifikasi nomor telepon jika perlu

3. **Komunikasi**
   - Jika data kurang lengkap, hubungi pendaftar
   - Berikan alasan jelas saat reject

4. **Dokumentasi**
   - Catat alasan rejection untuk tracking
   - Simpan catatan khusus jika ada kasus special

#### Untuk Mengelola Members:

1. **Monitoring Status**
   - Review member INACTIVE secara berkala
   - Tanya alasan inactive dan tawarkan bantuan

2. **Update Data**
   - Minta member update data jika ada perubahan
   - Verifikasi data penting (email, institusi) secara berkala

3. **Backup Data**
   - Export data member secara rutin untuk backup
   - Simpan di tempat aman

4. **Keamanan**
   - Jangan bagikan data member ke pihak ketiga
   - Pastikan hanya admin yang berwenang yang akses

### 🔧 Troubleshooting

**Problem: Pencarian tidak menemukan member**
- ✅ Pastikan ejaan nama benar
- ✅ Coba cari dengan email atau nomor anggota
- ✅ Cek filter status yang aktif

**Problem: Tidak bisa approve registration**
- ✅ Pastikan status masih PENDING
- ✅ Cek email tidak duplikat dengan member existing
- ✅ Clear cache browser dan coba lagi

**Problem: Member tidak bisa login setelah approved**
- ✅ Cek status member sudah ACTIVE
- ✅ Verifikasi email benar
- ✅ Pastikan password sudah diset (cek email welcome)

**Problem: Data statistik tidak update**
- ✅ Refresh halaman (Ctrl + F5)
- ✅ Clear cache aplikasi: `php artisan cache:clear`
- ✅ Clear view cache: `php artisan view:clear`

---

## 📞 Butuh Bantuan?

Jika mengalami masalah atau butuh fitur tambahan, hubungi:
- **Developer**: [Email/Contact Developer]
- **Dokumentasi Teknis**: Lihat file README.md
- **Log Sistem**: Check di `storage/logs/laravel.log`

---

**Terakhir Diupdate**: 17 Desember 2025
**Versi**: 1.0
