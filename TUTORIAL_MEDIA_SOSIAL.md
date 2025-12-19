# Tutorial Penggunaan Fitur Media Sosial

## Langkah-langkah untuk Admin

### 1. Mengakses Menu Media Sosial

1. Login sebagai admin di dashboard admin
2. Klik menu **Pengaturan** di sidebar kiri
3. Klik submenu **Media Sosial**

### 2. Halaman Daftar Media Sosial

Pada halaman ini Anda akan melihat:
- Tabel daftar media sosial yang sudah ada
- Kolom: Urutan, Icon, Nama Platform, URL, Note, Status, Aksi
- Tombol **Tambah Media Sosial** di kanan atas

**Fitur Drag & Drop:**
- Klik dan tahan icon grip (⋮⋮) di kolom "Urutan"
- Drag baris ke posisi yang diinginkan
- Lepaskan untuk menyimpan urutan baru
- Urutan akan tersimpan otomatis tanpa reload

### 3. Menambah Media Sosial Baru

#### Klik Tombol "Tambah Media Sosial"

Form yang akan muncul:

**A. Nama Platform** (Wajib)
   - Contoh: Facebook, Instagram, Twitter, LinkedIn
   - Max 255 karakter

**B. URL** (Wajib)
   - Format lengkap dengan protocol
   - Contoh: `https://facebook.com/apjikom`
   - Validasi: Harus URL valid

**C. Icon/Logo** (Pilih salah satu)
   
   **Opsi 1: Upload Icon**
   - Klik "Choose File" di kolom "Upload Icon"
   - Pilih file gambar (PNG, JPG, JPEG, SVG)
   - Maksimal ukuran: 2MB
   - Recommended: Icon persegi 512x512px
   
   **Opsi 2: Icon Class**
   - Isi field "Icon Class"
   - Gunakan class Font Awesome
   - Contoh:
     - `fab fa-facebook` untuk Facebook
     - `fab fa-instagram` untuk Instagram
     - `fab fa-twitter` untuk Twitter
     - `fab fa-linkedin` untuk LinkedIn
     - `fab fa-youtube` untuk YouTube
     - `fab fa-tiktok` untuk TikTok

**D. Note/Keterangan** (Opsional)
   - Keterangan tambahan tentang media sosial
   - Akan muncul sebagai tooltip di dashboard member
   - Contoh: "Halaman resmi Facebook APJIKOM"

**E. Urutan** (Wajib)
   - Angka untuk menentukan urutan tampilan
   - Semakin kecil angka, semakin awal ditampilkan
   - Contoh: 0, 1, 2, 3, ...
   - Bisa diubah dengan drag & drop setelah disimpan

**F. Status Aktif** (Checkbox)
   - Centang untuk menampilkan di dashboard member
   - Tidak dicentang = tidak akan muncul

#### Klik Tombol "Simpan"

### 4. Mengedit Media Sosial

1. Pada halaman daftar, klik tombol **Edit** (icon pensil kuning)
2. Form edit akan muncul dengan data yang sudah ada
3. Jika ada icon/logo sebelumnya, akan ditampilkan preview
4. Ubah data yang diperlukan
5. Klik **Update** untuk menyimpan perubahan

**Note:** 
- Jika upload icon baru, icon lama akan otomatis terhapus
- Bisa mengubah dari upload icon ke icon class atau sebaliknya

### 5. Menghapus Media Sosial

1. Pada halaman daftar, klik tombol **Hapus** (icon trash merah)
2. Konfirmasi dialog akan muncul: "Yakin ingin menghapus media sosial ini?"
3. Klik **OK** untuk menghapus
4. File icon (jika ada) akan otomatis terhapus dari storage

### 6. Mengaktifkan/Menonaktifkan

Untuk menonaktifkan tanpa menghapus:
1. Klik tombol **Edit** pada media sosial yang ingin dinonaktifkan
2. Hilangkan centang pada checkbox "Aktif"
3. Klik **Update**
4. Media sosial tidak akan muncul di dashboard member, tapi data tetap tersimpan

## Tampilan di Dashboard Member

### Untuk Member/Anggota

Setelah admin menambahkan media sosial:

1. Login sebagai member
2. Buka halaman **Dashboard Member**
3. Scroll ke bawah hingga menemukan section **"Ikuti Kami di Media Sosial"**

### Tampilan Section Media Sosial:

- **Grid Layout**: Responsive 2-3-6 kolom (mobile-tablet-desktop)
- **Card Design**: Setiap platform dalam card terpisah
- **Hover Effect**: Animasi scale dan perubahan warna saat di-hover
- **Icon/Logo**: Ditampilkan di tengah card
- **Nama Platform**: Di bawah icon dengan font bold
- **Note**: Muncul sebagai tooltip saat hover (jika ada)

### Interaksi:

- Klik pada card untuk membuka link media sosial
- Link akan terbuka di tab baru
- Smooth transition dan animasi

## Tips & Best Practices

### Untuk Admin:

1. **Gunakan Icon Konsisten**
   - Pilih satu metode: semua upload atau semua icon class
   - Recommended: Icon class untuk kemudahan maintenance

