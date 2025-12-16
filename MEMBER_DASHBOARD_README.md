# Member Dashboard System - APJIKOM

## Overview
Sistem dashboard member yang terpisah dari admin dengan tampilan login yang modern dan UI yang user-friendly.

## Fitur yang Telah Dibuat

### 1. **Member Login Page** (`/member/login`)
- Tampilan login modern dengan split layout (gambar di kiri, form di kanan)
- Background gradient purple yang konsisten dengan tema APJIKOM
- Form login dengan validasi email dan password
- Link ke halaman registrasi
- Remember me functionality
- Responsive design untuk mobile dan desktop

### 2. **Member Dashboard** (`/member/dashboard`)
- Sambutan personal dengan nama member
- Card statistik:
  - Status keanggotaan (Aktif/Pending)
  - Masa berlaku kartu anggota dengan countdown hari
  - Status kartu anggota (Tersedia/Belum Ada)
- Preview kartu anggota (jika sudah dibuat)
- Informasi profil ringkas
- Quick action menu:
  - Edit Profil
  - Download Kartu
  - Lihat Berita
  - Lihat Event

### 3. **Member Profile Page** (`/member/profile`)
- Informasi lengkap anggota:
  - Nomor Anggota
  - Status Keanggotaan
  - Data Pribadi (Nama, Email, Kontak, Institusi, Alamat)
  - Tanggal Bergabung
  - Masa Berlaku Kartu
- Preview kartu anggota dengan tombol download
- Notifikasi jika kartu belum tersedia

### 4. **Member Card Page** (`/member/card`)
- Tampilan kartu anggota full size
- Informasi detail kartu
- Tombol download kartu (format PNG)
- Tombol cetak kartu
- Petunjuk penggunaan kartu
- Print-friendly layout (hide navigation saat print)

### 5. **Member Layout** (`layouts/member.blade.php`)
- Navbar dengan gradient purple
- Sidebar navigasi dengan menu:
  - Dashboard
  - Profil Saya
  - Kartu Anggota
  - Berita
  - Event
- User dropdown menu
- Alert notifications (success/error)
- Responsive design
- Alpine.js integration untuk interaktivitas

### 6. **Navigation Integration**
- Link "Login Member" di main navigation (untuk guest)
- Link "Dashboard" di main navigation (untuk logged-in member)
- Mobile menu support
- Conditional rendering berdasarkan auth status

## Routes

```php
// Guest (belum login)
GET  /member/login          -> Tampilkan form login
POST /member/login          -> Process login

// Authenticated (sudah login)
GET  /member/dashboard      -> Dashboard member
GET  /member/profile        -> Profil member
GET  /member/card           -> Kartu anggota

// Public
GET  /member/register       -> Form registrasi member baru
```

## Controllers

### `MemberDashboardController`
Location: `app/Http/Controllers/Member/MemberDashboardController.php`

Methods:
- `showLogin()` - Tampilkan form login
- `login(Request $request)` - Process login dengan validasi
- `index()` - Dashboard member
- `profile()` - Halaman profil member
- `card()` - Halaman kartu anggota

## Views

```
resources/views/
├── layouts/
│   └── member.blade.php          # Layout khusus member
├── member/
│   ├── login.blade.php           # Halaman login member
│   ├── dashboard.blade.php       # Dashboard member
│   ├── profile.blade.php         # Profil member
│   └── card.blade.php            # Kartu anggota
└── layouts/
    └── main.blade.php (updated)  # Added member login link
```

## Design Features

