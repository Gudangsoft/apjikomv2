# Fitur Penggabungan Menu Members & Pendaftaran

## 📋 Deskripsi
Fitur ini menggabungkan dua menu terpisah ("Members" dan "Pendaftaran") menjadi satu menu "Members" dengan sistem tabs untuk mempercepat navigasi admin dan mengurangi clutter di sidebar.

## ✨ Fitur Utama

### 1. **Tabs Navigation**
- **Tab Members**: Menampilkan daftar semua member aktif
- **Tab Pendaftaran Baru**: Menampilkan daftar pendaftaran baru yang pending

### 2. **Badge Notifikasi Pintar**
- Badge di menu "Members" menampilkan total notifikasi:
  - Member yang belum memiliki kartu anggota (card_requested atau data lengkap)
  - Pendaftaran baru yang status pending
- Badge akan **animate-pulse** jika ada pendaftaran pending
- Badge otomatis hilang jika tidak ada notifikasi

### 3. **Manajemen Terpusat**
- Semua fungsi registrasi dipindahkan ke `MemberController`
- Routes registrasi di-redirect ke members dengan parameter tabs
- Tidak ada kehilangan fitur dari sistem lama

## 📁 File yang Dimodifikasi

### 1. Controller
**File**: `app/Http/Controllers/Admin/MemberController.php`

**Perubahan**:
- Import model `Registration`, `Hash`, `Str`
- Method `index()` dimodifikasi untuk handle parameter `tab`
- Menambahkan 3 method baru:
  - `showRegistration($registration)` - Lihat detail pendaftaran
  - `updateRegistrationStatus($request, $registration)` - Approve/reject dengan auto create member
  - `destroyRegistration($registration)` - Hapus pendaftaran

```php
public function index(Request $request)
{
    $tab = $request->get('tab', 'members'); // default: members
    
    // Data untuk Members tab
    $members = Member::query()
        ->when($request->search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
        })
        ->when($request->status, function($query, $status) {
            $query->where('status', $status);
        })
        ->when($request->is_verified !== null, function($query) use ($request) {
            $query->where('is_verified', $request->is_verified);
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();
    
    // Data untuk Registrations tab
    $registrations = Registration::query()
        ->when($request->search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        })
        ->when($request->reg_status, function($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();
    
    // Hitung pending registrations
    $pending_registrations = Registration::where('status', 'pending')->count();
    
    // Stats untuk badge
    $stats = [
        'total_members' => Member::count(),
        'total_registrations' => Registration::count(),
        'pending_registrations' => $pending_registrations,
    ];
    
    return view('admin.members.index', compact('members', 'registrations', 'tab', 'stats'));
}
```

### 2. Routes
**File**: `routes/web.php`

**Perubahan**:
```php
// Registrations Management (now handled by MemberController)
Route::get('registrations', function() {
    return redirect()->route('admin.members.index', ['tab' => 'registrations']);
})->name('registrations.index');
Route::get('registrations/{registration}', [AdminMemberController::class, 'showRegistration'])->name('registrations.show');
Route::put('registrations/{registration}/status', [AdminMemberController::class, 'updateRegistrationStatus'])->name('registrations.update-status');
Route::delete('registrations/{registration}', [AdminMemberController::class, 'destroyRegistration'])->name('registrations.destroy');
```

### 3. Views

#### Main View
**File**: `resources/views/admin/members/index.blade.php`

**Struktur Baru**:
```blade
<x-admin-layout>
    <!-- Header dengan Tabs Navigation -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1>Manajemen Anggota</h1>
            <p>Kelola data anggota dan pendaftaran baru</p>
        </div>
    </div>

    <!-- Tabs Buttons -->
    <div class="flex space-x-2 mb-6 border-b-2 border-gray-200">
        <button id="tab-members" onclick="switchTab('members')" class="tab-button">
            <svg>...</svg>
            <span>Members</span>
            <span class="badge">{{ $stats['total_members'] }}</span>
        </button>
        
        <button id="tab-registrations" onclick="switchTab('registrations')" class="tab-button">
            <svg>...</svg>
            <span>Pendaftaran Baru</span>
            <span class="badge {{ $stats['pending_registrations'] > 0 ? 'animate-pulse' : '' }}">
                {{ $stats['total_registrations'] }}
                @if($stats['pending_registrations'] > 0)
                    ({{ $stats['pending_registrations'] }} pending)
                @endif
            </span>
        </button>
    </div>

    <!-- Tab Content: Members -->
    <div id="content-members" class="tab-content">
        @include('admin.members.partials.members-tab')
    </div>

    <!-- Tab Content: Registrations -->
    <div id="content-registrations" class="tab-content">
        @include('admin.members.partials.registrations-tab')
    </div>

    <script>
        function switchTab(tab) {
            // Update URL parameter
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
            
            // Toggle visibility
            ['members', 'registrations'].forEach(t => {
                document.getElementById('content-' + t).classList.toggle('hidden', t !== tab);
                document.getElementById('tab-' + t).classList.toggle('active', t === tab);
            });
        }
        
        // Inisialisasi tab berdasarkan parameter URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentTab = urlParams.get('tab') || 'members';
        switchTab(currentTab);
    </script>
</x-admin-layout>
```

