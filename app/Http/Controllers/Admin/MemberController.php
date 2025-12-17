<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\MemberCardGenerator;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user')->latest();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Get user IDs that match the search
            $userIds = User::where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->pluck('id');
            
            $query->where(function($q) use ($search, $userIds) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhereIn('user_id', $userIds);
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Member type filter
        if ($request->filled('type')) {
            $query->where('member_type', $request->type);
        }
        
        // Verification filter
        if ($request->has('verified') && $request->verified !== '') {
            $query->where('is_verified', $request->verified);
        }
        
        // Card status filter
        if ($request->has('has_card') && $request->has_card !== '') {
            if ($request->has_card == '1') {
                $query->whereNotNull('member_card');
            } else {
                $query->whereNull('member_card');
            }
        }
        
        // Card request filter
        if ($request->has('card_requested') && $request->card_requested !== '') {
            $query->where('card_requested', $request->card_requested);
        }
        
        // Card update request filter
        if ($request->has('card_update_requested') && $request->card_update_requested !== '') {
            $query->where('card_update_requested', $request->card_update_requested);
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sorting
        $sortBy = $request->input('sort', 'latest');
        
        if (in_array($sortBy, ['name', 'name_desc'])) {
            // For name sorting, we need to join with users table
            $query->select('members.*')
                  ->join('users', 'members.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sortBy === 'name' ? 'asc' : 'desc');
        } else {
            switch ($sortBy) {
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query->latest();
            }
        }
        
        $members = $query->paginate(15)->withQueryString();
        
        // Stats for dashboard
        $stats = [
            'card_requests' => Member::where('card_requested', true)->count(),
            'card_update_requests' => Member::where('card_update_requested', true)->count(),
        ];

        return view('admin.members.index', compact('members', 'stats'));
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

        return redirect()->route('admin.members.show', $member)
            ->with('success', 'Foto member berhasil diunggah!');
    }

    public function deletePhoto(Member $member)
    {
        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->update([
            'photo' => null,
        ]);

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
}
