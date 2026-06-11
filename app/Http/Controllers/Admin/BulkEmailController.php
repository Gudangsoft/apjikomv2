<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BulkEmailController extends Controller
{
    public function index()
    {
        $activeCount      = Member::with('user')->where('status', 'active')->count();
        $allMemberCount   = Member::with('user')->count();
        $recentLogs       = \App\Models\ActivityLog::where('type', 'bulk_email')
            ->latest()
            ->take(10)
            ->with('user')
            ->get();

        return view('admin.bulk-email.index', compact('activeCount', 'allMemberCount', 'recentLogs'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'body'       => 'required|string',
            'recipients' => 'required|in:active,all',
        ], [
            'subject.required'    => 'Subjek email wajib diisi.',
            'body.required'       => 'Isi email wajib diisi.',
            'recipients.required' => 'Pilih penerima email.',
        ]);

        $query = Member::with('user');
        if ($request->recipients === 'active') {
            $query->where('status', 'active');
        }

        $members = $query->get();
        $siteName = Setting::getValue('site_name', 'Website');
        $subject  = $request->subject;
        $body     = $request->body;

        $sent   = 0;
        $failed = 0;

        foreach ($members as $member) {
            if (!$member->user || !$member->user->email) {
                continue;
            }

            try {
                Mail::send([], [], function ($message) use ($member, $subject, $body, $siteName) {
                    $message->to($member->user->email, $member->user->name)
                        ->subject($subject)
                        ->html($body . '<br><br><small style="color:#9ca3af;">Email ini dikirim oleh ' . e($siteName) . '. Jika Anda merasa menerima email ini secara tidak sengaja, abaikan saja.</small>');
                });
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::warning("Bulk email failed for {$member->user->email}: " . $e->getMessage());
            }
        }

        ActivityLogger::log(
            'bulk_email',
            'sent',
            null,
            "Bulk email dikirim ke {$sent} anggota (gagal: {$failed}) — subjek: {$subject}"
        );

        $msg = "Email berhasil dikirim ke {$sent} anggota.";
        if ($failed > 0) {
            $msg .= " {$failed} gagal (lihat log).";
        }

        return redirect()->route('admin.bulk-email.index')->with('success', $msg);
    }
}
