<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhysicalCardRequestController extends Controller
{
    /**
     * Tempat khusus admin memverifikasi bukti pembayaran cetak kartu FISIK —
     * terpisah dari kartu file (digital), yang tidak melibatkan pembayaran.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $query = Member::with('user')->where('physical_card_requested', true);

        if ($status === 'pending') {
            $query->where(function ($q) {
                $q->whereNull('physical_card_payment_status')
                  ->orWhere('physical_card_payment_status', 'pending');
            });
        } elseif (in_array($status, ['verified', 'rejected'], true)) {
            $query->where('physical_card_payment_status', $status);
        }
        // $status === 'all' -> tanpa filter tambahan

        $requests = $query->latest('physical_card_requested_at')->paginate(15)->withQueryString();

        $counts = [
            'pending' => Member::where('physical_card_requested', true)
                ->where(function ($q) {
                    $q->whereNull('physical_card_payment_status')
                      ->orWhere('physical_card_payment_status', 'pending');
                })->count(),
            'verified' => Member::where('physical_card_requested', true)
                ->where('physical_card_payment_status', 'verified')->count(),
            'rejected' => Member::where('physical_card_requested', true)
                ->where('physical_card_payment_status', 'rejected')->count(),
            'all' => Member::where('physical_card_requested', true)->count(),
        ];

        return view('admin.physical-card-requests.index', compact('requests', 'status', 'counts'));
    }

    /**
     * Tandai bukti pembayaran valid — kirim WA ke member bahwa pembayaran
     * diterima & kartu sedang dicetak.
     */
    public function verify(Request $request, Member $member)
    {
        $member->update([
            'physical_card_payment_status' => 'verified',
            'physical_card_payment_verified_at' => now(),
            'physical_card_payment_verified_by' => Auth::id(),
            'physical_card_payment_notes' => $request->input('notes'),
        ]);

        $waResult = WhatsAppService::sendPhysicalCardPaymentVerified($member);
        $note = WhatsAppService::resultNote($waResult);

        return back()->with('success', "Pembayaran {$member->user->name} ditandai valid — kartu dalam proses cetak.{$note}");
    }

    /**
     * Tandai bukti pembayaran tidak valid — kirim WA ke member dengan
     * keterangan (opsional) dari admin.
     */
    public function reject(Request $request, Member $member)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $member->update([
            'physical_card_payment_status' => 'rejected',
            'physical_card_payment_verified_at' => now(),
            'physical_card_payment_verified_by' => Auth::id(),
            'physical_card_payment_notes' => $validated['reason'] ?? null,
        ]);

        $waResult = WhatsAppService::sendPhysicalCardPaymentRejected($member, $validated['reason'] ?? null);
        $note = WhatsAppService::resultNote($waResult);

        return back()->with('success', "Pembayaran {$member->user->name} ditandai tidak valid.{$note}");
    }
}