### Color Scheme
- Primary: Purple Gradient (#667eea → #764ba2)
- Accent: Purple (#764ba2)
- Background: Light Gray (#f9fafb)
- Text: Gray scale
- Status Colors:
  - Active/Success: Green
  - Warning: Orange
  - Error: Red
  - Info: Blue

### UI Components
- Card dengan shadow (`card-shadow` class)
- Gradient buttons dan backgrounds
- Icon integration (Heroicons via SVG)
- Responsive grid layouts
- Smooth transitions dan hover effects

## Security

### Authentication
- Middleware `auth` untuk semua member routes (kecuali login)
- Guest middleware untuk login page
- Session regeneration setelah login
- Member relationship validation pada setiap request

### Validation
- Email dan password required
- Member record check setelah login
- Redirect ke dashboard setelah sukses login
- Error messages dalam bahasa Indonesia

## Cara Menggunakan

### 1. Test Login
```
1. Buka browser: http://localhost:8000/member/login
2. Masukkan credentials user yang sudah punya member record
3. Login akan redirect ke /member/dashboard
```

### 2. Navigasi Member
```
- Dashboard: Overview dan quick stats
- Profil: Lihat dan kelola informasi profil
- Kartu: Download dan cetak kartu anggota
```

### 3. Logout
```
- Klik nama user di navbar
- Pilih "Logout"
- Akan redirect ke home page
```

## Integration dengan Sistem Existing

### Member Model
Dashboard menggunakan relationship `Auth::user()->member` untuk mengakses data member.

### Card Generation
Terintegrasi dengan sistem auto-generate kartu yang sudah ada:
- Template-based card generation
- Data overlay dengan Intervention Image
- Storage di public disk

### Settings
Menggunakan helper functions:
- `site_name()`
- `site_logo()`
- `setting()`

## Customization

### Mengubah Warna Theme
Edit `resources/views/layouts/member.blade.php`:
```css
.gradient-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Menambah Menu Sidebar
Edit `resources/views/layouts/member.blade.php`, section sidebar:
```html
<a href="{{ route('member.newpage') }}" 
   class="flex items-center space-x-3 px-4 py-3 rounded-lg ...">
    <svg>...</svg>
    <span class="font-medium">Menu Baru</span>
</a>
```

### Background Login Page
Edit `resources/views/member/login.blade.php`:
```css
.login-bg {
    background-image: url('PATH_TO_YOUR_IMAGE');
}
```

## Troubleshooting

### Error: "Anda belum terdaftar sebagai member"
**Solusi**: User harus memiliki record di tabel `members` dengan `user_id` yang sesuai.

### Kartu tidak muncul
**Solusi**: 
1. Pastikan `card_path` di tabel members sudah terisi
2. Cek storage link: `php artisan storage:link`
3. Verify file exists di storage/app/public/

### Login redirect ke /dashboard bukan /member/dashboard
**Solusi**: Routes member harus didefinisikan sebelum route dashboard umum di `web.php`

## Next Steps (Optional Enhancements)

1. **Edit Profile Functionality**
   - Form untuk update data member
   - Update password
   - Upload foto profil

2. **Member Activity Log**
   - History login
   - Activity timeline

3. **Notifications**
   - Email notification untuk kartu baru
   - Status update notifications

4. **Member Directory**
   - Browse member lain
   - Networking features

5. **Events Management**
   - Pendaftaran event dari member dashboard
   - Event history

## Files Created/Modified

### New Files:
- `app/Http/Controllers/Member/MemberDashboardController.php`
- `resources/views/layouts/member.blade.php`
- `resources/views/member/login.blade.php`
- `resources/views/member/dashboard.blade.php` (replaced)
- `resources/views/member/profile.blade.php`
- `resources/views/member/card.blade.php`
- `public/images/logo.svg`
- `public/images/logo.png`

### Modified Files:
- `routes/web.php` - Added member routes
- `resources/views/layouts/main.blade.php` - Added member login link

## Credits
- Design inspired by modern SaaS dashboards
- Icons: Heroicons
- Gradient colors: Purple theme APJIKOM
- Layout: Tailwind CSS + Alpine.js

---
**Version**: 1.0.0  
**Date**: {{ now()->format('d F Y') }}  
**Developer**: GitHub Copilot
