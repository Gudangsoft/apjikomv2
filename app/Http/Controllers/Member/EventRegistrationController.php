<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventRegistrationController extends Controller
{
    public function register(Request $request, Event $event)
    {
        $user = Auth::user();

        // Check if already registered
        if ($event->isUserRegistered($user->id)) {
            return back()->with('info', 'Anda sudah terdaftar untuk event ini');
        }

        // Check if event is in the past
        if ($event->event_date < now()) {
            return back()->with('error', 'Event ini sudah berlalu');
        }

        // Handle payment proof upload for paid events
        $paymentProof = null;
        $paymentStatus = 'pending';
        
        if ($event->is_paid && $request->hasFile('payment_proof')) {
            $request->validate([
                'payment_proof' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
            ]);
            
            $paymentProof = $request->file('payment_proof')->store('event-payments', 'public');
            $paymentStatus = 'paid'; // Mark as paid, waiting for verification
        }

        // Register user
        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'registered',
            'payment_proof' => $paymentProof,
            'payment_status' => $event->is_paid ? $paymentStatus : 'verified', // Free events are auto-verified
        ]);

        $message = 'Berhasil mendaftar event!';
        if ($event->is_paid) {
            if ($paymentProof) {
                $message .= ' Bukti pembayaran Anda akan diverifikasi oleh admin.';
            } else {
                $message .= ' Silakan upload bukti pembayaran untuk menyelesaikan pendaftaran.';
            }
        }

        return back()->with('success', $message);
    }

    public function uploadPayment(Request $request, Event $event)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->first();

        if (!$registration) {
            return back()->with('error', 'Anda tidak terdaftar untuk event ini');
        }

        // Delete old payment proof if exists
        if ($registration->payment_proof && Storage::disk('public')->exists($registration->payment_proof)) {
            Storage::disk('public')->delete($registration->payment_proof);
        }

        // Upload new payment proof
        $paymentProof = $request->file('payment_proof')->store('event-payments', 'public');

        $registration->update([
            'payment_proof' => $paymentProof,
            'payment_status' => 'paid',
            'payment_verified_at' => null,
            'verified_by' => null,
            'payment_notes' => null,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function cancel(Event $event)
    {
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->first();

        if (!$registration) {
            return back()->with('error', 'Anda tidak terdaftar untuk event ini');
        }

        $registration->update(['status' => 'cancelled']);

        return back()->with('success', 'Pendaftaran event berhasil dibatalkan');
    }

    public function myEvents()
    {
        $registrations = EventRegistration::with('event')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('member.events.my-events', compact('registrations'));
    }
}
