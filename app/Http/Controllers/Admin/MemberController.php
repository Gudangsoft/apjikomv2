<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Registration;
use App\Services\MemberCardGenerator;
use App\Services\NotificationService;
use App\Models\User;
use App\Exports\MembersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'members');
        
        // MEMBERS TAB
        $queryMembers = Member::with('user')->latest();
        
        // Search members
        if ($request->filled('search') && $tab === 'members') {
            $search = $request->search;
            
            // Get user IDs that match the search
            $userIds = User::where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->pluck('id');
            
            $queryMembers->where(function($q) use ($search, $userIds) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhereIn('user_id', $userIds);
            });
        }
        
        // Status filter
        if ($request->filled('status') && $tab === 'members') {
            $queryMembers->where('status', $request->status);
        }
        
        // Member type filter
        if ($request->filled('type') && $tab === 'members') {
            $queryMembers->where('member_type', $request->type);
        }
        
        // Verification filter
        if ($request->has('verified') && $request->verified !== '' && $tab === 'members') {
            $queryMembers->where('is_verified', $request->verified);
        }
        
        // Card status filter
        if ($request->has('has_card') && $request->has_card !== '' && $tab === 'members') {
            if ($request->has_card == '1') {
                $queryMembers->whereNotNull('member_card');
            } else {
                $queryMembers->whereNull('member_card');
            }
        }
        
        // Card request filter
        if ($request->has('card_requested') && $request->card_requested !== '' && $tab === 'members') {
            $queryMembers->where('card_requested', $request->card_requested);
        }
        
        // Card update request filter
        if ($request->has('card_update_requested') && $request->card_update_requested !== '' && $tab === 'members') {
            $queryMembers->where('card_update_requested', $request->card_update_requested);
        }
        
        // Date range filter
        if ($request->filled('date_from') && $tab === 'members') {
            $queryMembers->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to') && $tab === 'members') {
            $queryMembers->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sorting
        $sortBy = $request->input('sort', 'latest');
        
        if (in_array($sortBy, ['name', 'name_desc']) && $tab === 'members') {
            $queryMembers->select('members.*')
                  ->join('users', 'members.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sortBy === 'name' ? 'asc' : 'desc');
        } else {
            switch ($sortBy) {
                case 'oldest':
                    $queryMembers->oldest();
                    break;
                default:
                    $queryMembers->latest();
            }
        }
        
        $members = $queryMembers->paginate(15)->withQueryString();
        
        // REGISTRATIONS TAB
        $queryRegistrations = Registration::query();
        
        // Search registrations
        if ($request->filled('search') && $tab === 'registrations') {
            $search = $request->search;
            $queryRegistrations->where(function($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('institution', 'like', '%' . $search . '%');
            });
        }
        
        // Filter registrations by type
        if ($request->filled('reg_type') && $tab === 'registrations') {
            $queryRegistrations->where('type', $request->reg_type);
        }
        
        // Filter registrations by status
        if ($request->filled('reg_status') && $tab === 'registrations') {
            $queryRegistrations->where('status', $request->reg_status);
        }
        
        $registrations = $queryRegistrations->latest()->paginate(15)->withQueryString();
        
        // Stats - Get accurate total counts (not affected by filters)
        $stats = [
            'total_members' => Member::count(),
            'total_registrations' => Registration::count(),
            'card_requests' => Member::where('card_requested', true)->count(),
            'card_update_requests' => Member::where('card_update_requested', true)->count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
            'approved_registrations' => Registration::where('status', 'approved')->count(),
            'rejected_registrations' => Registration::where('status', 'rejected')->count(),
        ];

        return view('admin.members.index', compact('members', 'registrations', 'stats', 'tab'));
    }

    /**
     * Export members to Excel/CSV
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'csv'); // csv or excel
        
        // Get members with same filters as index method
        $queryMembers = Member::with('user')->latest();
        
        // Apply same filters as in index method
        if ($request->filled('search')) {
            $search = $request->search;
            $userIds = User::where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->pluck('id');
            
            $queryMembers->where(function($q) use ($search, $userIds) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhereIn('user_id', $userIds);
            });
        }
        
        if ($request->filled('status')) {
            $queryMembers->where('status', $request->status);
        }
        
        if ($request->filled('type')) {
            $queryMembers->where('member_type', $request->type);
        }
        
        if ($request->filled('verified')) {
            $queryMembers->where('is_verified', $request->verified);
        }
        
        $members = $queryMembers->get();
        
        $filename = 'members_export_' . date('Y-m-d_H-i-s');
        
        if ($format === 'excel') {
            return $this->exportExcel($members, $filename);
        } else {
            return $this->exportCsv($members, $filename);
        }
    }

    /**
     * Export members as CSV
     */
    private function exportCsv($members, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];
        
        $callback = function() use ($members) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fwrite($file, "\xEF\xBB\xBF");
            
            // Summary information
            fputcsv($file, ['LAPORAN DATA ANGGOTA APJIKOM']);
            fputcsv($file, ['Diekspor pada:', date('d/m/Y H:i:s')]);
            fputcsv($file, []);
            
            // Statistics
            $totalMembers = collect($members)->count();
            $activeMembers = collect($members)->where('status', 'active')->count();
            $verifiedMembers = collect($members)->where('is_verified', true)->count();
            $membersWithCity = collect($members)->whereNotNull('city')->where('city', '!=', '')->count();
            
            fputcsv($file, ['STATISTIK']);
            fputcsv($file, ['Total Anggota', $totalMembers]);
            fputcsv($file, ['Anggota Aktif', $activeMembers]);
            fputcsv($file, ['Anggota Terverifikasi', $verifiedMembers]);
            fputcsv($file, ['Anggota dengan Info Kota', $membersWithCity]);
            fputcsv($file, []);
            
            // CSV Headers
            fputcsv($file, [
                'No Anggota',
                'Nama Lengkap', 
                'Email',
                'Telepon',
                'Institusi',
                'Posisi',
                'Kota',
                'Provinsi',
                'Alamat',
                'Status',
                'Verifikasi',
                'Tanggal Bergabung',
                'Tipe Member',
                'Website'
            ]);
            
            // Data rows
            foreach ($members as $member) {
                fputcsv($file, [
                    $member->member_number ?? '-',
                    $member->user->name ?? '-',
                    $member->user->email ?? '-', 
                    $member->phone ?? '-',
                    $member->institution_name ?? '-',
                    $member->position ?? '-',
                    $member->city ?? '-',
                    $member->province ?? '-',
                    $member->address ?? '-',
                    ucfirst($member->status),
                    $member->is_verified ? 'Terverifikasi' : 'Belum Verifikasi',
                    $member->join_date ? $member->join_date->format('d/m/Y') : '-',
                    ucfirst($member->member_type),
                    $member->website ?? '-'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export members as Excel (using custom export class)
     */
    private function exportExcel($members, $filename)
    {
        $exporter = new MembersExport($members);
        return $exporter->export($filename);
    }

    public function show(Member $member)
    {
        $member->load('user');
        return view('admin.members.show', compact('member'));
    }

    public function approve(Member $member)
    {
        $member->update([
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil disetujui');
    }

    public function reject(Member $member)
    {
        $member->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil ditolak');
    }

    public function destroy(Member $member)
    {
        // Hapus member card jika ada
        if ($member->member_card && Storage::disk('public')->exists($member->member_card)) {
            Storage::disk('public')->delete($member->member_card);
        }
        
        $member->user->delete(); // This will cascade delete the member
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil dihapus');
    }

    /**
     * Bulk verify all unverified members
     */
    public function bulkVerify(Request $request)
    {
        $unverifiedCount = Member::where('is_verified', false)->count();
        
        if ($unverifiedCount === 0) {
            return redirect()->route('admin.members.index')
                ->with('info', 'Tidak ada member yang perlu diverifikasi.');
        }
        
        // Update all unverified members
        Member::where('is_verified', false)->update([
            'is_verified' => true,
            'verified_at' => now()
        ]);
        
        // Log activity
        \App\Helpers\ActivityLogger::log(
            'bulk_verify_members',
            'verified',
            'Member',
            "Bulk verified {$unverifiedCount} members"
        );
        
        return redirect()->route('admin.members.index')
            ->with('success', "Berhasil memverifikasi {$unverifiedCount} member!");
    }

    /**
     * Show form to upload member card
     */
    public function showUploadCard(Member $member)
    {
        $member->load('user');
        return view('admin.members.upload-card', compact('member'));
    }

    /**
     * Generate member card automatically
     */
    public function generateCard(Member $member)
    {
        try {
            $generator = new MemberCardGenerator();
            $cardPath = $generator->generate($member);

            // Determine if this is an update or new card
            $isUpdate = $member->card_update_requested && $member->member_card;

            // Reset card request status after generating
            $member->update([
                'card_requested' => false,
                'card_requested_at' => null,
                'card_update_requested' => false,
                'card_update_requested_at' => null,
            ]);

            // Send appropriate notification to member
            if ($isUpdate) {
                NotificationService::cardUpdateReady($member->user);
            } else {
                NotificationService::cardReady($member->user);
            }

            $message = $isUpdate ? 'Kartu anggota berhasil diperbarui!' : 'Kartu anggota berhasil di-generate!';
            
            return redirect()->route('admin.members.show', $member)
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.members.show', $member)
                ->with('error', 'Gagal generate kartu: ' . $e->getMessage());
        }
    }

    /**
     * Upload member card
     */
    public function uploadCard(Request $request, Member $member)
    {
        $validated = $request->validate([
            'member_card' => 'required|image|mimes:jpeg,jpg,png,pdf|max:2048',
            'member_number' => 'required|string|max:50|unique:members,member_number,' . $member->id,
        ]);

        // Hapus member card lama jika ada
        if ($member->member_card && Storage::disk('public')->exists($member->member_card)) {
            Storage::disk('public')->delete($member->member_card);
        }

        // Upload member card baru
        $validated['member_card'] = $request->file('member_card')->store('member-cards', 'public');

        $member->update($validated);

        return redirect()->route('admin.members.show', $member)
            ->with('success', 'Kartu anggota berhasil diupload!');
    }

    /**
     * Delete member card
     */
    public function deleteCard(Member $member)
    {
        if ($member->member_card && Storage::disk('public')->exists($member->member_card)) {
            Storage::disk('public')->delete($member->member_card);
        }

        $member->update([
            'member_card' => null,
        ]);

        return redirect()->route('admin.members.show', $member)
            ->with('success', 'Kartu anggota berhasil dihapus!');
    }

    public function uploadPhoto(Request $request, Member $member)
    {
        // Hanya izinkan upload foto untuk member yang sudah divalidasi
        if (!$member->is_verified) {
            return redirect()->route('admin.members.show', $member)
                ->with('error', 'Foto hanya dapat di-upload untuk member yang sudah divalidasi.');
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

        // Log activity
        \App\Helpers\ActivityLogger::log(
            'upload_member_photo',
            'updated',
            'Member',
            "Admin uploaded photo for member: {$member->user->name}"
        );

        return redirect()->route('admin.members.show', $member)
            ->with('success', 'Foto member berhasil diunggah!');
    }

    public function deletePhoto(Member $member)
    {
        // Hanya izinkan hapus foto untuk member yang sudah divalidasi
        if (!$member->is_verified) {
            return redirect()->route('admin.members.show', $member)
                ->with('error', 'Foto hanya dapat dihapus untuk member yang sudah divalidasi.');
        }

        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->update([
            'photo' => null,
        ]);

        // Log activity
        \App\Helpers\ActivityLogger::log(
            'delete_member_photo',
            'deleted',
            'Member',
            "Admin deleted photo for member: {$member->user->name}"
        );

        return redirect()->route('admin.members.show', $member)
            ->with('success', 'Foto member berhasil dihapus!');
    }

    /**
     * Verify member
     */
    public function verify(Request $request, Member $member)
    {
        $validated = $request->validate([
            'verification_notes' => 'nullable|string|max:1000',
        ]);

        $member->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'verification_notes' => $validated['verification_notes'] ?? null,
        ]);

        // Send notification
        NotificationService::memberVerified($member->user);

        return redirect()->back()
            ->with('success', 'Member berhasil diverifikasi!');
    }

    /**
     * Unverify member
     */
    public function unverify(Request $request, Member $member)
    {
        $validated = $request->validate([
            'verification_notes' => 'nullable|string|max:1000',
        ]);

        $member->update([
            'is_verified' => false,
            'verified_at' => null,
            'verified_by' => null,
            'verification_notes' => $validated['verification_notes'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Verifikasi member berhasil dibatalkan!');
    }

    /**
     * Upload verification document
     */
    public function uploadVerificationDocument(Request $request, Member $member)
    {
        $request->validate([
            'verification_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        // Delete old document if exists
        if ($member->verification_document && Storage::disk('public')->exists($member->verification_document)) {
            Storage::disk('public')->delete($member->verification_document);
        }

        // Store new document
        $documentPath = $request->file('verification_document')->store('verification-docs', 'public');

        $member->update([
            'verification_document' => $documentPath,
        ]);

        return redirect()->back()
            ->with('success', 'Dokumen verifikasi berhasil diunggah!');
    }

    /**
     * Show registration detail
     */
    public function showRegistration(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update registration status (approve/reject)
     */
    public function updateRegistrationStatus(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $registration->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        // If approved, create user and member
        if ($validated['status'] === 'approved') {
            // Check if user already exists
            $existingUser = User::where('email', $registration->email)->first();
            
            if (!$existingUser) {
                // Generate member number
                $lastMember = Member::latest('id')->first();
                $nextNumber = $lastMember ? intval(substr($lastMember->member_number, -4)) + 1 : 1;
                $memberNumber = 'APJIKOM-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                // Create user
                $user = User::create([
                    'name' => $registration->full_name,
                    'email' => $registration->email,
                    'password' => Hash::make('password123'),
                    'is_admin' => false,
                ]);

                // Create member
                $member = Member::create([
                    'user_id' => $user->id,
                    'member_number' => $memberNumber,
                    'institution_name' => $registration->institution,
                    'position' => $registration->position ?? null,
                    'member_type' => $registration->type,
                    'phone' => $registration->phone,
                    'address' => $registration->address,
                    'city' => $registration->city ?? null,
                    'province' => $registration->province ?? null,
                    'status' => 'active',
                    'join_date' => now(),
                    'expiry_date' => now()->addYear(),
                ]);

                // Update registration with member_id
                $registration->update(['member_id' => $member->id]);

                // Generate member card if card generator available
                if ($registration->photo) {
                    try {
                        $generator = new MemberCardGenerator();
                        $cardPath = $generator->generate($member);
                        $member->update(['member_card' => $cardPath]);
                    } catch (\Exception $e) {
                        \Log::error('Card generation failed: ' . $e->getMessage());
                    }
                }
            }
        }

        return redirect()->route('admin.members.index', ['tab' => 'registrations'])
            ->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Delete registration
     */
    public function destroyRegistration(Registration $registration)
    {
        // Delete photo if exists
        if ($registration->photo && Storage::disk('public')->exists($registration->photo)) {
            Storage::disk('public')->delete($registration->photo);
        }

        $registration->delete();

        return redirect()->route('admin.members.index', ['tab' => 'registrations'])
            ->with('success', 'Pendaftaran berhasil dihapus!');
    }

    /**
     * Bulk action for registrations (approve/reject multiple)
     */
    public function bulkActionRegistrations(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'registration_ids' => 'required|array|min:1',
            'registration_ids.*' => 'exists:registrations,id',
        ]);

        $action = $validated['action'];
        $registrationIds = $validated['registration_ids'];
        
        $successCount = 0;
        $failCount = 0;
        $errors = [];

        foreach ($registrationIds as $id) {
            try {
                $registration = Registration::findOrFail($id);
                
                // Skip if already processed
                if ($registration->status !== 'pending') {
                    continue;
                }

                if ($action === 'approve') {
                    // Create user account
                    $password = Str::random(12);
                    $user = User::create([
                        'name' => $registration->full_name,
                        'email' => $registration->email,
                        'password' => Hash::make($password),
                        'role' => 'member',
                    ]);

                    // Create member
                    $memberData = [
                        'user_id' => $user->id,
                        'name' => $registration->full_name,
                        'email' => $registration->email,
                        'phone' => $registration->phone,
                        'address' => $registration->address ?? null,
                        'institution' => $registration->institution ?? null,
                        'position' => $registration->position ?? null,
                        'type' => $registration->type,
                        'photo' => $registration->photo,
                        'id_card' => $registration->id_card ?? null,
                        'status' => 'active',
                        'is_verified' => true,
                    ];

                    $member = Member::create($memberData);

                    // Link registration to member
                    $registration->update([
                        'status' => 'approved',
                        'member_id' => $member->id
                    ]);

                    // Send email notification (optional - comment out if no mail configured)
                    try {
                        \Mail::to($user->email)->send(new \App\Mail\MemberApproved($user, $password, $member));
                    } catch (\Exception $e) {
                        // Log error but don't fail the whole process
                        \Log::warning('Failed to send approval email: ' . $e->getMessage());
                    }

                    // Log activity
                    \App\Helpers\ActivityLogger::log(
                        'approve_registration',
                        'approved',
                        'Registration',
                        "Approved registration #{$registration->id} and created member #{$member->id} for {$registration->full_name}"
                    );

                    $successCount++;
                } elseif ($action === 'reject') {
                    $registration->update(['status' => 'rejected']);
                    
                    // Log activity
                    \App\Helpers\ActivityLogger::log(
                        'reject_registration',
                        'rejected',
                        'Registration',
                        "Rejected registration #{$registration->id} for {$registration->full_name}"
                    );
                    
                    $successCount++;
                }
            } catch (\Exception $e) {
                $failCount++;
                $errors[] = "ID {$id}: " . $e->getMessage();
                \Log::error("Bulk action failed for registration {$id}: " . $e->getMessage());
            }
        }

        // Prepare detailed success message
        $message = '';
        if ($action === 'approve') {
            $message = "🎉 Berhasil approve {$successCount} pendaftaran! Member baru telah dibuat dan email notifikasi telah dikirim.";
        } else {
            $message = "✅ Berhasil reject {$successCount} pendaftaran.";
        }

        if ($failCount > 0) {
            $message .= " ⚠️ ({$failCount} gagal diproses, cek log untuk detail)";
        }

        return redirect()->route('admin.members.index', ['tab' => 'registrations'])
            ->with('success', $message);
    }
}

