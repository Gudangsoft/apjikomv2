<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;
use App\Models\Registration;

echo "=== PERBANDINGAN DATA REGISTRATION vs MEMBER ===\n\n";

$registration = Registration::first();
$member = Member::first();

if ($registration) {
    echo "📝 DATA REGISTRATION:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Nama           : " . $registration->name . "\n";
    echo "Email          : " . $registration->email . "\n";
    echo "Institusi      : " . $registration->institution . "\n";
    echo "Kontak         : " . $registration->phone . "\n";
    echo "Alamat         : " . $registration->address . "\n";
    echo "Status         : " . $registration->status . "\n";
    echo "\n";
}

if ($member) {
    echo "👤 DATA MEMBER:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "No. Anggota    : " . ($member->member_number ?? 'Belum ada') . "\n";
    echo "Nama           : " . ($member->name ?: '[KOSONG]') . "\n";
    echo "Email          : " . ($member->email ?: '[KOSONG]') . "\n";
    echo "Institusi      : " . ($member->institution ?: '[KOSONG]') . "\n";
    echo "Kontak         : " . $member->phone . "\n";
    echo "Alamat         : " . ($member->address ?: '[KOSONG]') . "\n";
    echo "Status         : " . $member->status . "\n";
    echo "\n";
    
    echo "⚠️  MASALAH: Data member tidak lengkap!\n";
    echo "Kemungkinan saat sync, kolom name/email/institusi/address tidak ter-copy.\n\n";
}

// Cek struktur tabel members
echo "🔍 STRUKTUR KOLOM MEMBERS TABLE:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$columns = DB::select("SHOW COLUMNS FROM members");
foreach ($columns as $col) {
    echo "• " . $col->Field . " (" . $col->Type . ")\n";
}
