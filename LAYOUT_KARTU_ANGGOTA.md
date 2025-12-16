# Layout Kartu Anggota

Layout kartu anggota telah disesuaikan dengan format ISET seperti screenshot.

## Posisi Elemen

### Foto Member
- **Posisi**: Kiri bawah header
- **Koordinat**: X: 33px, Y: 217px
- **Ukuran**: 180px x 215px
- **Placeholder**: Background abu-abu dengan text "NO PHOTO" jika belum upload foto

### Teks Data Member
- **Posisi**: Kanan foto
- **Koordinat Awal**: X: 260px, Y: 240px
- **Line Spacing**: 32px antar baris
- **Font Size**: 11px
- **Format**: `label : value`

**Urutan Data:**
1. KARTU TANDA ANGGOTA (header, biru, size 16)
2. No.Anggota : APJ20250001
3. nama : Eko Siswanto
4. Institusi : Universitas Gunadarma
5. Kontak : 085640283
6. Alamat : Jl. Sarang Bango
7. Berlaku : 13 Nov 2025 - 13 Nov 2026
8. Disahkan : 13 Nov 2025

### QR Code
- **Posisi**: Kanan bawah
- **Ukuran**: 80px x 80px
- **Margin**: 40px dari kanan, 60px dari bawah
- **Label**: "Ketua" (di bawah QR)

### Footer
- **Posisi**: Kiri bawah
- **Font Size**: 8px
- **Teks**: 3 bullets tentang ketentuan kartu

## Template Image
- Template harus berukuran sekitar **850x535px** (landscape)
- Header biru dengan logo ISET sudah ada di template
- Background putih/abu-abu terang

## Cara Generate
1. Login sebagai Admin
2. Buka menu **Keanggotaan → Anggota**
3. Klik nama member
4. Klik tombol **"Generate Kartu"**
5. Kartu akan otomatis di-generate dengan layout ISET

## Catatan
- Foto member diambil dari field `photo` di tabel members
- Jika belum upload foto, akan muncul placeholder abu-abu
- QR Code link ke homepage (bisa custom ke verification page)
- Semua text menggunakan font default GD (tidak perlu install font)
