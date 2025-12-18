<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDirectoryController;
use App\Http\Controllers\Member\TestimonialController as MemberTestimonialController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\AboutSettingController as AdminAboutSettingController;
use App\Http\Controllers\Admin\PaymentSettingController as AdminPaymentSettingController;
use App\Http\Controllers\Admin\FooterSettingController as AdminFooterSettingController;
use App\Http\Controllers\Admin\EmailSettingController as AdminEmailSettingController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\MigrationController as AdminMigrationController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\SectionLabelController as AdminSectionLabelController;
use App\Http\Controllers\Admin\MemberCardTemplateController as AdminMemberCardTemplateController;
use App\Http\Controllers\Admin\ChangelogController as AdminChangelogController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// About & Services Routes
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about.index');
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');

// News Routes
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Events Routes
Route::get('/kegiatan', [EventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('events.show');

// Journal Routes
Route::get('/jurnal', [JournalController::class, 'index'])->name('journals.index');
Route::get('/jurnal/{journal}', [JournalController::class, 'show'])->name('journals.show');
Route::get('/jurnal/{journal}/download', [JournalController::class, 'download'])->name('journals.download');

// Journal Divisions Routes (Public)
Route::get('/journal-divisions', [App\Http\Controllers\JournalDivisionController::class, 'publicIndex'])->name('journal-divisions.index');

// Member Directory Routes (Public)
Route::get('/anggota', [MemberDirectoryController::class, 'index'])->name('directory.index');
Route::get('/anggota/{member}', [MemberDirectoryController::class, 'show'])->name('directory.show');

// Page Routes (Dynamic Pages)
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Registration Routes
Route::get('/daftar-anggota', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/daftar-anggota', [RegistrationController::class, 'store'])->name('registration.store');

// Redirect old routes to new registration
Route::get('/daftar-member', function() {
    return redirect('/daftar-anggota');
});
Route::get('/member/register', function() {
    return redirect('/daftar-anggota');
});

// Member Login
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\Member\EventRegistrationController;

Route::get('/member/login', [MemberDashboardController::class, 'showLogin'])->name('member.login')->middleware('guest');
Route::post('/member/login', [MemberDashboardController::class, 'login'])->name('member.login.post');

// Member Dashboard (Protected)
Route::prefix('member')->name('member.')->middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [MemberDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [MemberDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/update-name', [MemberDashboardController::class, 'updateName'])->name('profile.update-name');
    Route::put('/profile/update-password', [MemberDashboardController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/upload-photo', [MemberDashboardController::class, 'uploadPhoto'])->name('profile.upload-photo');
    Route::delete('/profile/delete-photo', [MemberDashboardController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::post('/request-card', [MemberDashboardController::class, 'requestCard'])->name('request-card');
    Route::post('/request-card-update', [MemberDashboardController::class, 'requestCardUpdate'])->name('request-card-update');
    
    // Password Reset Request
    Route::post('/password-reset-request', [MemberDashboardController::class, 'requestPasswordReset'])->name('password-reset-request');
    
    Route::get('/card', [MemberDashboardController::class, 'card'])->name('card');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    
    // Event RSVP
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/cancel', [EventRegistrationController::class, 'cancel'])->name('events.cancel');
    Route::post('/events/{event}/upload-payment', [EventRegistrationController::class, 'uploadPayment'])->name('events.upload-payment');
    Route::get('/events/{event}/certificate', [EventRegistrationController::class, 'downloadCertificate'])->name('events.certificate');
    Route::get('/my-events', [EventRegistrationController::class, 'myEvents'])->name('events.my');
    
    // Member Testimonials
    Route::resource('testimonials', MemberTestimonialController::class)->except(['show']);
    
    // Member Update Requests
    Route::get('/update-requests', [MemberDashboardController::class, 'updateRequests'])->name('update-requests.index');
    Route::post('/update-requests', [AdminChangelogController::class, 'storeRequest'])->name('update-requests.store');
    Route::get('/update-requests/{updateRequest}', [MemberDashboardController::class, 'showUpdateRequest'])->name('update-requests.show');
    
    // Member Assignments (Penugasan Editor)
    Route::get('/assignments', [App\Http\Controllers\Member\AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{assignment}', [App\Http\Controllers\Member\AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/download', [App\Http\Controllers\Member\AssignmentController::class, 'download'])->name('assignments.download');
    Route::patch('/assignments/{assignment}/status', [App\Http\Controllers\Member\AssignmentController::class, 'updateStatus'])->name('assignments.update-status');
});

// Public FAQs
Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faqs.index');

// Public Gallery
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');

// Public Testimonials
Route::get('/testimonials', [App\Http\Controllers\TestimonialController::class, 'index'])->name('testimonials.index');

// Public Institutions
Route::get('/institutions', [App\Http\Controllers\InstitutionController::class, 'index'])->name('institutions.index');

// Dashboard (Admin fallback)
Route::get('/dashboard', [MemberController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Image Upload for TinyMCE
    Route::post('/upload-image', [App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('upload-image');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    
    // Events Management
    Route::resource('events', AdminEventController::class);
    Route::get('events/{event}/participants', [AdminEventController::class, 'participants'])->name('events.participants');
    Route::post('events/{event}/participants/{registration}/verify-payment', [AdminEventController::class, 'verifyPayment'])->name('events.verify-payment');
    Route::post('events/{event}/participants/{registration}/update-status', [AdminEventController::class, 'updateRegistrationStatus'])->name('events.update-registration-status');
    
    // Members Management
    Route::get('members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::get('members/{member}', [AdminMemberController::class, 'show'])->name('members.show');
    Route::post('members/{member}/approve', [AdminMemberController::class, 'approve'])->name('members.approve');
    Route::post('members/{member}/reject', [AdminMemberController::class, 'reject'])->name('members.reject');
    Route::delete('members/{member}', [AdminMemberController::class, 'destroy'])->name('members.destroy');
    
    // Member Card Management
    Route::get('members/{member}/upload-card', [AdminMemberController::class, 'showUploadCard'])->name('members.upload-card');
    Route::post('members/{member}/upload-card', [AdminMemberController::class, 'uploadCard'])->name('members.upload-card.store');
    Route::post('members/{member}/generate-card', [AdminMemberController::class, 'generateCard'])->name('members.generate-card');
    Route::delete('members/{member}/delete-card', [AdminMemberController::class, 'deleteCard'])->name('members.delete-card');
    
    // Member Photo Management
    Route::post('members/{member}/upload-photo', [AdminMemberController::class, 'uploadPhoto'])->name('members.upload-photo');
    Route::delete('members/{member}/delete-photo', [AdminMemberController::class, 'deletePhoto'])->name('members.delete-photo');
    
    // Member Verification
    Route::post('members/{member}/verify', [AdminMemberController::class, 'verify'])->name('members.verify');
    Route::post('members/{member}/unverify', [AdminMemberController::class, 'unverify'])->name('members.unverify');
    Route::post('members/{member}/upload-verification-document', [AdminMemberController::class, 'uploadVerificationDocument'])->name('members.upload-verification-document');
    Route::post('members/bulk-verify', [AdminMemberController::class, 'bulkVerify'])->name('members.bulk-verify');
    
    // Member Card Templates
    Route::resource('card-templates', AdminMemberCardTemplateController::class);
    Route::post('card-templates/{cardTemplate}/activate', [AdminMemberCardTemplateController::class, 'activate'])->name('card-templates.activate');
    
    // Categories Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Registrations Management
    Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::put('registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.update-status');
    Route::delete('registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');
    
    // Settings Management
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    
    // About Settings Management
    Route::get('about-settings', [AdminAboutSettingController::class, 'index'])->name('about-settings.index');
    Route::put('about-settings', [AdminAboutSettingController::class, 'update'])->name('about-settings.update');
    
    // Payment Settings Management
    Route::get('payment-settings', [AdminPaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::put('payment-settings', [AdminPaymentSettingController::class, 'update'])->name('payment-settings.update');
    
    // Footer Settings Management
    Route::get('footer-settings', [AdminFooterSettingController::class, 'index'])->name('footer-settings.index');
    Route::put('footer-settings', [AdminFooterSettingController::class, 'update'])->name('footer-settings.update');
    
    // Email Settings Management
    Route::get('email-settings', [AdminEmailSettingController::class, 'index'])->name('email-settings.index');
    Route::put('email-settings', [AdminEmailSettingController::class, 'update'])->name('email-settings.update');
    Route::post('email-settings/test', [AdminEmailSettingController::class, 'testConnection'])->name('email-settings.test');
    
    // Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/bulk-delete', [App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    
    // Sliders Management
    Route::resource('sliders', AdminSliderController::class);
    
    // Pages Management
    Route::resource('pages', AdminPageController::class);
    
    // Menus Management
    Route::resource('menus', AdminMenuController::class);
    Route::post('menus/update-order', [AdminMenuController::class, 'updateOrder'])->name('menus.update-order');
    
    // Partners Management
    Route::resource('partners', AdminPartnerController::class);
    Route::post('partners/update-order', [AdminPartnerController::class, 'updateOrder'])->name('partners.update-order');
    
    // Journals Management
    Route::resource('journals', App\Http\Controllers\Admin\JournalController::class);
    Route::get('journals/{journal}/download', [App\Http\Controllers\Admin\JournalController::class, 'download'])->name('journals.download');
    
    // Journal Divisions Management
    Route::resource('journal-divisions', App\Http\Controllers\JournalDivisionController::class);
    
    // Admin Notifications
    Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('notifications/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    
    // Password Reset Requests
    Route::get('password-reset-requests', [App\Http\Controllers\Admin\PasswordResetRequestController::class, 'index'])->name('password-reset-requests.index');
    Route::post('password-reset-requests/{request}/approve', [App\Http\Controllers\Admin\PasswordResetRequestController::class, 'approve'])->name('password-reset-requests.approve');
    Route::post('password-reset-requests/{request}/reject', [App\Http\Controllers\Admin\PasswordResetRequestController::class, 'reject'])->name('password-reset-requests.reject');
    
    // Admin Assignments (Penugasan Editor)
    Route::resource('assignments', AdminAssignmentController::class);
    
    // Institutions Management
    Route::resource('institutions', App\Http\Controllers\Admin\InstitutionController::class);
    
    // FAQs Management
    Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);
    
    // Testimonials Management
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class);
    Route::post('testimonials/{testimonial}/toggle-featured', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    
    // Gallery Management
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
    Route::post('galleries/{gallery}/toggle-featured', [App\Http\Controllers\Admin\GalleryController::class, 'toggleFeatured'])->name('galleries.toggle-featured');
    
    // Section Labels Management
    Route::get('section-labels', [AdminSectionLabelController::class, 'index'])->name('section-labels.index');
    Route::put('section-labels/bulk-update', [AdminSectionLabelController::class, 'bulkUpdate'])->name('section-labels.bulk-update');
    Route::put('section-labels/{id}', [AdminSectionLabelController::class, 'update'])->name('section-labels.update');
    
    // About Page Management
    Route::get('about-page', [App\Http\Controllers\Admin\AboutPageController::class, 'index'])->name('about-page.index');
    Route::put('about-page', [App\Http\Controllers\Admin\AboutPageController::class, 'update'])->name('about-page.update');
    
    // Organizational Structure Management
    Route::resource('organizational-structure', App\Http\Controllers\Admin\OrganizationalStructureController::class);
    
    // Services Management
    Route::resource('services', App\Http\Controllers\Admin\ServiceManagementController::class);
    
    // Changelog Management
    Route::get('changelog/latest', [AdminChangelogController::class, 'getLatest'])->name('changelog.latest');
    Route::resource('changelog', AdminChangelogController::class);
    Route::post('update-requests', [AdminChangelogController::class, 'storeRequest'])->name('update-requests.store');
    Route::put('update-requests/{updateRequest}/status', [AdminChangelogController::class, 'updateRequestStatus'])->name('update-requests.status');
    Route::delete('update-requests/{updateRequest}', [AdminChangelogController::class, 'destroyRequest'])->name('update-requests.destroy');
    
    // Migration Helper (Development Only)
    Route::get('run-migration', [AdminMigrationController::class, 'showMigrationForm'])->name('run-migration');
    Route::post('run-migration', [AdminMigrationController::class, 'runMigration'])->name('run-migration.execute');
});

require __DIR__.'/auth.php';
