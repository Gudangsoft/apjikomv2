# 🧪 Quick Test - Fitur Reset Password 3x Salah

## Test Admin Login

### 1. Buka halaman admin login:
```
http://localhost:8000/admin-panel-apjikom
```

### 2. Test Scenario:

**Attempt #1-2:**
- Email: `admin@apjikom.or.id`
- Password: `wrongpass123` (atau password salah apapun)
- CAPTCHA: Isi dengan benar
- Klik "LOG IN"
- **Result:** Error muncul, tombol reset belum ada

**Attempt #3:**
- Email: `admin@apjikom.or.id` (sama)
- Password: `wrongpass123` (masih salah)
- CAPTCHA: Isi dengan benar
- Klik "LOG IN"
- **Result:** 
  - ✅ Error muncul
  - ✅ **TOMBOL ORANGE "Reset Password" MUNCUL**
  - ✅ Alert: "❌ Password salah 3 kali!"

**Test Reset Password:**
- Klik tombol "Reset Password"
- **Result:**
  - ✅ Form kuning muncul
  - ✅ Email sudah ter-isi otomatis
  - ✅ Login form tersembunyi

- Klik "Kirim Link"
- **Result:**
  - ✅ Request POST ke `/forgot-password`
  - ✅ (Jika email configured) Email reset terkirim
  - ✅ (Jika MAIL_MAILER=log) Check `storage/logs/laravel.log`

**Test Login Sukses:**
- Klik "Kembali ke login"
- Login dengan password benar
- **Result:**
  - ✅ Login berhasil
  - ✅ Counter direset (coba salah lagi, mulai dari 0)

---

## Test Member Login

### 1. Buka halaman member login:
```
http://localhost:8000/member/login
```

### 2. Test Scenario (sama seperti admin):

**Attempt #1-2:** Salah password → Error biasa

**Attempt #3:** Salah password → Tombol "Reset Password" muncul

**Test Reset:** Klik tombol → Form muncul → Kirim link

---

## Expected Email Content

Jika email configured dengan benar, user akan menerima:

**Subject:** Reset Password Notification

**Body:**
```
You are receiving this email because we received a password reset request for your account.

[Reset Password Button]

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.
```

---

## Check Logs

```bash
# Watch logs real-time
tail -f storage/logs/laravel.log

# Or just view last 50 lines
tail -n 50 storage/logs/laravel.log
```

Look for:
```
[timestamp] local.INFO: User reset password request for: admin@apjikom.or.id
```

Or email content if MAIL_MAILER=log.

---

## Reset Counter Manually (for testing)

Jika ingin reset counter tanpa login:

```bash
php artisan tinker

# Di tinker:
>>> session()->forget('login_failed_admin@apjikom.or.id');
>>> session()->forget('show_reset_password');
>>> exit
```

Atau clear semua session:
```bash
php artisan cache:clear
```

---

## Test Credentials

**Admin:**
- Email: `admin@apjikom.or.id`
- Password: `password` (sesuai seeder default)

**Member:**
- Gunakan email member yang sudah terdaftar
- Password: Sesuai yang di-set saat registrasi

---

## Troubleshooting

### "Tombol tidak muncul setelah 3x salah"
```bash
# Clear cache dulu
php artisan cache:clear
php artisan view:clear

# Refresh browser (Ctrl+Shift+R)
```

### "Email tidak terkirim"
```bash
# Check .env
MAIL_MAILER=log  # Untuk testing lokal

# Atau test SMTP
php artisan tinker
>>> Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));
```

### "JavaScript error di console"
- Buka Browser DevTools (F12)
- Tab Console
- Check error messages
- Pastikan jQuery tidak conflict (kami pakai vanilla JS)

---

## Success Indicators

✅ Setelah 3x salah → Tombol orange muncul  
✅ Klik tombol → Form kuning muncul  
✅ Email pre-filled di form  
✅ Submit → Request terkirim  
✅ Login sukses → Counter reset  

**FITUR SIAP DIGUNAKAN!** 🎉
