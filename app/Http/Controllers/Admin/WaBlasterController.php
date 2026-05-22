<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Setting;
use App\Models\WaBlastLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WaBlasterController extends Controller
{
    // Variabel yang bisa dipakai di pesan
    const VARIABLES = [
        '{nama}'          => 'Nama lengkap anggota',
        '{nomor_anggota}' => 'Nomor anggota',
        '{institusi}'     => 'Nama institusi',
        '{tipe}'          => 'Tipe keanggotaan',
        '{status}'        => 'Status keanggotaan',
        '{nama_org}'      => 'Nama organisasi (dari setting)',
    ];

    public function index()
    {
        $recentLogs = WaBlastLog::with('sender')->latest()->limit(10)->get();
        $totalSent  = WaBlastLog::where('status', 'completed')->sum('success_count');
        $totalBlast = WaBlastLog::where('status', 'completed')->count();

        $gatewayToken  = Setting::getValue('wa_gateway_token', '');
        $gatewayUrl    = Setting::getValue('wa_gateway_url', 'https://api.fonnte.com/send');
        $gatewayDevice = Setting::getValue('wa_gateway_device', '');

        return view('admin.wa-blaster.index', compact(
            'recentLogs', 'totalSent', 'totalBlast',
            'gatewayToken', 'gatewayUrl', 'gatewayDevice'
        ));
    }

    /**
     * AJAX: hitung & preview penerima sesuai filter
     */
    public function previewRecipients(Request $request)
    {
        $query = $this->buildRecipientQuery($request->filter ?? 'active');

        $members = $query->with('user')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->get(['id', 'user_id', 'phone', 'member_number', 'institution_name', 'member_type', 'status']);

        return response()->json([
            'count'   => $members->count(),
            'sample'  => $members->take(5)->map(fn($m) => [
                'name'   => $m->user->name ?? '—',
                'phone'  => $this->formatPhone($m->phone),
                'type'   => $m->member_type,
            ]),
            'no_phone' => $this->buildRecipientQuery($request->filter ?? 'active')
                ->whereNull('phone')->orWhere('phone', '')->count(),
        ]);
    }

    /**
     * Kirim blast
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:200',
            'message' => 'required|string|max:4000',
            'filter'  => 'required|in:all,active,inactive,individu,prodi',
            'gateway' => 'required|in:fonnte,manual',
        ]);

        $members = $this->buildRecipientQuery($validated['filter'])
            ->with('user')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->get();

        if ($members->isEmpty()) {
            return back()->with('error', 'Tidak ada penerima dengan nomor HP yang valid untuk filter ini.');
        }

        // Buat log record
        $log = WaBlastLog::create([
            'title'            => $validated['title'],
            'message'          => $validated['message'],
            'gateway'          => $validated['gateway'],
            'recipient_filter' => $validated['filter'],
            'total_recipients' => $members->count(),
            'status'           => 'sending',
            'sent_by'          => Auth::id(),
            'sent_at'          => now(),
        ]);

        if ($validated['gateway'] === 'manual') {
            $log->update(['status' => 'completed', 'success_count' => $members->count()]);
            return redirect()->route('admin.wa-blaster.show', $log)
                ->with('manual_numbers', $this->buildManualData($members, $validated['message']));
        }

        // Kirim via API
        [$success, $failed, $failedNumbers] = $this->sendViaGateway($members, $validated['message']);

        $log->update([
            'status'         => 'completed',
            'success_count'  => $success,
            'failed_count'   => $failed,
            'failed_numbers' => $failedNumbers,
        ]);

        $msg = "Blast selesai! Terkirim: {$success}, Gagal: {$failed} dari {$members->count()} penerima.";
        return redirect()->route('admin.wa-blaster.index')->with('success', $msg);
    }

    /**
     * Simpan konfigurasi gateway
     */
    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'wa_gateway_token'  => 'nullable|string|max:200',
            'wa_gateway_url'    => 'nullable|url|max:300',
            'wa_gateway_device' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value ?? '', 'text', 'whatsapp');
        }

        return back()->with('success', 'Konfigurasi gateway WA berhasil disimpan.');
    }

    /**
     * Detail satu blast
     */
    public function show(WaBlastLog $waBlastLog)
    {
        return view('admin.wa-blaster.show', ['log' => $waBlastLog]);
    }

    /**
     * Hapus log
     */
    public function destroy(WaBlastLog $waBlastLog)
    {
        $waBlastLog->delete();
        return back()->with('success', 'Log blast dihapus.');
    }

    // ─── Private helpers ────────────────────────────────────────────

    private function buildRecipientQuery(string $filter)
    {
        $query = Member::query();

        match ($filter) {
            'active'   => $query->where('status', 'active'),
            'inactive' => $query->where('status', '!=', 'active'),
            'individu' => $query->where('member_type', 'individu')->where('status', 'active'),
            'prodi'    => $query->where('member_type', 'prodi')->where('status', 'active'),
            default    => null, // all
        };

        return $query;
    }

    private function replaceVariables(string $message, Member $member): string
    {
        $siteName = Setting::getValue('site_name', 'Website Asosiasi');
        return str_replace(
            ['{nama}', '{nomor_anggota}', '{institusi}', '{tipe}', '{status}', '{nama_org}'],
            [
                $member->user->name ?? '',
                $member->member_number ?? '',
                $member->institution_name ?? '',
                $member->member_type ?? '',
                $member->status ?? '',
                $siteName,
            ],
            $message
        );
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    private function sendViaGateway($members, string $messageTemplate): array
    {
        $token  = Setting::getValue('wa_gateway_token', '');
        $url    = Setting::getValue('wa_gateway_url', 'https://api.fonnte.com/send');
        $device = Setting::getValue('wa_gateway_device', '');

        if (empty($token)) {
            return [0, $members->count(), $members->pluck('phone')->toArray()];
        }

        $success = 0;
        $failed  = 0;
        $failedNumbers = [];

        foreach ($members as $member) {
            $phone   = $this->formatPhone($member->phone);
            $message = $this->replaceVariables($messageTemplate, $member);

            try {
                $payload = ['target' => $phone, 'message' => $message];
                if ($device) $payload['device'] = $device;

                $response = Http::withHeaders(['Authorization' => $token])
                    ->timeout(15)
                    ->post($url, $payload);

                if ($response->successful() && ($response->json('status') !== false)) {
                    $success++;
                } else {
                    $failed++;
                    $failedNumbers[] = $phone;
                }
            } catch (\Exception $e) {
                $failed++;
                $failedNumbers[] = $phone;
                \Log::warning("WA blast failed for {$phone}: " . $e->getMessage());
            }

            // Delay kecil agar tidak kena rate limit
            usleep(300000); // 300ms
        }

        return [$success, $failed, $failedNumbers];
    }

    private function buildManualData($members, string $messageTemplate): array
    {
        return $members->map(fn($m) => [
            'name'    => $m->user->name ?? '—',
            'phone'   => $this->formatPhone($m->phone),
            'wa_link' => 'https://wa.me/' . $this->formatPhone($m->phone) . '?text=' . urlencode($this->replaceVariables($messageTemplate, $m)),
            'message' => $this->replaceVariables($messageTemplate, $m),
        ])->toArray();
    }
}