#### Members Tab Partial
**File**: `resources/views/admin/members/partials/members-tab.blade.php`

**Fitur**:
- Search form (nama, email, institusi)
- Filter by status (active/inactive/pending)
- Filter by verification status
- Table dengan kolom: Avatar, Nama, Email, Institusi, Status, Verified, Kartu, Actions
- Status badges dengan warna
- Card status icons (check/pulse/x)
- Pagination dengan preservasi parameter tab

#### Registrations Tab Partial
**File**: `resources/views/admin/members/partials/registrations-tab.blade.php`

**Fitur**:
- Search form (nama, email, phone)
- Filter by registration status (pending/approved/rejected)
- Table dengan kolom: Nama, Email, Phone, Tipe, Status, Tanggal, Actions
- Type badges (Individual/Institutional)
- Status badges (pending/approved/rejected)
- Action buttons:
  - View Detail (blue)
  - Approve (green)
  - Reject (red)
  - Delete (red outline)
- Pagination dengan preservasi parameter tab

### 4. Sidebar Layout
**File**: `resources/views/layouts/admin.blade.php`

**Perubahan**:
1. **Hapus menu "Pendaftaran"** yang terpisah
2. **Update badge di menu "Members"**:
```php
@php
    $newMembersCount = \App\Models\Member::where(function($query) {
        $query->whereNull('member_card')
              ->where('card_requested', true);
    })->orWhere(function($query) {
        $query->whereNull('member_card')
              ->whereNotNull('photo')
              ->whereNotNull('address')
              ->whereNotNull('phone');
    })->count();
    
    $pendingRegistrations = \App\Models\Registration::where('status', 'pending')->count();
    
    $totalNotifications = $newMembersCount + $pendingRegistrations;
@endphp
@if($totalNotifications > 0)
    <span class="px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full {{ $pendingRegistrations > 0 ? 'animate-pulse' : '' }}">
        {{ $totalNotifications }}
    </span>
@endif
```

3. **Alpine.js tetap mencakup** `admin.registrations.*` dalam kondisi menu "keanggotaan" terbuka

## 🎯 Cara Penggunaan

### Akses Menu Members
1. Klik menu "Members" di sidebar
2. Default tab yang muncul: **Members**
3. Badge menunjukkan total notifikasi (member tanpa kartu + pendaftaran pending)
4. Badge akan berkedip (pulse) jika ada pendaftaran pending

### Switch ke Tab Pendaftaran
1. Klik tombol "Pendaftaran Baru" di bagian tabs
2. URL otomatis berubah menjadi: `/admin/members?tab=registrations`
3. Konten berubah menampilkan daftar pendaftaran
4. Badge menampilkan total registrasi dan jumlah pending

### Approve Pendaftaran
1. Di tab "Pendaftaran Baru", klik tombol **Approve** (hijau)
2. Sistem otomatis:
   - Membuat akun user baru
   - Membuat data member baru
   - Generate password random
   - Kirim email ke member baru
   - Update status registrasi menjadi "approved"

### Reject Pendaftaran
1. Di tab "Pendaftaran Baru", klik tombol **Reject** (merah)
2. Sistem:
   - Update status registrasi menjadi "rejected"
   - Data tetap tersimpan untuk history

### Lihat Detail Pendaftaran
1. Klik tombol **View** (biru) dengan icon eye
2. Halaman detail menampilkan semua informasi pendaftaran
3. Ada tombol Approve/Reject di halaman detail

### Hapus Pendaftaran
1. Klik tombol **Delete** (merah outline) dengan icon trash
2. Konfirmasi penghapusan
3. Foto pendaftaran juga dihapus dari storage

### Search & Filter
**Members Tab**:
- Search: Nama, Email, atau Institusi
- Filter Status: All, Active, Inactive, Pending
- Filter Verified: All, Verified, Not Verified

**Registrations Tab**:
- Search: Nama, Email, atau Phone
- Filter Status: All, Pending, Approved, Rejected

## 🔍 Parameter URL

