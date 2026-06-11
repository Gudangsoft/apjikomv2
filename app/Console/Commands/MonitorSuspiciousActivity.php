<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MonitorSuspiciousActivity extends Command
{
    protected $signature = 'activity:monitor';
    protected $description = 'Check activity logs for suspicious patterns and alert admins by email';

    // Threshold: how many failed logins in 1 hour triggers an alert
    private const FAILED_LOGIN_THRESHOLD = 10;

    public function handle(): void
    {
        $since     = Carbon::now()->subHour();
        $alerts    = [];

        // 1. Multiple failed logins from same IP
        $failedLogins = ActivityLog::where('action', 'login_failed')
            ->where('created_at', '>=', $since)
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(properties, "$.ip")) as ip, COUNT(*) as cnt')
            ->groupBy('ip')
            ->having('cnt', '>=', self::FAILED_LOGIN_THRESHOLD)
            ->get();

        foreach ($failedLogins as $row) {
            $alerts[] = "Login gagal berulang: IP {$row->ip} — {$row->cnt}x dalam 1 jam terakhir";
        }

        // 2. Unusual bulk deletes
        $bulkDeletes = ActivityLog::where('action', 'deleted')
            ->where('created_at', '>=', $since)
            ->selectRaw('user_id, COUNT(*) as cnt')
            ->groupBy('user_id')
            ->having('cnt', '>=', 10)
            ->with('user')
            ->get();

        foreach ($bulkDeletes as $row) {
            $name = $row->user->name ?? "user #{$row->user_id}";
            $alerts[] = "Penghapusan massal: {$name} menghapus {$row->cnt} item dalam 1 jam terakhir";
        }

        // 3. Login from new IP for existing admin
        $adminLogins = ActivityLog::where('action', 'login')
            ->where('created_at', '>=', $since)
            ->with('user')
            ->get()
            ->filter(fn($l) => $l->user && $l->user->role === 'admin');

        foreach ($adminLogins as $log) {
            $currentIp   = $log->properties['ip'] ?? null;
            $knownIps    = ActivityLog::where('user_id', $log->user_id)
                ->where('action', 'login')
                ->where('created_at', '<', $since)
                ->pluck('properties')
                ->map(fn($p) => $p['ip'] ?? null)
                ->filter()
                ->unique()
                ->toArray();

            if ($currentIp && count($knownIps) > 0 && !in_array($currentIp, $knownIps)) {
                $alerts[] = "Login admin dari IP baru: {$log->user->name} login dari {$currentIp} (IP baru)";
            }
        }

        if (empty($alerts)) {
            $this->info('No suspicious activity detected.');
            return;
        }

        // Send alert email to admin
        $adminEmail = Setting::getValue('contact_email');
        if (!$adminEmail) {
            $this->warn('No admin email configured (contact_email). Logging alerts only.');
        }

        $alertText = implode("\n", array_map(fn($a) => "- {$a}", $alerts));
        Log::warning("Suspicious activity detected:\n" . $alertText);

        if ($adminEmail) {
            try {
                $siteName = Setting::getValue('site_name', 'Website');
                Mail::raw(
                    "Peringatan Aktivitas Mencurigakan — {$siteName}\n\n" .
                    "Berikut aktivitas mencurigakan yang terdeteksi pada " . now()->format('d/m/Y H:i') . ":\n\n" .
                    $alertText . "\n\n" .
                    "Silakan periksa log aktivitas di panel admin.",
                    function ($m) use ($adminEmail, $siteName) {
                        $m->to($adminEmail)->subject("[ALERT] Aktivitas Mencurigakan — {$siteName}");
                    }
                );
                $this->info('Alert email sent to ' . $adminEmail);
            } catch (\Throwable $e) {
                $this->error('Failed to send alert email: ' . $e->getMessage());
            }
        }

        $this->warn(count($alerts) . ' suspicious activity alert(s) detected.');
        foreach ($alerts as $alert) {
            $this->line('  • ' . $alert);
        }
    }
}
