# Sistem Label Section Dinamis

## Fitur
✅ Label/judul section dapat diubah dari dashboard admin  
✅ Tidak perlu edit kode untuk mengubah teks  
✅ Mudah menambah section baru  
✅ Mendukung subtitle (optional)  
✅ Dukungan dark mode  
✅ Alignment yang fleksibel (left/center)  

## Cara Menggunakan di View

### 1. Penggunaan Dasar
```blade
<x-section-heading 
    setting-key="section_label_about" 
    title="Tentang APJIKOM"
/>
```

### 2. Dengan Subtitle
```blade
<x-section-heading 
    setting-key="section_label_partners" 
    title="Partner Kami"
    subtitle="Dipercaya oleh berbagai institusi terkemuka"
/>
```

### 3. Alignment Center
```blade
<x-section-heading 
    setting-key="section_label_benefits" 
    title="Keuntungan Menjadi Anggota"
    align="center"
/>
```

### 4. Dark Mode
```blade
<x-section-heading 
    setting-key="section_label_cta" 
    title="Mari Bergabung"
    align="center"
    :dark-mode="true"
/>
```

## Cara Menambah Section Baru

### 1. Tambahkan di Seeder
Edit file: `database/seeders/SectionLabelsSeeder.php`

```php
[
    'key' => 'section_label_nama_section',
    'value' => 'Judul Section Anda',
    'type' => 'text',
    'group' => 'section_labels',
    'description' => 'Deskripsi section'
],
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=SectionLabelsSeeder
```

### 3. Gunakan di View
```blade
<x-section-heading 
    setting-key="section_label_nama_section" 
    title="Default Title"
/>
```

## Kelola dari Admin

1. Login ke dashboard admin
2. Buka menu **Label Section**
3. Edit semua label sekaligus
4. Klik **Simpan Semua Perubahan**

URL: `http://127.0.0.1:8000/admin/section-labels`

## Parameter Component

| Parameter | Tipe | Default | Deskripsi |
|-----------|------|---------|-----------|
| `setting-key` | string | null | Key setting dari database |
| `title` | string | null | Default title jika setting tidak ada |
| `subtitle` | string | null | Subtitle (opsional) |
| `align` | string | 'left' | Alignment: 'left' atau 'center' |
| `dark-mode` | boolean | false | Aktifkan mode gelap |

## Contoh Section yang Sudah Ada

- `section_label_about` - Tentang APJIKOM
- `section_label_benefits` - Keuntungan Menjadi Anggota
- `section_label_partners` - Partner Kami
- `section_label_partners_subtitle` - Subtitle Partner
- `section_label_cta` - Call to Action
- `section_label_latest_news` - Berita Terbaru
- `section_label_upcoming_events` - Event Mendatang
- `section_label_members` - Daftar Anggota
- `section_label_categories` - Kategori
- `section_label_registration` - Pendaftaran Anggota

## File yang Terlibat

```
app/
├── View/Components/
│   └── SectionHeading.php          # Component logic
├── Http/Controllers/Admin/
│   └── SectionLabelController.php  # Admin controller
resources/views/
├── components/
│   └── section-heading.blade.php   # Component view
├── admin/section-labels/
│   └── index.blade.php              # Admin page
database/seeders/
└── SectionLabelsSeeder.php          # Initial data
routes/
└── web.php                          # Routes
```

## Tips

1. **Konsistensi Naming**: Gunakan format `section_label_*` untuk key
2. **Default Value**: Selalu berikan default title untuk fallback
3. **Subtitle Optional**: Gunakan suffix `_subtitle` untuk subtitle
4. **Testing**: Cek di frontend setelah mengubah label
5. **Backup**: Export settings sebelum perubahan besar

## Keuntungan Sistem Ini

✅ **Mudah Dikelola**: Admin bisa ubah teks tanpa bantuan developer  
✅ **Konsisten**: Semua label tersimpan terpusat di database  
✅ **Fleksibel**: Mudah menambah section baru kapan saja  
✅ **Maintainable**: Kode lebih bersih dan DRY  
✅ **Scalable**: Siap untuk growth aplikasi ke depan