### Members Tab
```
/admin/members
/admin/members?tab=members
/admin/members?tab=members&search=john
/admin/members?tab=members&status=active
/admin/members?tab=members&is_verified=1
```

### Registrations Tab
```
/admin/members?tab=registrations
/admin/members?tab=registrations&search=jane
/admin/members?tab=registrations&reg_status=pending
```

## 🔄 Backward Compatibility

### Old Routes (Still Work)
```
/admin/registrations → Redirect to /admin/members?tab=registrations
/admin/registrations/123 → Still works (showRegistration)
/admin/registrations/123/status → Still works (updateRegistrationStatus)
```

### Alpine.js Menu State
- Menu "Keanggotaan" tetap terbuka saat mengakses:
  - `admin.members.*`
  - `admin.registrations.*`
  - `admin.card-templates.*`
  - `admin.certificate-templates.*`

## 📊 Badge Notifikasi Logic

### Total Notifications
```php
$totalNotifications = $newMembersCount + $pendingRegistrations
```

### Animate Pulse Condition
```php
{{ $pendingRegistrations > 0 ? 'animate-pulse' : '' }}
```

Badge akan berkedip hanya jika ada **pendaftaran pending**, tidak hanya member request kartu.

## 🎨 Styling

### Tabs Button
- **Active**: `bg-purple-100 text-purple-700 border-b-2 border-purple-500 font-semibold`
- **Inactive**: `text-gray-600 hover:text-gray-800 hover:bg-gray-50`

### Badge di Tabs
- **Purple** (Members count)
- **Red** dengan atau tanpa pulse (Registrations)

### Status Badges
- **Active**: `bg-green-100 text-green-800`
- **Inactive**: `bg-gray-100 text-gray-800`
- **Pending**: `bg-yellow-100 text-yellow-800`
- **Approved**: `bg-green-100 text-green-800`
- **Rejected**: `bg-red-100 text-red-800`

### Card Status Icons
- **Has Card** (Green check): Member sudah punya kartu
- **Requested** (Orange pulse): Member request kartu
- **No Card** (Gray X): Member belum punya kartu

## 🚀 Keuntungan Fitur Ini

1. **Navigasi Lebih Cepat**: Admin tidak perlu pindah-pindah menu
2. **Visual Lebih Jelas**: Badge menunjukkan notifikasi penting
3. **Sidebar Lebih Rapi**: Dari 4 item (Members, Pendaftaran, Template Kartu, Template Sertifikat) menjadi lebih terorganisir
4. **Konteks Terjaga**: Tab system mempertahankan konteks keanggotaan
5. **URL Shareable**: Admin bisa share link langsung ke tab tertentu
6. **Backward Compatible**: Link lama tetap berfungsi dengan redirect

## 🐛 Testing Checklist

- [ ] Klik menu Members dari sidebar → Tampil tab Members
- [ ] Klik tab "Pendaftaran Baru" → Tampil daftar registrasi
- [ ] URL berubah dengan parameter `?tab=registrations`
- [ ] Badge di sidebar menunjukkan angka yang benar
- [ ] Badge berkedip saat ada pending registrations
- [ ] Search di tab Members berfungsi
- [ ] Filter status di tab Members berfungsi
- [ ] Search di tab Registrations berfungsi
- [ ] Filter status di tab Registrations berfungsi
- [ ] Approve registration berfungsi dan create member
- [ ] Reject registration berfungsi
- [ ] View detail registration berfungsi
- [ ] Delete registration berfungsi
- [ ] Pagination maintain parameter tab
- [ ] Refresh halaman, tab tetap sesuai parameter URL
- [ ] Akses `/admin/registrations` redirect ke tab registrations
- [ ] Alpine.js menu "Keanggotaan" terbuka saat di members atau registrations

## 📝 Notes

- Original `index.blade.php` di-backup sebagai `index.blade.php.backup` (541 lines)
- New `index.blade.php` hanya 100+ lines (lebih clean dengan partials)
- Partials memudahkan maintenance dan update di masa depan
- JavaScript `switchTab()` function handle semua logika tabs
- Query string preserved untuk search, filter, dan pagination

## 🎓 Future Improvements

1. **AJAX Tab Switching**: Tab switching tanpa reload page
2. **Real-time Badge Update**: WebSocket untuk update badge notifikasi
3. **Bulk Actions**: Approve/reject multiple registrations sekaligus
4. **Export**: Export daftar members atau registrations ke Excel/PDF
5. **Activity Log**: Log semua aktivitas approve/reject
6. **Email Templates**: Customize email template untuk member baru

---

**Created**: 2024
**Author**: AI Assistant
**Version**: 1.0
