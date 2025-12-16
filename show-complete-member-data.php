<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;
use App\Models\User;
use App\Models\Registration;

echo "=== CONTOH DATA KARTU ANGGOTA (LENGKAP) ===\n\n";

$member = Member::with('user')->first();

if (!$member) {
    echo "❌ Belum ada member di database.\n";
    exit;
}

// Ambil data dari relasi user
$user = $member->user;

echo "📋 Data untuk Kartu Anggota:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "No. Anggota    : " . ($member->member_number ?? 'ACC80982052') . "\n";
echo "Nama           : " . ($user->name ?? 'Abdul Muchlis') . "\n";
echo "Institusi      : " . ($member->institution_name ?? 'Universitas Gunadarma') . "\n";
echo "Kontak         : " . ($member->phone ?? '087787048744') . "\n";
echo "Alamat         : " . ($member->address ?? 'Jl. Sarang Bango') . "\n";
echo "\n";
echo "Berlaku        : " . ($member->join_date ? date('d M Y', strtotime($member->join_date)) : '04 Juli 2025') . "\n";
echo "Sampai         : " . ($member->expiry_date ? date('d M Y', strtotime($member->expiry_date)) : '04 Juli 2026') . "\n";
echo "Disahkan       : " . ($member->join_date ? date('d M Y', strtotime($member->join_date)) : '04 Juli 2025') . "\n";
echo "\n";
echo "Status         : " . ucfirst($member->status) . "\n";
echo "Foto User      : " . ($user && $user->photo ? '✅ Ada' : '❌ Belum') . "\n";
echo "Foto Member    : " . ($member->photo ? '✅ Ada' : '❌ Belum') . "\n";
echo "Kartu          : " . ($member->member_card ? '✅ Sudah generate' : '❌ Belum generate') . "\n";

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Tampilkan format kartu seperti screenshot ISET
echo "📄 PREVIEW KARTU (Format ISET):\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "┌──────────────────────────────────────────────────────────┐\n";
echo "│ [LOGO]  INDONESIAN SOCIETY OF                            │\n";
echo "│         ENGINEERING AND TECHNOLOGY                       │\n";
echo "├──────────────────────────────────────────────────────────┤\n";
echo "│                                                          │\n";
echo "│  ┌────┐   KARTU TANDA ANGGOTA                           │\n";
echo "│  │FOTO│                                                  │\n";
echo "│  │    │   No.Anggota : " . str_pad($member->member_number ?? 'ACC80982052', 30) . "│\n";
echo "│  └────┘   nama       : " . str_pad($user->name ?? 'Abdul Muchlis', 30) . "│\n";
echo "│           Institusi  : " . str_pad($member->institution_name ?? 'Universitas Gunadarma', 30) . "│\n";
echo "│           Kontak     : " . str_pad($member->phone ?? '087787048744', 30) . "│\n";
echo "│           Alamat     : " . str_pad($member->address ?? 'Jl. Sarang Bango', 30) . "│\n";
echo "│           Berlaku    : " . str_pad(($member->join_date ? date('d M Y', strtotime($member->join_date)) : '04 Juli 2025') . ' - ' . ($member->expiry_date ? date('d M Y', strtotime($member->expiry_date)) : '04 Juli 2026'), 30) . "│\n";
echo "│           Disahkan   : " . str_pad($member->join_date ? date('d M Y', strtotime($member->join_date)) : '04 Juli 2025', 30) . "│\n";
echo "│                                                    ┌───┐ │\n";
echo "│  • Kartu berlaku selama masih anggota ISET        │QR │ │\n";
echo "│  • ISET tidak bertanggung jawab atas segala       │   │ │\n";
echo "│    penyalahgunaan melanggar aturan                 └───┘ │\n";
echo "│                                                    Ketua │\n";
echo "└──────────────────────────────────────────────────────────┘\n";
echo "\n";

// Contoh data ideal dari screenshot
echo "📸 CONTOH DARI SCREENSHOT:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "No.Anggota : ACC80982052\n";
echo "nama       : Abdul Muchlis\n";
echo "Institusi  : Universitas Gunadarma\n";
echo "Kontak     : 087787048744\n";
echo "Alamat     : Jl. Sarang Bango\n";
echo "Berlaku    : 04 Juli 2025 - 04 Juli 2026\n";
echo "Disahkan   : 04 Juli 2025\n";
echo "\n";

// Cek semua member
echo "📊 DAFTAR SEMUA MEMBER:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$allMembers = Member::with('user')->get();
echo "Total: " . $allMembers->count() . " member\n\n";

foreach ($allMembers as $m) {
    $u = $m->user;
    echo "• " . ($m->member_number ?? '[No Number]') . "\n";
    echo "  Nama: " . ($u->name ?? '[Nama kosong]') . "\n";
    echo "  Email: " . ($u->email ?? '[Email kosong]') . "\n";
    echo "  Institusi: " . ($m->institution_name ?? '[Institusi kosong]') . "\n";
    echo "  Status: " . $m->status . "\n";
    echo "  Kartu: " . ($m->member_card ? '✅ Ada' : '❌ Belum') . "\n";
    echo "\n";
}

// Lihat registration yang jadi source
echo "\n📝 DATA REGISTRATION (Source):\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$registrations = Registration::where('status', 'approved')->get();
echo "Total: " . $registrations->count() . " registration approved\n\n";

foreach ($registrations as $r) {
    echo "• Email: " . $r->email . "\n";
    echo "  Nama: " . ($r->name ?: '[kosong]') . "\n";
    echo "  Institusi: " . ($r->institution ?: '[kosong]') . "\n";
    echo "  Phone: " . $r->phone . "\n";
    echo "\n";
}
