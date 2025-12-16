# Fitur Read More - About Section

## Deskripsi
Fitur Read More (Baca Selengkapnya) pada section About di halaman home memungkinkan pengguna untuk melihat deskripsi singkat terlebih dahulu, kemudian dapat memperluas untuk membaca teks lengkap.

## Cara Kerja

### 1. Deteksi Otomatis
- Sistem secara otomatis mendeteksi panjang teks deskripsi About
- Jika teks **lebih dari 200 karakter**, fitur Read More akan aktif
- Jika teks **200 karakter atau kurang**, teks ditampilkan secara penuh tanpa tombol Read More

### 2. Tampilan Default (Collapsed)
Ketika teks lebih dari 200 karakter:
- Menampilkan **200 karakter pertama** diikuti dengan "..."
- Tombol **"Baca Selengkapnya"** dengan ikon panah bawah
- Warna tombol: cyan (sesuai tema website)

### 3. Tampilan Expanded
Ketika tombol "Baca Selengkapnya" diklik:
- Menampilkan **teks lengkap** tanpa pemotongan
- Tombol berubah menjadi **"Tutup"** dengan ikon panah atas
- Pengguna dapat menutup kembali untuk kembali ke tampilan singkat

## Lokasi Kode

### File: `resources/views/home.blade.php`
**Baris 252-281**: Implementasi HTML dan logika PHP untuk read more

```php
@php
    $aboutText = $aboutDescription ?? 'Asosiasi yang mewadahi...';
    $textLength = mb_strlen($aboutText);
    $showReadMore = $textLength > 200;
@endphp

<div class="text-gray-600 text-base leading-relaxed mb-8">
    @if($showReadMore)
        <div id="about-description-short" class="about-text">
            {{ mb_substr($aboutText, 0, 200) }}...
            <button onclick="toggleReadMore()" class="text-cyan-600 hover:text-cyan-700 font-semibold ml-1 inline-flex items-center gap-1">
                Baca Selengkapnya
                <svg>...</svg>
            </button>
        </div>
        <div id="about-description-full" class="about-text hidden">
            {{ $aboutText }}
            <button onclick="toggleReadMore()" class="text-cyan-600 hover:text-cyan-700 font-semibold ml-1 inline-flex items-center gap-1">
                Tutup
                <svg>...</svg>
            </button>
        </div>
    @else
        <p>{{ $aboutText }}</p>
    @endif
</div>
```

**Baris 348-362**: JavaScript function untuk toggle

```javascript
function toggleReadMore() {
    const shortText = document.getElementById('about-description-short');
    const fullText = document.getElementById('about-description-full');
    
    if (shortText.classList.contains('hidden')) {
        shortText.classList.remove('hidden');
        fullText.classList.add('hidden');
    } else {
        shortText.classList.add('hidden');
        fullText.classList.remove('hidden');
    }
}
```

## Cara Menggunakan

### Untuk Admin
1. Login ke **Admin Panel**
2. Masuk ke menu **Pengaturan > About Settings**
3. Edit field **"Deskripsi Tentang APJIKOM"**
4. Masukkan teks deskripsi:
   - Jika teks **kurang dari 200 karakter**: Ditampilkan penuh tanpa read more
   - Jika teks **lebih dari 200 karakter**: Fitur read more otomatis aktif
5. Klik **Simpan**

### Untuk User/Visitor
1. Kunjungi halaman **Home** website
2. Scroll ke section **About/Tentang**
3. Jika teks panjang (>200 karakter):
   - Lihat preview 200 karakter pertama
   - Klik **"Baca Selengkapnya"** untuk melihat teks lengkap
   - Klik **"Tutup"** untuk kembali ke preview singkat
4. Jika teks pendek (≤200 karakter):
   - Teks ditampilkan langsung secara penuh

## Keunggulan Fitur

✅ **Otomatis**: Tidak perlu setting manual, sistem deteksi panjang teks otomatis  
✅ **User Friendly**: Interface yang jelas dengan ikon visual  
✅ **Responsive**: Bekerja di semua ukuran layar (desktop, tablet, mobile)  
✅ **Bahasa Indonesia**: Menggunakan label dalam Bahasa Indonesia  
✅ **Konsisten**: Styling mengikuti tema website (warna cyan)  
✅ **Smooth**: Transisi halus dengan JavaScript sederhana  

## Kustomisasi

### Mengubah Panjang Karakter Preview
Edit baris di `resources/views/home.blade.php`:

```php
// Default: 200 karakter
$showReadMore = $textLength > 200;

// Ubah menjadi 150 karakter:
$showReadMore = $textLength > 150;
```

```php
// Ubah panjang preview dari 200 ke 150:
{{ mb_substr($aboutText, 0, 150) }}...
```

### Mengubah Warna Tombol
Edit class CSS pada tombol:

```html
<!-- Warna default: cyan-600 -->
<button class="text-cyan-600 hover:text-cyan-700 ...">

<!-- Ubah ke purple: -->
<button class="text-purple-600 hover:text-purple-700 ...">
```

### Mengubah Label Tombol
Edit teks pada tombol:

```html
<!-- Default -->
Baca Selengkapnya
Tutup

<!-- Custom -->
Lihat Lebih Banyak
Sembunyikan
```

## Troubleshooting

### Tombol Tidak Berfungsi
**Penyebab**: JavaScript tidak ter-load  
**Solusi**: Pastikan script `toggleReadMore()` ada di bagian bawah file home.blade.php

### Teks Tidak Terpotong
**Penyebab**: Teks kurang dari 200 karakter  
**Solusi**: Ini perilaku normal. Fitur hanya aktif untuk teks >200 karakter

### Tampilan Berantakan
**Penyebab**: CSS class tidak terload  
**Solusi**: Clear cache browser atau pastikan Tailwind CSS aktif

## Technical Details

- **Framework**: Laravel 11
- **Frontend**: Blade Template + Tailwind CSS
- **JavaScript**: Vanilla JavaScript (no jQuery required)
- **Character Counting**: menggunakan `mb_strlen()` untuk support multibyte characters (Bahasa Indonesia)
- **Text Cutting**: menggunakan `mb_substr()` untuk memotong teks dengan aman

## Browser Support

✅ Chrome 90+  
✅ Firefox 88+  
✅ Safari 14+  
✅ Edge 90+  
✅ Opera 76+  

## Update Log

| Tanggal | Versi | Perubahan |
|---------|-------|-----------|
| 16 Dec 2025 | 1.0.0 | Initial release - Fitur read more pada About section |

## Kontributor

- **Implementasi**: GitHub Copilot
- **Testing**: APJIKOM Team

## Lisensi

Fitur ini adalah bagian dari sistem APJIKOM dan mengikuti lisensi yang sama dengan aplikasi utama.

---

**Catatan**: Fitur ini dapat dikembangkan lebih lanjut untuk diterapkan pada section lain yang memerlukan read more functionality (News, Events, dll).
