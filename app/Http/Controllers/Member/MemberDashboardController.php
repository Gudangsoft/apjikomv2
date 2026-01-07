<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Journal;
use App\Models\News;
use App\Models\Member;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MemberDashboardController extends Controller
{
    /**
     * Show member login form
     */
    public function showLogin()
    {
        // Generate simple math CAPTCHA
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session([
            'member_captcha_num1' => $num1, 
            'member_captcha_num2' => $num2, 
            'member_captcha_answer' => $num1 + $num2
        ]);
        
        return view('member.login');
    }

    /**
     * Handle member login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha_answer' => 'required|numeric',
        ], [
            'captcha_answer.required' => 'Jawaban CAPTCHA harus diisi.',
            'captcha_answer.numeric' => 'Jawaban CAPTCHA harus berupa angka.',
        ]);
        
        // Validate CAPTCHA
        $expectedAnswer = session('member_captcha_answer');
        $userAnswer = $request->input('captcha_answer');
        
        if (!$expectedAnswer || $userAnswer != $expectedAnswer) {
            session()->forget(['member_captcha_num1', 'member_captcha_num2', 'member_captcha_answer']);
            return back()->withErrors([
                'captcha_answer' => 'Jawaban CAPTCHA salah. Silakan coba lagi.'
            ])->withInput($request->except('password', 'captcha_answer'));
        }
        
        // Clear CAPTCHA from session after validation
        session()->forget(['member_captcha_num1', 'member_captcha_num2', 'member_captcha_answer']);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Check if email exists in users table
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            // Check if email exists in pending registrations
            $registration = \App\Models\Registration::where('email', $request->email)
                ->where('status', 'pending')
                ->first();
            
            if ($registration) {
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda sudah terdaftar tetapi belum divalidasi oleh admin. Silakan tunggu proses validasi.',
                ]);
            }
            
            // Email not found anywhere
            throw ValidationException::withMessages([
                'email' => 'Akun belum terdaftar. Silakan lakukan pendaftaran terlebih dahulu. Silahkan hubungi Admin untuk informasi lebih lanjut.',
            ]);
        }

        // Try to login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Clear failed attempts on successful login
            $failedKey = 'login_failed_' . $request->email;
            session()->forget([$failedKey, 'show_reset_password']);
            
            // Check if user has member record
            if (!Auth::user()->member) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda belum terdaftar sebagai member.',
                ]);
            }

            // Check if this is first login (password is still default)
            $user = Auth::user();
            if (Hash::check('password123', $user->password)) {
                session()->flash('first_login', true);
            }

            return redirect()->intended(route('member.dashboard'));
        }

        // Track failed attempts per email
        $failedKey = 'login_failed_' . $request->email;
        $attempts = (int) session($failedKey, 0) + 1;
        session([$failedKey => $attempts]);
        
        // Set flag to show reset password option after 3 failed attempts
        if ($attempts >= 3) {
            session(['show_reset_password' => true]);
        }

        // Email exists but password is wrong
        throw ValidationException::withMessages([
            'password' => 'Password yang digunakan salah. Silakan coba lagi.',
        ]);
    }

    /**
     * Show member dashboard
     */
    public function index()
    {
        try {
            $member = Auth::user()->member;
            
            if (!$member) {
                return redirect()->route('home')
                    ->with('error', 'Anda belum terdaftar sebagai member.');
            }

            // Check if profile is incomplete (no photo or missing important data)
            $needsProfileUpdate = false;
            $missingItems = [];
            
            if (!$member->photo) {
                $needsProfileUpdate = true;
                $missingItems[] = 'Foto profil';
            }
            
            if (!$member->address || strlen($member->address) < 10) {
                $needsProfileUpdate = true;
                $missingItems[] = 'Alamat lengkap';
            }
            
            if (!$member->phone) {
                $needsProfileUpdate = true;
                $missingItems[] = 'Nomor telepon';
            }

            // Statistics
            $stats = [
                'total_members' => Member::where('status', 'active')->count(),
                'total_news' => News::where('is_published', true)->count(),
                'total_events' => Event::where('is_published', true)->count(),
                'total_journals' => Journal::where('is_published', true)->count(),
                'upcoming_events' => Event::where('is_published', true)
                    ->where('event_date', '>=', now())
                    ->count(),
            ];

            // Recent activities
            $recentNews = News::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();

            $upcomingEvents = Event::where('is_published', true)
                ->where('event_date', '>=', now())
                ->orderBy('event_date', 'asc')
                ->take(3)
                ->get();

            $recentJournals = Journal::where('is_published', true)
                ->orderBy('published_date', 'desc')
                ->take(3)
                ->get();

            // Member growth data (last 6 months)
            $memberGrowth = Member::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

            // Get active social media
            $socialMedia = SocialMedia::active()->ordered()->get();

            return view('member.dashboard', compact(
                'member', 
                'needsProfileUpdate', 
                'missingItems',
                'stats',
                'recentNews',
                'upcomingEvents',
                'recentJournals',
                'memberGrowth',
                'socialMedia'
            ));
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            // Return with safe defaults
            $member = Auth::user()->member ?? new \App\Models\Member();
            $needsProfileUpdate = false;
            $missingItems = [];
            $stats = [
                'total_members' => 0,
                'total_news' => 0,
                'total_events' => 0,
                'total_journals' => 0,
                'upcoming_events' => 0,
            ];
            $recentNews = collect();
            $upcomingEvents = collect();
            $recentJournals = collect();
            $memberGrowth = collect();
            $socialMedia = collect();
            
            return view('member.dashboard', compact(
                'member', 
                'needsProfileUpdate', 
                'missingItems',
                'stats',
                'recentNews',
                'upcomingEvents',
                'recentJournals',
                'memberGrowth',
                'socialMedia'
            ));
        }
    }

    /**
     * Show member profile
     */
    public function profile()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }
        
        return view('member.profile-v2', compact('member'));
    }

    /**
     * Show member card
     */
    public function card()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }

        return view('member.card', compact('member'));
    }

    /**
     * Update member profile
     */
    public function updateProfile(Request $request)
    {
        \Log::info('=== UPDATE PROFILE CALLED ===');
        \Log::info('Request data:', $request->all());
        
        $member = Auth::user()->member;
        $user = Auth::user();
        
        if (!$member) {
            \Log::error('User has no member record');
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }

        \Log::info('Member found:', ['id' => $member->id, 'user_id' => $user->id]);

        // Validate input
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'institution_name' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'address' => 'nullable|string',
                'show_in_directory' => 'nullable|boolean',
                'expertise' => 'nullable|string|max:300',
                'bio' => 'nullable|string',
                'linkedin' => 'nullable|url|max:255',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'google_scholar_link' => 'nullable|url|max:255',
                'sinta_link' => 'nullable|url|max:255',
                'orcid_link' => 'nullable|url|max:255',
                'scopus_link' => 'nullable|url|max:255',
                'cv_file' => 'sometimes|nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB
                'delete_cv' => 'nullable|in:0,1',
            ], [
                'name.required' => 'Nama lengkap harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'website.url' => 'Format website tidak valid',
                'linkedin.url' => 'Format URL LinkedIn tidak valid',
                'facebook.url' => 'Format URL Facebook tidak valid',
                'expertise.max' => 'Keahlian maksimal 300 karakter',
                'cv_file.mimes' => 'CV harus berformat PDF, DOC, atau DOCX',
                'cv_file.max' => 'Ukuran CV maksimal 5MB',
            ]);
            
            // Validate bio word count (300 words max)
            if ($request->filled('bio')) {
                $wordCount = str_word_count($request->bio);
                if ($wordCount > 300) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'bio' => "Biografi maksimal 300 kata. Saat ini: {$wordCount} kata."
                    ]);
                }
            }
            
            \Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            throw $e;
        }

        // Update user data
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            \Log::info('User updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update user:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Gagal update user: ' . $e->getMessage());
        }

        // Handle CV file upload
        if ($request->hasFile('cv_file')) {
            // Delete old CV if exists
            if ($member->cv_file && Storage::disk('public')->exists($member->cv_file)) {
                Storage::disk('public')->delete($member->cv_file);
            }
            
            // Upload new CV
            $cvPath = $request->file('cv_file')->store('cv', 'public');
            $member->cv_file = $cvPath;
        }
        
        // Handle CV deletion
        if ($request->delete_cv == '1' && $member->cv_file) {
            if (Storage::disk('public')->exists($member->cv_file)) {
                Storage::disk('public')->delete($member->cv_file);
            }
            $member->cv_file = null;
        }

        // Update member data
        try {
            $member->update([
                'phone' => $request->phone,
                'institution_name' => $request->institution_name,
                'position' => $request->position,
                'website' => $request->website,
                'address' => $request->address,
                'show_in_directory' => $request->show_in_directory == '1' ? true : false,
                'expertise' => $request->expertise,
                'bio' => $request->bio,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'google_scholar_link' => $request->google_scholar_link,
                'sinta_link' => $request->sinta_link,
                'orcid_link' => $request->orcid_link,
                'scopus_link' => $request->scopus_link,
                'cv_file' => $member->cv_file,
            ]);
            \Log::info('Member updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update member:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Gagal update member: ' . $e->getMessage());
        }

        \Log::info('Profile update completed successfully');
        
        // Check if profile is now complete
        $profileComplete = $member->photo && 
                          $member->address && 
                          strlen($member->address) >= 10 && 
                          $member->phone;

        if ($profileComplete && !$member->member_card) {
            return redirect()->route('member.profile')
                ->with('success', 'Profil berhasil diperbarui!')
                ->with('profile_complete', true);
        }
        
        return redirect()->route('member.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Upload member photo
     */
    public function uploadPhoto(Request $request)
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'photo.required' => 'Foto harus diunggah',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Foto harus dalam format JPG atau PNG',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Delete old photo if exists
        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        // Store new photo
        $photoPath = $request->file('photo')->store('member-photos', 'public');

        // Update member record
        $member->update([
            'photo' => $photoPath,
        ]);
        
        // Update user record (untuk tampil di direktori)
        Auth::user()->update([
            'photo' => $photoPath,
        ]);

        // Check if profile is now complete
        $profileComplete = $member->photo && 
                          $member->address && 
                          strlen($member->address) >= 10 && 
                          $member->phone;

        if ($profileComplete && !$member->member_card) {
            return redirect()->route('member.profile')
                ->with('success', 'Foto profil berhasil diunggah!')
                ->with('profile_complete', true);
        }

        return redirect()->route('member.profile')
            ->with('success', 'Foto profil berhasil diunggah!');
    }

    /**
     * Delete member photo
     */
    public function deletePhoto()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }

        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->update([
            'photo' => null,
        ]);
        
        // Update user record juga
        Auth::user()->update([
            'photo' => null,
        ]);

        return redirect()->route('member.profile')
            ->with('success', 'Foto profil berhasil dihapus!');
    }

    /**
     * Update user name
     */
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('member.profile')
            ->with('success', 'Nama berhasil diperbarui!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password baru minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('member.profile')
                ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('member.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Request member card generation
     */
    public function requestCard()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('home')
                ->with('error', 'Anda belum terdaftar sebagai member.');
        }

        // Check if profile is complete
        if (!$member->photo || !$member->address || !$member->phone) {
            return redirect()->route('member.profile')
                ->with('error', 'Profil harus dilengkapi terlebih dahulu sebelum request kartu!');
        }

        // Check if already has card
        if ($member->member_card) {
            return redirect()->route('member.profile')
                ->with('info', 'Anda sudah memiliki kartu anggota.');
        }

        // Check if already requested
        if ($member->card_requested) {
            return redirect()->route('member.profile')
                ->with('info', 'Permintaan kartu Anda sedang diproses oleh admin.');
        }

        // Mark as requested
        $member->update([
            'card_requested' => true,
            'card_requested_at' => now(),
        ]);

        // Notify admins
        \App\Services\NotificationService::memberRequestedCard(Auth::user());

        return redirect()->route('member.profile')
            ->with('success', 'Permintaan kartu anggota berhasil dikirim! Admin akan segera memproses.');
    }

    public function requestCardUpdate(Request $request)
    {
        $member = Auth::user()->member;

        if (!$member) {
            return redirect()->route('member.profile')->with('error', 'Anda belum terdaftar sebagai member.');
        }

        // Validasi: Pastikan sudah punya kartu
        if (!$member->member_card) {
            return redirect()->back()->with('error', 'Anda belum memiliki kartu anggota. Silakan request kartu baru terlebih dahulu.');
        }

        // Validasi: Cek apakah sudah request update sebelumnya
        if ($member->card_update_requested) {
            return redirect()->back()->with('info', 'Permintaan update kartu Anda sedang diproses oleh admin.');
        }

        // Validasi: Pastikan data lengkap
        if (!$member->photo || !$member->address || !$member->phone) {
            return redirect()->back()->with('error', 'Mohon lengkapi data profil Anda (foto, alamat, dan telepon) sebelum request update kartu.');
        }

        // Update status request
        $member->update([
            'card_update_requested' => true,
            'card_update_requested_at' => now(),
        ]);

        // Notify admins
        \App\Services\NotificationService::memberRequestedCardUpdate(Auth::user());

        return redirect()->back()->with('success', 'Permintaan update kartu anggota berhasil diajukan! Admin akan segera memproses.');
    }
    
    /**
     * Request password reset from admin
     */
    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ], [
            'reason.required' => 'Alasan permintaan reset password harus diisi.',
            'reason.max' => 'Alasan terlalu panjang (maksimal 500 karakter).',
        ]);
        
        $user = Auth::user();
        
        // Check if there's already a pending request
        $existingRequest = \App\Models\PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existingRequest) {
            return back()->with('error', 'Anda sudah memiliki permintaan reset password yang sedang diproses.');
        }
        
        // Create new request
        $resetRequest = \App\Models\PasswordResetRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);
        
        // Create notification for all admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'password_reset_request',
                'title' => 'Permintaan Reset Password',
                'message' => "{$user->name} meminta reset password. Alasan: " . $request->reason,
                'icon' => 'key',
                'color' => 'yellow',
                'action_url' => route('admin.password-reset-requests.index'),
                'action_text' => 'Lihat Permintaan',
            ]);
        }
        
        return back()->with('success', 'Permintaan reset password berhasil dikirim. Admin akan segera memprosesnya.');
    }
    
    /**
     * Show update requests page for member
     */
    public function updateRequests()
    {
        $updateRequests = \App\Models\UpdateRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('member.update-requests.index', compact('updateRequests'));
    }
    
    /**
     * Show single update request
     */
    public function showUpdateRequest(\App\Models\UpdateRequest $updateRequest)
    {
        // Ensure user can only view their own requests
        if ($updateRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('member.update-requests.show', compact('updateRequest'));
    }
}
