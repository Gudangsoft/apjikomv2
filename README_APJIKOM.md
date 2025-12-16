# Website APJIKOM
## Asosiasi Pengelola Jurnal Informatika dan Komputer

Website resmi APJIKOM yang dibangun dengan Laravel 11 dan MySQL, dengan desain yang terinspirasi dari IEEE.org dan konten dari APTIKOM.org.

## 🎯 Fitur Utama

### Halaman Publik
- ✅ **Beranda**: Hero section, statistik, tentang APJIKOM, berita terkini, kegiatan mendatang
- ✅ **Berita**: Daftar berita dengan kategori, featured articles, pagination
- ✅ **Detail Berita**: Artikel lengkap dengan berita terkait
- ✅ **Kegiatan**: Daftar event mendatang dan past events
- ✅ **Detail Kegiatan**: Informasi lengkap dengan link registrasi

### Sistem Member
- ✅ Registrasi member (Individu dan Institusi)
- ✅ Login dan Authentication (Laravel Breeze)
- ✅ Dashboard member
- ✅ Manajemen profil

## 🛠 Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Breeze
- **PHP**: 8.2+

## 📦 Instalasi

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apjikom
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrate & Seed Database
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets & Run
```bash
npm run build
php artisan serve
```

Website: `http://127.0.0.1:8000`

## 👤 Akun Default

**Admin**: admin@apjikom.or.id / password  
**Member**: member@example.com / password  
**User**: test@example.com / password

## 📋 Database Schema

- **users** - Pengguna dengan role (admin/member/user)
- **categories** - Kategori berita
- **news** - Artikel/berita
- **events** - Kegiatan APJIKOM
- **members** - Profil member

## 🎨 Desain

Website ini mengadaptasi:
- **Desain**: IEEE.org (professional blue theme)
- **Konten**: APTIKOM.org
- **Target**: APJIKOM (Asosiasi Pengelola Jurnal Informatika dan Komputer)

## 📞 Kontak

Email: info@apjikom.or.id  
Telepon: +62 811 8300 996  
Alamat: Gedung Graha Simatupang, Menara A Lantai 5, Jakarta

---
💙 Developed with Laravel 11
