# Quick Test Guide - Member Dashboard

## Testing the Member Dashboard System

### Prerequisites
1. Pastikan database sudah setup dengan tabel users dan members
2. Storage link sudah dibuat: `php artisan storage:link`
3. Server development berjalan: `php artisan serve`

### Test Scenario 1: Member Login

#### Step 1: Buat Test User dengan Member Record
Gunakan Tinker atau SQL:

```bash
php artisan tinker
```

```php
// Buat user baru
$user = \App\Models\User::create([
    'name' => 'Test Member',
    'email' => 'member@test.com',
    'password' => bcrypt('password123'),
    'email_verified_at' => now()
]);

// Buat member record
$member = \App\Models\Member::create([
    'user_id' => $user->id,
    'name' => 'Test Member',
    'email' => 'member@test.com',
    'contact' => '081234567890',
    'institution' => 'Universitas Test',
    'address' => 'Jl. Test No. 123',
    'status' => 'active',
    'member_number' => 'APJIKOM.' . now()->format('dmY') . '.001'
]);
```

#### Step 2: Test Login
1. Buka browser: `http://localhost:8000/member/login`
2. Login dengan:
   - Email: `member@test.com`
   - Password: `password123`
3. Should redirect to `/member/dashboard`

#### Step 3: Verify Dashboard
Check that you see:
- ✅ Welcome message dengan nama member
- ✅ Nomor anggota
- ✅ 3 stat cards (Status, Masa Berlaku, Kartu)
- ✅ Profil info di bawah
- ✅ Quick actions menu

### Test Scenario 2: Navigation

#### Test Navigation Links
1. **Dari Dashboard** → Click "Profil Saya"
   - Should show `/member/profile`
   - Display all member information
   
2. **Dari Profile** → Click "Kartu Anggota" (sidebar)
   - Should show `/member/card`
   - Show message "Kartu Belum Tersedia" (if no card yet)

3. **Dari Main Site** → Click "Login Member" (top nav)
   - Should show login page
   - Try login
   - Should return to dashboard

### Test Scenario 3: Kartu Anggota

#### Generate Card First (Admin)
1. Login ke admin: `http://localhost:8000/login`
2. Go to Members → Find the test member
3. Click "Generate Kartu" button
4. Wait for card generation

#### Test Card Display
1. Go to `/member/card`
2. Should see:
   - ✅ Full-size card image
   - ✅ Card information
   - ✅ Download button
   - ✅ Print button

3. Test download button
   - Should download PNG file

4. Test print button
   - Should open print dialog
   - Navigation should be hidden in print preview

### Test Scenario 4: Logout

1. Click user dropdown (nama di navbar)
2. Click "Logout"
3. Should redirect to home page
4. Try access `/member/dashboard` directly
5. Should redirect to `/member/login`

### Test Scenario 5: Responsive Design

#### Desktop (1920x1080)
- ✅ Full sidebar visible
- ✅ All cards in row
- ✅ Login page split view

#### Tablet (768px)
- ✅ Sidebar collapsed to hamburger
- ✅ Cards stack in 2 columns
- ✅ Login form centered

#### Mobile (375px)
- ✅ Mobile menu works
- ✅ All cards stack vertically
- ✅ Login background hidden, logo shown

### Test Scenario 6: Error Handling

#### Test Invalid Login
1. Go to `/member/login`
2. Enter wrong credentials
3. Should show error: "Email atau password yang Anda masukkan salah"

#### Test Non-Member User
1. Create user without member record:
```php
$user = \App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123')
]);
```

2. Try login dengan `admin@test.com`
3. Should show error: "Akun Anda belum terdaftar sebagai member"

#### Test Guest Access
1. Logout
2. Try access `/member/dashboard` directly
3. Should redirect to `/member/login`

### Test Scenario 7: Member Registration Flow

1. Go to home page
2. Click "Bergabung" button (or "Daftar Sekarang" on login page)
3. Should show registration form
4. Fill form and submit
5. Check admin panel for new registration
6. Approve registration as admin
7. Login dengan credentials yang didaftarkan

## Expected Results Summary

✅ **Login**: Smooth login process dengan validasi  
✅ **Dashboard**: Modern UI dengan stats dan quick actions  
✅ **Profile**: Complete member information display  
✅ **Card**: Card display dengan download dan print  
✅ **Navigation**: Easy navigation between pages  
✅ **Security**: Proper auth middleware protection  
✅ **Responsive**: Works on all device sizes  
✅ **Errors**: Clear error messages in Indonesian  

## Common Issues & Solutions

### Issue: "Class 'Intervention\Image\ImageManager' not found"
**Solution**: 
```bash
composer require intervention/image
```

### Issue: Card not displaying
**Solution**:
```bash
php artisan storage:link
```

### Issue: Logo not showing
**Solution**: 
- Use SVG logo in `public/images/logo.svg` or upload PNG
- Or remove logo check in views to use initials only

### Issue: "Route [password.request] not defined"
**Solution**: 
- Either implement password reset
- Or remove "Lupa password?" link from login page

### Issue: Styles not loading
**Solution**:
```bash
npm run dev  # or npm run build
```

## Performance Checklist

- [ ] Images optimized (card templates, logos)
- [ ] CSS/JS compiled with Vite
- [ ] Storage symlink created
- [ ] Database indexed (member_number, email)
- [ ] Session configured properly
- [ ] Cache cleared if needed

## Security Checklist

- [x] CSRF protection on all forms
- [x] Password hashing (bcrypt)
- [x] Auth middleware on protected routes
- [x] Guest middleware on login page
- [x] Session regeneration after login
- [x] Member relationship validation
- [ ] Rate limiting (optional, add if needed)
- [ ] Email verification (optional, already scaffolded)

---

**Happy Testing! 🚀**

If all tests pass, the member dashboard system is ready for production use.
