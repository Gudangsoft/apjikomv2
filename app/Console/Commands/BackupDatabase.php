<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Create a MySQL database backup and store it in storage/app/backups';

    public function handle(): void
    {
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        if (!$database) {
            $this->error('No MySQL database configured.');
            return;
        }

        $backupDir = storage_path('app/backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename  = $database . '_' . now()->format('Y-m-d_H-i-s') . '.sql.gz';
        $filepath  = $backupDir . DIRECTORY_SEPARATOR . $filename;

        $passOption = $password ? '-p' . escapeshellarg($password) : '';
        $cmd = sprintf(
            'mysqldump --host=%s --port=%s --user=%s %s %s | gzip > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $passOption,
            escapeshellarg($database),
            escapeshellarg($filepath)
        );

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            $this->error('Backup failed (exit code ' . $exitCode . '). Check that mysqldump is in PATH.');
            Log::error('Database backup failed', ['output' => implode("\n", $output)]);
            return;
        }

        $size = round(filesize($filepath) / 1024, 1);
        $this->info("Backup created: {$filename} ({$size} KB)");
        Log::info("Database backup created: {$filename} ({$size} KB)");

        // Remove backups older than 30 days
        $files = glob($backupDir . DIRECTORY_SEPARATOR . '*.sql.gz') ?: [];
        foreach ($files as $file) {
            if (filemtime($file) < now()->subDays(30)->timestamp) {
                unlink($file);
                $this->line('Removed old backup: ' . basename($file));
            }
        }
    }
}
