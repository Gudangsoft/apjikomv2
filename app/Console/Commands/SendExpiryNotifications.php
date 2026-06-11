<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendExpiryNotifications extends Command
{
    protected $signature = 'members:send-expiry-notifications';
    protected $description = 'Send in-app notifications to members whose membership is expiring within 30 days';

    public function handle(): void
    {
        $thresholds = [30, 14, 7];

        foreach ($thresholds as $days) {
            $targetDate = Carbon::today()->addDays($days);

            $members = Member::with('user')
                ->where('status', 'active')
                ->whereDate('expiry_date', $targetDate)
                ->get();

            foreach ($members as $member) {
                if (!$member->user) {
                    continue;
                }

                $alreadyNotified = Notification::where('user_id', $member->user_id)
                    ->where('type', 'membership_expiry')
                    ->where('title', "Keanggotaan Anda Akan Berakhir dalam {$days} Hari")
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if ($alreadyNotified) {
                    continue;
                }

                try {
                    Notification::create([
                        'user_id'     => $member->user_id,
                        'type'        => 'membership_expiry',
                        'title'       => "Keanggotaan Anda Akan Berakhir dalam {$days} Hari",
                        'message'     => "Masa keanggotaan Anda akan berakhir pada " . $member->expiry_date->format('d F Y') . ". Segera perbarui keanggotaan Anda untuk tetap menikmati layanan.",
                        'icon'        => 'clock',
                        'color'       => $days <= 7 ? 'red' : ($days <= 14 ? 'orange' : 'yellow'),
                        'action_url'  => route('member.dashboard'),
                        'action_text' => 'Dashboard Member',
                    ]);
                } catch (\Throwable $e) {
                    Log::warning("Failed to create expiry notification for member {$member->id}: " . $e->getMessage());
                }
            }

            $this->info("Sent expiry notifications for {$members->count()} members expiring in {$days} days.");
        }
    }
}
