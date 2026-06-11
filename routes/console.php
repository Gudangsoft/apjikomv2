<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Send expiry notifications to members every day at 08:00
Schedule::command('members:send-expiry-notifications')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/expiry-notifications.log'));

// Database backup every day at 02:00
Schedule::command('db:backup')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/db-backup.log'));

// Monitor suspicious activity every hour
Schedule::command('activity:monitor')
    ->hourly()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/activity-monitor.log'));
