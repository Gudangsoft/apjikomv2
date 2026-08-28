# Desain Kartu Anggota APJIKOM

Mockup visual kartu tanda anggota APJIKOM, mengikuti tata letak kartu contoh
**tanpa chip ATM kuning / simbol contactless**.

## File

| File | Keterangan |
|------|------------|
| `kartu-anggota-apjikom.html` | Kartu berdiri sendiri (HTML + CSS + SVG, 1 file). Buka langsung di browser. Ukuran kartu 1200 × 757 px (rasio kartu ID standar). |

Canvas desain yang bisa diedit visual + ekspor PNG/PDF:
<https://claude.ai/code/artifact/7818ae12-0a80-47a3-b5b1-c6d38867750f>

## Elemen kartu

- Kiri: seal APJIKOM, wordmark, judul **KARTU TANDA ANGGOTA**, pill **ANGGOTA APJIKOM**,
  tagline, nomor **NO. KARTU E-TOOL**.
- Data: **NOMOR ANGGOTA**, **NAMA**, **JABATAN / PROFESI**, **BERLAKU S/D**,
  **NOMOR AHU**, **KANTOR SEKRETARIAT** (alamat, telepon, email).
- Kanan: blok **BANK PARTNER / BNI**, foto anggota, **QR + badge "TERDAFTAR RESMI"**.
- Footer ungu: website + media sosial.

## Yang masih placeholder (ganti dengan aset asli)

| Bagian | Kondisi sekarang |
|--------|------------------|
| Logo BNI | Kotak garis putus bertuliskan "LOGO" + teks "BNI". Logo resmi BNI tidak digambar ulang; sisipkan file logo BNI asli. |
| Seal APJIKOM | Rekonstruksi vektor. Bisa diganti PNG/SVG logo resmi. |
| Foto anggota | Siluet abu-abu. |
| QR code | Pola dekoratif via `<script>`, **bukan** QR yang bisa dipindai. |
| Data member | Memakai contoh (DANANG, APJIKOM.2025.000123, dst). |

## Ganti warna tema

Ubah nilai `--accent` (dan turunannya) di blok `:root` pada bagian atas
`kartu-anggota-apjikom.html`.

## Catatan integrasi

Ini baru mockup, **belum terhubung** ke `app/Services/MemberCardGenerator.php`
(yang saat ini menempelkan teks di atas gambar template via GD). Untuk memakai
desain ini dengan data member asli, langkah berikutnya adalah render HTML → PNG
(mis. Browsershot) atau menjadikannya template background baru.
