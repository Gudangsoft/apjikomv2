<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    public function register(Event $event)
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

        // Register user
        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => 'registered',
        ]);

        return back()->with('success', 'Berhasil mendaftar event! Kami akan mengirim reminder sebelum event dimulai.');
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
