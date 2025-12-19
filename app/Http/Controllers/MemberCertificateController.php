<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Storage;

class MemberCertificateController extends Controller
{
    /**
     * Download certificate
     */
    public function download(EventRegistration $registration)
    {
        // Check if user owns this registration
        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if certificate is available
        if (!$registration->canDownloadCertificate()) {
            return redirect()->back()
                ->with('error', 'Sertifikat belum tersedia. Pastikan event sudah selesai dan pembayaran telah diverifikasi.');
        }

        // Check if certificate has been generated
        if (!$registration->hasCertificate()) {
            return redirect()->back()
                ->with('error', 'Sertifikat belum digenerate. Silakan hubungi admin.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($registration->certificate_path)) {
            return redirect()->back()
                ->with('error', 'File sertifikat tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $registration->certificate_path);
        $fileName = 'Sertifikat_' . $registration->event->title . '_' . $registration->user->name . '.png';

        return response()->download($filePath, $fileName);
    }

    /**
     * View certificate
     */
    public function view(EventRegistration $registration)
    {
        // Check if user owns this registration
        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if certificate is available
        if (!$registration->canDownloadCertificate() || !$registration->hasCertificate()) {
            abort(404, 'Certificate not found');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($registration->certificate_path)) {
            abort(404, 'Certificate file not found');
        }

        $url = Storage::disk('public')->url($registration->certificate_path);
        
        return view('member.certificates.view', [
            'registration' => $registration,
            'certificateUrl' => $url,
        ]);
    }
}
