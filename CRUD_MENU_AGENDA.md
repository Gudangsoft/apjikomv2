# CRUD Menu Agenda (Kegiatan) - Dokumentasi Lengkap

## 🎯 Ringkasan Fitur

Sistem manajemen agenda/kegiatan APJIKOM yang lengkap dengan:
- ✅ **CRUD Admin Panel** - Kelola event dari dashboard admin
- ✅ **Halaman Public Index** - Tampilan grid modern dengan filter kategori
- ✅ **Halaman Detail Event** - Layout premium dengan info lengkap
- ✅ **Filter by Category** - Navigasi kategori di halaman index
- ✅ **Pagination** - Support banyak event
- ✅ **Registration Link** - CTA button untuk pendaftaran
- ✅ **Related Events** - Rekomendasi event lain
- ✅ **Responsive Design** - Mobile-friendly

---

## 📂 Struktur File

### Backend

#### Controllers

**1. `app/Http/Controllers/EventController.php`** (Public)
```php
- index(Request $request) // List all events with category filter
- show($slug)             // Event detail page
```

**Fitur:**
- Filter by category via query parameter `?category=1`
- Eager loading category relation
- Pagination 12 items per page
- Upcoming events (future dates)
- Past events (6 latest)
- Related events (3 items)

**2. `app/Http/Controllers/Admin/EventController.php`** (Admin)
```php
- index()          // List events (admin table)
- create()         // Show create form
- store()          // Save new event
- edit($event)     // Show edit form
- update($event)   // Update event
- destroy($event)  // Delete event
```

**Fitur:**
- Category dropdown integration
- Image upload handling
- Validation with category_id
- Eager loading for performance

#### Models

**1. `app/Models/Event.php`**
```php
Fillable: title, slug, category_id, description, image, location, 
          event_date, event_time, registration_link, is_published, is_featured

Relations:
- belongsTo(Category::class)

Scopes:
- published()  // Only published events
- upcoming()   // Future dates
- featured()   // Featured on homepage
```

**2. `app/Models/Category.php`**
```php
Relations:
- hasMany(Event::class) // Category has many events
```

#### Routes

**Public Routes** (`routes/web.php`):
```php
Route::get('/kegiatan', [EventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('events.show');
```

**Admin Routes** (inside auth:admin middleware):
```php
Route::resource('events', AdminEventController::class);
```

---

### Frontend

#### Admin Views

**1. `resources/views/admin/events/index.blade.php`**
- Tabel listing events dengan kategori badge
- Pagination
- Action buttons: Edit, Delete
- Status badges: Published/Draft, Featured
- Image thumbnail
- Category badge dengan icon
- Location dengan emoji 📍

**2. `resources/views/admin/events/create.blade.php`**
- Form tambah event baru
- Fields:
  * Judul (required)
  * **Kategori (dropdown)** - NEW!
  * Gambar (required, with preview)
  * Deskripsi (textarea)
  * Tanggal (required)
  * Waktu (optional)
  * Lokasi (required)
  * Link Pendaftaran (optional URL)
  * Checkbox: Publikasikan, Tampilkan di Homepage
- Image preview on file select
- Validation error display

**3. `resources/views/admin/events/edit.blade.php`**
- Form edit event existing
- Same fields as create
- Show current image
- Preview new image before upload
- **Kategori dropdown with selected value**

---

#### Public Views

**1. `resources/views/events/index.blade.php`** - Halaman List Agenda

**Design Highlights:**
```
┌─────────────────────────────────────────────────────────┐
│  📅 AGENDA                           [Lihat Semua →]   │
│  Agenda Kegiatan                                        │
│  Ikuti berbagai kegiatan dan acara APJIKOM             │
│                                                         │
│  [Semua] [Webinar] [Workshop] [Seminar]  ← Filters    │
└─────────────────────────────────────────────────────────┘

┌────────┬────────┬────────┐
│ Event  │ Event  │ Event  │  ← Grid 3 columns
│ Card   │ Card   │ Card   │
└────────┴────────┴────────┘
```

