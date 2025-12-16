# APJIKOM - Asosiasi Pengelola Jurnal Informatika dan Komputer

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Website resmi Asosiasi Pengelola Jurnal Informatika dan Komputer (APJIKOM) Indonesia. Platform ini dibangun untuk mengelola keanggotaan, publikasi jurnal, berita, event, dan layanan lainnya untuk anggota APJIKOM.

## 📋 Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Teknologi](#teknologi)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Default](#akun-default)
- [Struktur Database](#struktur-database)
- [Dokumentasi Fitur](#dokumentasi-fitur)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## 🎯 Tentang Aplikasi

APJIKOM adalah sistem manajemen website untuk organisasi profesional yang mengelola jurnal ilmiah di bidang informatika dan komputer. Sistem ini menyediakan platform terintegrasi untuk:

- **Manajemen Keanggotaan**: Pendaftaran, verifikasi, dan pengelolaan data anggota
- **Publikasi**: Pengelolaan jurnal ilmiah dan divisi jurnal
- **Informasi**: Berita, event, dan kegiatan organisasi
- **Layanan**: Directory anggota, testimonial, dan berbagai layanan lainnya
- **Administrasi**: Dashboard admin dengan fitur lengkap untuk mengelola konten website

## ✨ Fitur Utama

### 🎨 Frontend (User)
- **Landing Page Modern** dengan hero slider dan animasi
- **Berita & Artikel** dengan kategori dan pencarian
- **Event Management** dengan registrasi online
- **Member Directory** dengan filter dan pencarian
- **Galeri Foto & Video** untuk dokumentasi kegiatan
- **FAQ Section** untuk pertanyaan umum
- **Testimonial** dari anggota
- **Dark Mode Support** untuk kenyamanan mata
- **Responsive Design** untuk semua perangkat

### 👥 Member Area
- **Member Dashboard** dengan statistik personal
- **Profile Management** dengan foto dan data lengkap
- **Member Card** digital dengan QR code
- **Event Registration** untuk mendaftar kegiatan
- **Testimonial Management** untuk memberikan testimoni
- **Notifications** sistem notifikasi personal
- **Birthday Greeting** ucapan otomatis saat ulang tahun

### 🔐 Admin Panel
- **Dashboard Admin** dengan statistik lengkap
- **User Management** kelola user dan role
- **Member Management** dengan verifikasi dan approval
- **Content Management** (News, Events, Pages, Menus)
- **Media Management** (Sliders, Gallery, Partners)
- **Journal Management** kelola jurnal dan divisi
- **Institution Management** kelola institusi anggota
- **Settings** pengaturan website lengkap
- **Activity Logs** tracking aktivitas admin
- **Notification System** untuk member

### 🛠️ Fitur Khusus
- **Read More Feature** pada deskripsi panjang
- **Member Card Generator** dengan template customizable
- **Email Notifications** untuk berbagai event
- **Section Label Management** untuk kustomisasi UI
- **SEO Friendly** dengan meta tags customizable
- **Multi-level Menu** untuk navigasi kompleks
- **Payment Proof Upload** untuk pendaftaran berbayar
- **Event Categories** untuk klasifikasi kegiatan

## 🚀 Teknologi

### Backend
- **Laravel 11.x** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL 8.0+** - Database
- **Composer** - Dependency Manager

### Frontend
- **Blade Template Engine** - Laravel Templating
- **Tailwind CSS 3.x** - CSS Framework
- **Alpine.js** (optional) - JavaScript Framework
- **Vite** - Frontend Build Tool
- **Swiper.js** - Slider Component
- **AOS** - Animation Library

### Tools & Libraries
- **Laravel Breeze** - Authentication
- **Intervention Image** - Image Processing
- **GuzzleHTTP** - HTTP Client
- **Laravel Sanctum** - API Authentication

## 💻 Persyaratan Sistem

### Minimum Requirements
- PHP >= 8.2
- MySQL >= 8.0 atau MariaDB >= 10.3
- Composer >= 2.0
- Node.js >= 18.x dan NPM >= 9.x
- Web Server (Apache/Nginx)

### Recommended Requirements
- PHP 8.3
- MySQL 8.0 atau MariaDB 10.11
- Composer 2.7
- Node.js 20.x LTS
- Nginx dengan PHP-FPM
- RAM minimal 2GB
- Storage minimal 5GB

### PHP Extensions Required
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD atau Imagick
- Zip
```

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Gudangsoft/apjikomv2.git
cd apjikomv2
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apjikom_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Buat Database

```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE apjikom_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Migrasi Database & Seeder

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder (optional - untuk data dummy)
php artisan db:seed
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 9. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

## ⚙️ Konfigurasi

### Email Configuration

Edit `.env` untuk konfigurasi email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@apjikom.id
MAIL_FROM_NAME="APJIKOM"
```

### App Configuration

```env
APP_NAME=APJIKOM
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### Session & Cache

```env
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### File Upload Limits

Edit `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

## 🏃 Menjalankan Aplikasi

### Development Mode

```bash
# Terminal 1: Start Laravel Server
php artisan serve

# Terminal 2: Start Vite Dev Server
npm run dev
```

Akses aplikasi di: `http://localhost:8000`

### Production Mode

#### Menggunakan Apache

1. Setup Virtual Host:

```apache
<VirtualHost *:80>
    ServerName apjikom.local
    DocumentRoot /path/to/apjikomv2/public

    <Directory /path/to/apjikomv2/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/apjikom_error.log
    CustomLog ${APACHE_LOG_DIR}/apjikom_access.log combined
</VirtualHost>
```

2. Enable mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Menggunakan Nginx

```nginx
server {
    listen 80;
    server_name apjikom.local;
    root /path/to/apjikomv2/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Optimize for Production

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## 👤 Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin
- **Email**: admin@apjikom.id
- **Password**: password
- **Akses**: Full access ke admin panel

### Member (Test Account)
- **Email**: member@apjikom.id
- **Password**: password
- **Akses**: Member dashboard

⚠️ **PENTING**: Segera ubah password default setelah login pertama kali!

## 🗄️ Struktur Database

### Tabel Utama

- `users` - Data pengguna sistem
- `members` - Data anggota APJIKOM
- `institutions` - Data institusi/perguruan tinggi
- `registrations` - Data pendaftaran anggota baru
- `news` - Berita dan artikel
- `events` - Event dan kegiatan
- `event_registrations` - Pendaftaran event
- `journals` - Data jurnal ilmiah
- `journal_divisions` - Divisi jurnal
- `categories` - Kategori konten
- `galleries` - Galeri foto dan video
- `testimonials` - Testimoni anggota
- `pages` - Halaman custom
- `menus` - Menu navigasi
- `settings` - Pengaturan website
- `sliders` - Hero slider
- `partners` - Partner/sponsor
- `services` - Layanan
- `faqs` - FAQ
- `notifications` - Notifikasi member
- `activity_logs` - Log aktivitas admin
- `member_card_templates` - Template kartu anggota
- `organizational_structures` - Struktur organisasi
- `password_reset_requests` - Request reset password member

### Database Diagram

```
users ──┬── members ───┬── institutions
        │              ├── event_registrations ─── events
        │              ├── testimonials
        │              └── notifications
        │
        └── activity_logs

news ─── categories
events ─── categories
journals ─── journal_divisions
```

## 📚 Dokumentasi Fitur

Dokumentasi lengkap untuk fitur-fitur khusus tersedia di:

- [FITUR_BARU_IMPLEMENTASI.md](FITUR_BARU_IMPLEMENTASI.md) - Implementasi fitur baru
- [FITUR_EVENT_KATEGORI.md](FITUR_EVENT_KATEGORI.md) - Sistem kategori event
- [FITUR_PEMBAYARAN.md](FITUR_PEMBAYARAN.md) - Sistem pembayaran
- [FITUR_READ_MORE.md](FITUR_READ_MORE.md) - Fitur read more
- [LAYOUT_KARTU_ANGGOTA.md](LAYOUT_KARTU_ANGGOTA.md) - Desain kartu anggota
- [MEMBER_DASHBOARD_README.md](MEMBER_DASHBOARD_README.md) - Dashboard member
- [MEMBER_DIRECTORY.md](MEMBER_DIRECTORY.md) - Directory anggota
- [PERBAIKAN_OPTIMASI.md](PERBAIKAN_OPTIMASI.md) - Optimasi sistem
- [SECTION_LABELS_GUIDE.md](SECTION_LABELS_GUIDE.md) - Panduan section labels
- [SINKRONISASI_PENDAFTARAN_MEMBER.md](SINKRONISASI_PENDAFTARAN_MEMBER.md) - Sinkronisasi data
- [TESTING_GUIDE.md](TESTING_GUIDE.md) - Panduan testing
- [CRUD_MENU_AGENDA.md](CRUD_MENU_AGENDA.md) - CRUD menu agenda

## 🔧 Troubleshooting

### Error: "No application encryption key has been specified"

```bash
php artisan key:generate
```

### Error: Storage Link Not Working

```bash
php artisan storage:link
# Atau manual symlink
ln -s ../storage/app/public public/storage
```

### Error: Permission Denied

```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (Run as Administrator)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

### Error: Class Not Found

```bash
composer dump-autoload
php artisan clear-compiled
php artisan optimize:clear
```

### Error: Mix Manifest Not Found

```bash
npm run build
```

### Database Connection Error

1. Periksa kredensial database di `.env`
2. Pastikan MySQL service berjalan
3. Test koneksi database:

```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### Slow Performance

```bash
# Clear all cache
php artisan optimize:clear

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer
composer dump-autoload --optimize
```

### Upload File Gagal

1. Periksa `upload_max_filesize` dan `post_max_size` di `php.ini`
2. Periksa permission folder `storage/app/public`
3. Pastikan storage link sudah dibuat

### Email Tidak Terkirim

1. Periksa konfigurasi MAIL di `.env`
2. Untuk Gmail, gunakan App Password
3. Test email:

```bash
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

## 🤝 Kontribusi

Kami menerima kontribusi dari siapa saja! Berikut cara berkontribusi:

### 1. Fork Repository

Klik tombol "Fork" di bagian atas halaman repository.

### 2. Clone Fork

```bash
git clone https://github.com/YOUR-USERNAME/apjikomv2.git
cd apjikomv2
```

### 3. Buat Branch Baru

```bash
git checkout -b feature/nama-fitur-anda
```

### 4. Commit Changes

```bash
git add .
git commit -m "Add: deskripsi fitur anda"
```

### 5. Push ke GitHub

```bash
git push origin feature/nama-fitur-anda
```

### 6. Buat Pull Request

Buka GitHub dan buat Pull Request dari branch Anda ke main repository.

### Coding Standards

- Ikuti PSR-12 coding standard
- Gunakan meaningful variable dan function names
- Tambahkan komentar untuk kode yang kompleks
- Tulis unit test untuk fitur baru
- Update dokumentasi jika diperlukan

### Commit Message Format

```
Type: Short description

Detailed description (optional)

Type dapat berupa:
- Add: Menambah fitur baru
- Fix: Memperbaiki bug
- Update: Update fitur yang ada
- Remove: Menghapus fitur
- Refactor: Refactoring code
- Docs: Update dokumentasi
- Style: Formatting, missing semi colons, etc
- Test: Menambah test
```

## 📄 Lisensi

Project ini dilisensikan under [MIT License](LICENSE).

```
MIT License

Copyright (c) 2025 APJIKOM

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 📞 Kontak & Support

- **Website**: [https://apjikom.id](https://apjikom.id)
- **Email**: info@apjikom.id
- **GitHub Issues**: [https://github.com/Gudangsoft/apjikomv2/issues](https://github.com/Gudangsoft/apjikomv2/issues)

## 🙏 Acknowledgments

Terima kasih kepada semua kontributor dan teknologi open source yang digunakan dalam project ini:

- [Laravel Framework](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Swiper.js](https://swiperjs.com)
- [Intervention Image](http://image.intervention.io)
- Dan semua package yang digunakan

---

**Dibuat dengan ❤️ oleh Tim APJIKOM**

⭐ Jangan lupa berikan star jika project ini bermanfaat!
