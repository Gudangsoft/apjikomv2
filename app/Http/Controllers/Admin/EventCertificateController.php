<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Services\CertificateGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventCertificateController extends Controller
{
    /**
     * Generate certificate for a registration
     */
    public function generate(EventRegistration $registration)
    {
        try {
            // Check if event has certificate enabled
            if (!$registration->event->has_certificate) {
                return redirect()->back()
                    ->with('error', 'Event ini tidak menyediakan sertifikat');
            }

            // Check if registration is eligible
            if (!$registration->canDownloadCertificate()) {
                return redirect()->back()
                    ->with('error', 'Peserta ini belum memenuhi syarat untuk mendapatkan sertifikat');
            }

            $generator = new CertificateGenerator();
            $certificatePath = $generator->generate($registration);

            // Log activity
            \App\Helpers\ActivityLogger::log(
                'generate_certificate',
                'generated',
                'EventRegistration',
                "Generated certificate for {$registration->user->name} - {$registration->event->title}"
            );

            return redirect()->back()
                ->with('success', 'Sertifikat berhasil digenerate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal generate sertifikat: ' . $e->getMessage());
        }
    }

    /**
     * Bulk generate certificates for all eligible registrations of an event
     */
    public function bulkGenerate(Request $request)
    {
        $eventId = $request->input('event_id');
        
        $registrations = EventRegistration::where('event_id', $eventId)
            ->whereHas('event', function($q) {
                $q->where('has_certificate', true)
                  ->where('event_date', '<', now());
            })
            ->where('status', '!=', 'cancelled')
            ->get();

        if ($registrations->isEmpty()) {
            return redirect()->back()
                ->with('info', 'Tidak ada peserta yang memenuhi syarat untuk mendapatkan sertifikat.');
        }

        $generator = new CertificateGenerator();
        $successCount = 0;
        $errorCount = 0;

        foreach ($registrations as $registration) {
            if ($registration->canDownloadCertificate()) {
                try {
                    $generator->generate($registration);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                }
            }
        }

        // Log activity
        \App\Helpers\ActivityLogger::log(
            'bulk_generate_certificates',
            'generated',
            'Event',
            "Bulk generated {$successCount} certificates for event ID {$eventId}"
        );

        return redirect()->back()
            ->with('success', "Berhasil generate {$successCount} sertifikat" . ($errorCount > 0 ? " ({$errorCount} gagal)" : ""));
    }

    /**
     * Delete certificate
     */
    public function destroy(EventRegistration $registration)
    {
        if ($registration->certificate_path) {
            // Delete certificate file
            if (Storage::disk('public')->exists($registration->certificate_path)) {
                Storage::disk('public')->delete($registration->certificate_path);
            }

            // Update registration
            $registration->update([
                'certificate_path' => null,
                'certificate_generated_at' => null,
            ]);

            return redirect()->back()
                ->with('success', 'Sertifikat berhasil dihapus');
        }

        return redirect()->back()
            ->with('error', 'Sertifikat tidak ditemukan');
    }
}