**Features:**
- **Gradient Header** - Purple gradient dengan decorative elements
- **Category Filter Pills** - Active state dengan white background
- **Event Counter** - "X Kegiatan Mendatang" dynamic count
- **Grid Layout** - 3 columns responsive (1 col mobile)
- **Event Card Components:**
  * Large date badge (floating on image)
  * Category badge (top-right)
  * Event image or gradient fallback
  * Title (2 lines max)
  * Description (3 lines max)
  * Time badge (if available)
  * Location with icon
  * "Lihat Detail" button (purple)
  * "Daftar" button (green circle, if registration link exists)
- **Hover Effects:**
  * Card lift (-translate-y-2)
  * Shadow increase
  * Image scale
- **Past Events Section** - 6 items grid, smaller cards
- **Pagination** - Custom Laravel pagination

**URL Examples:**
```
/kegiatan                    → All events
/kegiatan?category=1         → Filter by category ID 1
/kegiatan?category=2&page=2  → Category 2, page 2
```

---

**2. `resources/views/events/show.blade.php`** - Detail Event

**Layout:**
```
┌─────────────────────────────────────────────────────────┐
│  Purple Gradient Hero Section                           │
│  ┌────────────┐  ┌──────────────────────────────────┐  │
│  │  Date Box  │  │  [Category Badge]                │  │
│  │  Sticky    │  │  Event Title (Large)             │  │
│  │            │  │  [Event Image Full Width]        │  │
│  │  Time      │  │                                  │  │
│  │  Location  │  └──────────────────────────────────┘  │
│  │  [Daftar]  │                                         │
│  └────────────┘                                         │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  📋 Tentang Kegiatan                                    │
│  Full description in white card                         │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  Kegiatan Mendatang Lainnya (Related Events)            │
│  [Event] [Event] [Event]  ← 3 cards                    │
│                                                         │
│            [Lihat Semua Kegiatan →]                     │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- **Hero Section:**
  * Gradient purple background
  * Breadcrumb navigation
  * 2-column layout (date sidebar + content)
  * Sticky date card (stays on scroll)
  * Category badge on title
  * Full-width event image

- **Date Card (Sidebar):**
  * White rounded card with shadow
  * Large date number (6xl font)
  * Month name
  * Year
  * Time badge (if available)
  * Location with icon
  * **"Daftar Sekarang" button** (green, prominent, if link exists)
  * Sticky positioning

- **Description Section:**
  * White card with large padding
  * Emoji icon (📋)
  * Prose styling for readability
  * Pre-formatted text (preserves line breaks)

- **Related Events:**
  * 3-column grid
  * Smaller cards with image
  * Category badge
  * Date + time
  * Location
  * Hover effects
  * Link to all events at bottom

---

## 🎨 Design System

### Color Palette
```css
Primary Purple:   #7C3AED (purple-600)
Dark Purple:      #6D28D9 (purple-700)
Light Purple:     #EDE9FE (purple-50)
Green (CTA):      #10B981 (green-500)
Text Dark:        #111827 (gray-900)
Text Light:       #6B7280 (gray-500)
```

### Typography
```css
Headings:         font-bold, tracking-tight
Body:             text-gray-700, leading-relaxed
Small:            text-sm, text-xs
```

### Components

**Event Card:**
- Border radius: 2xl (rounded-2xl)
- Shadow: lg → 2xl on hover
- Transition: all 300ms
- Transform: translateY(-8px) on hover

**Badges:**
- Category: `bg-purple-100 text-purple-700`
- Status: `bg-green-100 text-green-800` (Published)
- Time: `bg-white/20 text-white` (on gradients)

**Buttons:**
- Primary: `bg-purple-600 hover:bg-purple-700`
- Success: `bg-green-500 hover:bg-green-600`
- Rounded: `rounded-lg` or `rounded-xl`

---

## 📊 Database Schema

### Table: `events`

```sql
id                  bigint (PK, auto_increment)
title               varchar(255)
slug                varchar(255) UNIQUE
category_id         bigint (FK to categories) NULLABLE  ← NEW!
description         text
image               varchar(255) NULLABLE
location            varchar(255) NULLABLE
event_date          date
event_time          time NULLABLE
registration_link   varchar(255) NULLABLE
is_published        boolean (default: 0)
is_featured         boolean (default: 0)
created_at          timestamp
updated_at          timestamp

FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
```

### Migration
File: `database/migrations/2025_11_13_120000_add_category_id_to_events_table.php`

---

## 🔧 Cara Menggunakan

### Admin Panel

#### 1. Membuat Event Baru
1. Login ke admin panel
2. Menu **Kegiatan** → **Tambah Kegiatan**
3. Isi form:
   - **Judul**: Judul kegiatan (required)
   - **Kategori**: Pilih kategori (optional) - Webinar, Workshop, Seminar, dll
   - **Gambar**: Upload gambar (required, max 2MB, 800x600px recommended)
   - **Deskripsi**: Deskripsi lengkap kegiatan
   - **Tanggal**: Tanggal pelaksanaan (required)
   - **Waktu**: Jam pelaksanaan (optional, format HH:MM)
   - **Lokasi**: Tempat/platform pelaksanaan (required)
   - **Link Pendaftaran**: URL untuk pendaftaran (optional)
   - **Publikasikan**: Centang untuk publish ke public
   - **Tampilkan di Homepage**: Centang untuk featured di homepage slider
4. Klik **Simpan Kegiatan**

#### 2. Edit Event
1. Menu **Kegiatan** → Klik **Edit** pada event yang ingin diubah
2. Update field yang diperlukan (kategori, tanggal, dll)
3. Upload gambar baru (optional, jika ingin ganti gambar)
4. Klik **Update Kegiatan**

#### 3. Mengelola Kategori
1. Menu **Kategori**
2. Buat kategori baru: "Webinar", "Workshop", "Seminar Nasional", "Rapat Koordinasi", dll
3. Kategori yang sama digunakan untuk Berita dan Event
4. Kategori akan muncul sebagai filter di halaman public

---

### Halaman Public

#### URL Structure
```
/kegiatan                  → All upcoming events
/kegiatan?category=1       → Filter by category
/kegiatan/{slug}           → Event detail page
```

#### Features untuk User

**1. Browse Events (/kegiatan)**
- View all upcoming events in modern card grid
- Filter by category using pills at top
- See event date, time, location, category
- Click card or "Lihat Detail" button to view details
- Quick register via green button (if registration link available)
- See past events at bottom

**2. Event Detail (/kegiatan/{slug})**
- Large hero section with event info
- Sticky date card with quick registration
- Full description
- Related events recommendations
- Back to all events button

---

## 🎯 Key Features

### 1. Category System
- ✅ Dropdown in admin create/edit forms
- ✅ Badge display on event cards
- ✅ Filter pills in public index page
- ✅ URL parameter support (`?category=1`)
- ✅ Share categories with News model

### 2. Registration System
- ✅ Optional registration_link field
- ✅ Green "Daftar Sekarang" button (very visible)
- ✅ Opens in new tab
- ✅ Only shows if link is provided

### 3. Featured Events
- ✅ Checkbox in admin form
- ✅ Can be displayed in homepage slider
- ✅ Separate query in HomeController

### 4. Image Handling
- ✅ Upload with preview in admin
- ✅ Validation: JPG, PNG, GIF, WEBP max 2MB
- ✅ Storage in `storage/app/public/events/`
- ✅ Auto-delete old image on update
- ✅ Fallback gradient if no image

### 5. Date & Time
- ✅ event_date (required) - Date picker
- ✅ event_time (optional) - Time picker
- ✅ Format display: "13 November 2025" + "13:00 WIB"
- ✅ Upcoming filter: Only show future events

### 6. SEO Friendly
- ✅ Slug generation from title
- ✅ Unique slug constraint
- ✅ Breadcrumb navigation
- ✅ Semantic HTML structure

---

## 🚀 Performance Optimizations

1. **Eager Loading**
   ```php
   ->with('category')  // Prevent N+1 queries
   ```

2. **Pagination**
   ```php
   ->paginate(12)  // Limit results per page
   ```

3. **Image Optimization**
   - Recommended size: 800x600px
   - Max upload: 2MB
   - Formats: JPG, PNG, GIF, WEBP

4. **Query Scopes**
   ```php
   ->published()->upcoming()  // Filter at DB level
   ```

5. **Caching Ready**
   - Can add cache layer for categories
   - Homepage events already cached in HomeController

---

## 📱 Responsive Breakpoints

```css
Mobile:    < 768px  → 1 column grid
Tablet:    768px+   → 2 columns grid
Desktop:   1024px+  → 3 columns grid
```

**Sticky Elements:**
- Date card sidebar (desktop only)
- Header/navbar (all devices)

---

## 🎨 Animation Details

### Blob Background Animation
```css
@keyframes blob {
    0%, 100%  → translate(0, 0) scale(1)
    33%       → translate(30px, -50px) scale(1.1)
    66%       → translate(-20px, 20px) scale(0.9)
}
Duration: 7s infinite
```

### Card Hover Effects
```css
- Transform: translateY(-8px)
- Shadow: lg → 2xl
- Scale image: 1 → 1.1
- Transition: 300ms ease
```

---

## 🔒 Security

1. **Validation**
   - All inputs validated (required, max length, format)
   - Image mime type validation
   - URL validation for registration_link

2. **Authorization**
   - Admin routes protected by `auth:admin` middleware
   - CSRF token on all forms
   - File upload size limit (2MB)

3. **XSS Protection**
   - Blade escaping: `{{ }}` for user input
   - `e()` helper for manual escaping
   - `{!! !!}` only for trusted HTML (descriptions)

---

## 📈 Future Enhancements

Possible additions:
- [ ] Calendar view integration
- [ ] iCal export
- [ ] Email notifications for new events
- [ ] Event registration form (internal)
- [ ] Attendee management
- [ ] Event tags system
- [ ] Multiple categories per event
- [ ] Event series/recurring events
- [ ] Social media share buttons
- [ ] Comments/Q&A section

---

## 🐛 Troubleshooting

### Issue: Category dropdown empty
**Solution:** Make sure you have categories created in **Kategori** menu

### Issue: Image not displaying
**Solution:** 
1. Check storage link: `php artisan storage:link`
2. Verify file exists in `storage/app/public/events/`
3. Check file permissions

### Issue: Past events showing in upcoming
**Solution:** Check server date/time, ensure `event_date` is correct

### Issue: Filter not working
**Solution:** Clear route cache: `php artisan route:clear`

---

## 📝 Code Examples

### Creating Event Programmatically
```php
use App\Models\Event;
use Illuminate\Support\Str;

