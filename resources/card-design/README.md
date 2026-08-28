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

## Status integrasi

Desain ini **sudah dipakai di aplikasi** sebagai kartu HTML (live), bukan lagi
gambar PNG hasil `MemberCardGenerator`:

| Lokasi | File |
|--------|------|
| Partial kartu (data member asli) | `resources/views/member/partials/kartu-anggota.blade.php` |
| Halaman kartu member | `resources/views/member/card.blade.php` — `@include` partial |
| Detail member (admin) | `resources/views/admin/members/show.blade.php` — `@include` partial |

- Unduh = tombol **Cetak / Simpan PDF** (`window.print()`), bukan download PNG.
- Data member: `member_number` (nomor besar di tengah + tidak diulang di kolom),
  `user->name`, `position` (Jabatan / Profesi), `institution_name` (Institusi),
  `address` / fallback `city, province` (Alamat), `expiry_date` (Berlaku,
  default "Seumur Hidup"), `photo`.
- Teks tetap (AHU, alamat sekretariat, telp, email, label sosmed) via `setting()`
  — key: `org_ahu_number`, `contact_address`, `contact_phone`, `contact_email`,
  `card_website_label`, `card_facebook_label`, `card_instagram_label`,
  `card_youtube_label`.
- QR asli via paket `simplesoftwareio/simple-qrcode` → halaman
  `/verifikasi-anggota/{id}`. **Server perlu `composer install`** setelah pull;
  tanpa itu QR otomatis fallback ke pola hiasan (tidak error).

### Mode template (gambar background dari admin)

Kalau ada **MemberCardTemplate aktif**, kartu memakai gambar itu sebagai latar
dan hanya menimpakan konten member di **area kosong** template: judul, pill,
tagline, nomor anggota, data (nama/jabatan/institusi/alamat/berlaku), Nomor AHU,
Kantor Sekretariat, foto, QR + "Terdaftar Resmi". Seal, wordmark, BANK PARTNER,
footer, ornamen diambil dari gambar template.

Atur posisi area lewat `setting()` (semua PERSEN terhadap kartu):

| Key | Default | Fungsi |
|-----|---------|--------|
| `card_ov_area_top` | 31 | batas atas area kosong |
| `card_ov_area_bottom` | 9 | ruang untuk footer template |
| `card_ov_area_left` / `card_ov_area_right` | 5 / 3.5 | margin kiri / kanan |
| `card_ov_photo_w` | 21 | lebar foto (% lebar kartu) |
| `card_ov_qr_w` | 12 | lebar QR (% lebar kartu) |
| `card_ov_font_scale` | 100 | skala semua font overlay (%) |
| `card_ov_text_color` / `card_ov_label_color` | `#20232e` / `#5a2d8f` | warna nilai / label |
| `card_ov_show_qr` | `1` | `0` untuk sembunyikan QR |

### Masih placeholder / belum

- QR pakai `simple-qrcode` (server perlu `composer install`); fallback pola hias.
- Thumbnail kartu di `member/dashboard.blade.php` & daftar member admin masih
  gambar lama; `MemberCardGenerator` (GD) juga masih ada.
