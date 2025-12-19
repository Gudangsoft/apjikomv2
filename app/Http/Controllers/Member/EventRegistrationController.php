<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class EventRegistrationController extends Controller
{
    public function register(Request $request, Event $event)
    {
        \Log::info('=== EVENT REGISTRATION CALLED ===');
        \Log::info('Event ID: ' . $event->id);
        \Log::info('Event Title: ' . $event->title);
        
        $user = Auth::user();
        \Log::info('User ID: ' . $user->id);

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
        $query = EventRegistration::with(['event', 'event.category'])
            ->where('user_id', Auth::id());
        
        // Filter by status
        $status = request('status', 'all');
        if ($status === 'upcoming') {
            $query->whereHas('event', function ($q) {
                $q->where('event_date', '>=', now());
            });
        } elseif ($status === 'past') {
            $query->whereHas('event', function ($q) {
                $q->where('event_date', '<', now());
            });
        }
        
        $registrations = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('member.events.my-events', compact('registrations'));
    }

    /**
     * Download certificate for an event
     */
    public function downloadCertificate(Event $event)
    {
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->first();

        if (!$registration) {
            return back()->with('error', 'Anda tidak terdaftar untuk event ini');
        }

        // Check conditions for certificate download
        if (!$event->has_certificate) {
            return back()->with('error', 'Event ini tidak menyediakan sertifikat');
        }

        if ($event->event_date >= now()) {
            return back()->with('error', 'Sertifikat hanya tersedia setelah event selesai');
        }

        if ($registration->status === 'cancelled') {
            return back()->with('error', 'Pendaftaran Anda telah dibatalkan');
        }

        if ($event->is_paid && $registration->payment_status !== 'verified') {
            return back()->with('error', 'Pembayaran Anda belum diverifikasi. Silakan hubungi admin.');
        }

        $user = Auth::user();
        $member = $user->member;

        $certificateNumber = 'CERT/' . strtoupper(substr(md5($event->id . $user->id), 0, 8)) . '/' . $event->event_date->format('Y');
        $issuedDate = now();

        // Check if event has custom certificate template
        if ($event->certificate_template && Storage::disk('public')->exists($event->certificate_template)) {
            // Use custom template - Generate image-based certificate
            return $this->generateCustomCertificate($event, $registration, $user, $member);
        }

        // Use default template - Generate PDF certificate
        $pdf = PDF::loadView('member.events.certificate', [
            'event' => $event,
            'registration' => $registration,
            'user' => $user,
            'member' => $member,
            'certificate_number' => $certificateNumber,
            'issued_date' => $issuedDate,
        ]);

        $pdf->setPaper('A4', 'landscape');

        // Save certificate path if not already saved
        if (!$registration->certificate_path) {
            $filename = 'certificates/event-' . $event->id . '-user-' . $user->id . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            
            $registration->update([
                'certificate_path' => $filename,
                'certificate_generated_at' => now(),
            ]);
        }

        $filename = 'Sertifikat-' . str_replace(' ', '-', $event->title) . '-' . $user->name . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate certificate with custom template
     */
    private function generateCustomCertificate($event, $registration, $user, $member)
    {
        // For now, just provide download of the template
        // In future, this can be enhanced to overlay text on the template using Intervention Image
        
        $templatePath = storage_path('app/public/' . $event->certificate_template);
        $filename = 'Sertifikat-' . str_replace(' ', '-', $event->title) . '-' . $user->name . '.' . pathinfo($event->certificate_template, PATHINFO_EXTENSION);
        
        return response()->download($templatePath, $filename);
    }
}