Event::create([
    'title' => 'Webinar: Etika Publikasi Ilmiah',
    'slug' => Str::slug('Webinar: Etika Publikasi Ilmiah'),
    'category_id' => 1,
    'description' => 'Webinar tentang etika publikasi...',
    'event_date' => '2025-11-27',
    'event_time' => '13:00:00',
    'location' => 'Online via Zoom',
    'registration_link' => 'https://example.com/register',
    'is_published' => true,
    'is_featured' => false,
]);
```

### Querying Events
```php
// Get all upcoming published events
$events = Event::published()->upcoming()->get();

// Get events by category
$events = Event::where('category_id', 1)->published()->get();

// Get featured events for homepage
$featured = Event::published()->featured()->get();
```

---

## ✅ Testing Checklist

- [ ] Create new event via admin
- [ ] Upload image and verify display
- [ ] Edit event and change category
- [ ] Delete event
- [ ] View public index page
- [ ] Filter by category
- [ ] Navigate pagination
- [ ] View event detail page
- [ ] Click registration link (opens new tab)
- [ ] View related events
- [ ] Test on mobile device
- [ ] Check responsive design
- [ ] Verify hover animations
- [ ] Test with no image
- [ ] Test with no registration link
- [ ] Verify past events section

---

**Created:** 13 November 2025  
**Version:** 1.0  
**Status:** Production Ready ✅
