<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\MemberCardGenerator;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('institution', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by has_member (checks if member_id is set)
        if ($request->has('has_member') && $request->has_member !== '') {
            if ($request->has_member == 'yes') {
                $query->whereNotNull('member_id');
            } else {
                $query->whereNull('member_id');
            }
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('full_name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->input('per_page', 15);
        $registrations = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total' => Registration::count(),
            'pending' => Registration::where('status', 'pending')->count(),
            'approved' => Registration::where('status', 'approved')->count(),
            'rejected' => Registration::where('status', 'rejected')->count(),
            'individu' => Registration::where('type', 'individu')->count(),
            'prodi' => Registration::where('type', 'prodi')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats'));
    }

    public function show($id)
    {
        $registration = Registration::findOrFail($id);
        
        // Get existing member if registration is approved
        $existingMember = null;
        if ($registration->status === 'approved') {
            $user = User::where('email', $registration->email)->first();
            if ($user) {
                $existingMember = Member::where('user_id', $user->id)->first();
            }
        }
        
        return view('admin.registrations.show', compact('registration', 'existingMember'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
            'show_in_directory' => 'nullable|boolean',
        ]);

        $registration = Registration::findOrFail($id);
        $oldStatus = $registration->status;
        $registration->status = $request->status;
        $registration->notes = $request->notes;
        $registration->save();

        // Jika status berubah menjadi approved, buat member baru
        $isNewMember = false;
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            // Cek apakah akan membuat member baru atau sudah ada
            $user = User::where('email', $registration->email)->first();
            $existingMember = $user ? Member::where('user_id', $user->id)->first() : null;
            
            $this->createMemberFromRegistration($registration, $request->has('show_in_directory'));
            $isNewMember = !$existingMember;
        } elseif ($request->status === 'approved') {
            // Update show_in_directory untuk member yang sudah ada
            $user = User::where('email', $registration->email)->first();
            if ($user) {
                $member = Member::where('user_id', $user->id)->first();
                if ($member) {
                    $member->show_in_directory = $request->has('show_in_directory');
                    $member->save();
                }
            }
        }

        $successMessage = 'Status pendaftaran berhasil diperbarui!';
        if ($request->status === 'approved') {
            if ($isNewMember) {
                $successMessage .= ' Member baru telah dibuat dan kartu anggota telah di-generate otomatis.';
            } else {
                $successMessage .= ' Member sudah aktif sebelumnya, kartu anggota tetap berlaku.';
            }
        }

        return redirect()->route('admin.registrations.index')
            ->with('success', $successMessage);
    }

    /**
     * Create member from approved registration
     */
    private function createMemberFromRegistration(Registration $registration, $showInDirectory = false)
    {
        // Cek apakah email sudah terdaftar sebagai user
        $user = User::where('email', $registration->email)->first();
        
        if (!$user) {
            // Buat user baru
            // Password dari registration sudah dalam bentuk hash, jadi langsung pakai
            $user = User::create([
                'name' => $registration->full_name,
                'email' => $registration->email,
                'password' => $registration->password ?? Hash::make('password123'), // Password sudah di-hash saat registrasi
                'email_verified_at' => now(),
            ]);
        }

        // Cek apakah member sudah ada
        $existingMember = Member::where('user_id', $user->id)->first();
        
        if ($existingMember) {
            // Member sudah ada, update show_in_directory
            $existingMember->show_in_directory = $showInDirectory;
            $existingMember->save();
            return;
        }

        // Generate member number
        $lastMember = Member::latest('id')->first();
        $nextNumber = $lastMember ? (intval(substr($lastMember->member_number, -4)) + 1) : 1;
        $memberNumber = 'APJ' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $joinDate = now();
        // Buat member baru
        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => $memberNumber,
            'full_name' => $registration->full_name,
            'phone' => $registration->phone,
            'institution' => $registration->institution,
            'membership_type' => $registration->type === 'prodi' ? 'institutional' : 'individual',
            'join_date' => $joinDate,
            'expiry_date' => $joinDate->copy()->addYear(),
            'status' => 'active',
            'address' => $registration->address ?? null,
            'show_in_directory' => $showInDirectory,
        ]);

        // Link registration to member
        $registration->member_id = $member->id;
        $registration->save();

        // Auto-generate kartu anggota untuk member baru
        try {
            $cardGenerator = new MemberCardGenerator();
            $cardPath = $cardGenerator->generate($member);
            
            // Update member dengan path kartu
            $member->member_card = $cardPath;
            $member->save();
        } catch (\Exception $e) {
            // Log error tapi tetap lanjutkan proses
            \Log::error('Failed to generate member card: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);

        // Delete uploaded files
        if ($registration->payment_proof) {
            Storage::disk('public')->delete($registration->payment_proof);
        }
        if ($registration->authorization_letter) {
            Storage::disk('public')->delete($registration->authorization_letter);
        }

        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Data pendaftaran berhasil dihapus!');
    }
}
