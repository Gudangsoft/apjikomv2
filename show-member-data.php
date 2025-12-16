<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;

echo "=== CONTOH DATA KARTU ANGGOTA ===\n\n";

$member = Member::first();

if (!$member) {
    echo "❌ Belum ada member di database.\n";
    exit;
}

echo "📋 Data Member untuk Kartu:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "No. Anggota    : " . ($member->member_number ?? 'Belum ada') . "\n";
echo "Nama           : " . $member->name . "\n";
echo "Institusi      : " . $member->institution . "\n";
echo "Kontak         : " . $member->phone . "\n";
echo "Alamat         : " . $member->address . "\n";
echo "Email          : " . $member->email . "\n";
echo "\n";
echo "Berlaku        : " . ($member->membership_start_date ? date('d M Y', strtotime($member->membership_start_date)) : '-') . "\n";
echo "Sampai         : " . ($member->expiry_date ? date('d M Y', strtotime($member->expiry_date)) : '-') . "\n";
echo "Disahkan       : " . ($member->approval_date ? date('d M Y', strtotime($member->approval_date)) : '-') . "\n";
echo "\n";
echo "Status         : " . ucfirst($member->status) . "\n";
echo "Foto           : " . ($member->photo ? '✅ Sudah upload' : '❌ Belum upload') . "\n";
echo "Kartu          : " . ($member->member_card ? '✅ Sudah generate' : '❌ Belum generate') . "\n";

if ($member->member_card) {
    echo "\nPath Kartu     : storage/" . $member->member_card . "\n";
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Tampilkan format kartu seperti screenshot
echo "📄 FORMAT KARTU (seperti screenshot):\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "┌─────────────────────────────────────────────┐\n";
echo "│ [LOGO ISET]  INDONESIAN SOCIETY OF          │\n";
echo "│              ENGINEERING AND TECHNOLOGY      │\n";
echo "│─────────────────────────────────────────────│\n";
echo "│                                              │\n";
echo "│ [FOTO]  KARTU TANDA ANGGOTA                 │\n";
echo "│         No.Anggota : " . str_pad($member->member_number ?? 'ACC80982052', 25) . "│\n";
echo "│         nama       : " . str_pad($member->name, 25) . "│\n";
echo "│         Institusi  : " . str_pad($member->institution, 25) . "│\n";
echo "│         Kontak     : " . str_pad($member->phone, 25) . "│\n";
echo "│         Alamat     : " . str_pad($member->address, 25) . "│\n";
echo "│         Berlaku    : " . str_pad(($member->membership_start_date ? date('d M Y', strtotime($member->membership_start_date)) : '-') . ' - ' . ($member->expiry_date ? date('d M Y', strtotime($member->expiry_date)) : '-'), 20) . "│\n";
echo "│         Disahkan   : " . str_pad($member->approval_date ? date('d M Y', strtotime($member->approval_date)) : '-', 25) . "│\n";
echo "│                                       [QR]   │\n";
echo "│                                              │\n";
echo "│ • Kartu berlaku selama masih anggota ISET   │\n";
echo "└─────────────────────────────────────────────┘\n";
echo "\n";

// Tampilkan semua member
echo "📊 TOTAL MEMBERS: " . Member::count() . "\n\n";

$allMembers = Member::all();
foreach ($allMembers as $m) {
    echo "• " . ($m->member_number ?? '[No Number]') . " - " . $m->name . " (" . $m->status . ")\n";
}