2. **URL yang Benar**
   - Gunakan URL page/profil resmi organisasi
   - Pastikan URL aktif dan tidak broken
   - Contoh: `https://facebook.com/apjikom` bukan `/apjikom`

3. **Urutan yang Logis**
   - Urutkan berdasarkan popularitas atau prioritas
   - Contoh: Facebook (0), Instagram (1), Twitter (2), dst.

4. **Note yang Informatif**
   - Singkat dan jelas (max 40 karakter untuk tampilan optimal)
   - Contoh: "Halaman resmi Facebook" atau "Follow untuk update terbaru"

5. **Status Aktif**
   - Hanya aktifkan media sosial yang benar-benar digunakan
   - Nonaktifkan yang sudah tidak terpakai

### Untuk Upload Icon:

1. **Ukuran Icon**
   - Recommended: 512x512px atau 1024x1024px
   - Format persegi untuk hasil terbaik

2. **Format File**
   - PNG dengan background transparan (recommended)
   - SVG untuk scalability terbaik
   - JPG jika diperlukan (dengan background solid)

3. **Ukuran File**
   - Keep under 500KB untuk performa optimal
   - Maksimal system: 2MB

4. **Warna**
   - Gunakan logo official dari brand media sosial
   - Atau gunakan brand color yang konsisten

## Troubleshooting

### Icon Tidak Muncul di Dashboard Member

**Solusi:**
1. Cek status "Aktif" di admin panel
2. Clear browser cache (Ctrl+F5)
3. Pastikan data tidak kosong: Buka Tinker dan jalankan:
   ```php
   App\Models\SocialMedia::active()->get();
   ```

### Upload Icon Gagal

**Penyebab & Solusi:**
- File terlalu besar → Compress file ke < 2MB
- Format tidak didukung → Gunakan PNG/JPG/JPEG/SVG
- Permission storage → Jalankan `php artisan storage:link`

### Icon Class Tidak Muncul

**Solusi:**
1. Pastikan Font Awesome ter-load di halaman
2. Cek class name (harus valid Font Awesome class)
3. Gunakan prefix yang benar: `fab` (brands), `fas` (solid), `far` (regular)

### Drag & Drop Tidak Berfungsi

**Solusi:**
1. Refresh halaman (F5)
2. Clear browser cache
3. Cek browser console untuk JavaScript errors
4. Pastikan SortableJS library ter-load

## Contoh Data Default (dari Seeder)

Setelah menjalankan seeder, akan ada 6 data default:

| No | Platform  | URL                              | Icon Class        | Status  |
|----|-----------|----------------------------------|-------------------|---------|
| 1  | Facebook  | https://facebook.com/apjikom     | fab fa-facebook   | Aktif   |
| 2  | Instagram | https://instagram.com/apjikom    | fab fa-instagram  | Aktif   |
| 3  | Twitter   | https://twitter.com/apjikom      | fab fa-twitter    | Aktif   |
| 4  | YouTube   | https://youtube.com/@apjikom     | fab fa-youtube    | Aktif   |
| 5  | LinkedIn  | https://linkedin.com/company/apjikom | fab fa-linkedin | Aktif   |
| 6  | TikTok    | https://tiktok.com/@apjikom      | fab fa-tiktok     | Nonaktif|

**Catatan:** URL-url di atas adalah contoh. Ganti dengan URL resmi organisasi Anda.

## Referensi Font Awesome Icons

Kunjungi: https://fontawesome.com/icons?d=gallery&s=brands

Icon yang umum digunakan:
- Facebook: `fab fa-facebook`
- Instagram: `fab fa-instagram`
- Twitter/X: `fab fa-twitter` atau `fab fa-x-twitter`
- LinkedIn: `fab fa-linkedin`
- YouTube: `fab fa-youtube`
- TikTok: `fab fa-tiktok`
- WhatsApp: `fab fa-whatsapp`
- Telegram: `fab fa-telegram`
- Discord: `fab fa-discord`
- GitHub: `fab fa-github`
- Reddit: `fab fa-reddit`
- Pinterest: `fab fa-pinterest`
- Snapchat: `fab fa-snapchat`
- Twitch: `fab fa-twitch`

## FAQ

**Q: Berapa jumlah maksimal media sosial yang bisa ditambahkan?**  
A: Tidak ada batasan. Namun recommended max 10-12 untuk tampilan optimal di dashboard.

**Q: Apakah bisa menggunakan platform media sosial custom?**  
A: Ya, Anda bisa menambahkan platform apapun dengan upload icon custom.

**Q: Bagaimana cara mengubah tampilan grid di dashboard member?**  
A: Edit file `resources/views/member/dashboard.blade.php` bagian social media grid.

**Q: Apakah bisa menambahkan analytics/tracking klik?**  
A: Belum tersedia di versi ini. Bisa ditambahkan di future enhancement.

**Q: Bagaimana cara backup data media sosial?**  
A: Export tabel `social_media` dari database, dan backup folder `storage/app/public/social-media-icons/`

---

**Catatan Akhir:**  
Fitur ini dirancang untuk memudahkan admin dalam mengelola link media sosial organisasi secara dinamis. Jika ada pertanyaan atau butuh bantuan, hubungi tim IT APJIKOM.

**Update:** 19 Desember 2025
