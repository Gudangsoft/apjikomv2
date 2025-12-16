<?php
/**
 * Sync existing members to directory
 * Auto-enable show_in_directory for all active members
 * 
 * Access: http://127.0.0.1:8000/sync-directory.php
 */

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Member;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Sync Member Directory</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        h1 { color: #667eea; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #28a745; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #17a2b8; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #ffc107; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #dc3545; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th { background: #667eea; color: white; padding: 12px; text-align: left; }
        .table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .table tr:hover { background: #f5f5f5; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-success { background: #28a745; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔄 Sinkronisasi Direktori Anggota</h1>
        <p>Script ini akan mengaktifkan direktori untuk semua anggota aktif yang belum opt-in.</p>
        <hr>";

try {
    // Get all active members
    $totalMembers = Member::where('status', 'active')->count();
    $alreadyInDirectory = Member::where('status', 'active')->where('show_in_directory', true)->count();
    $needsSync = Member::where('status', 'active')->where('show_in_directory', false)->count();
    
    echo "<div class='info'>
            <strong>📊 Status Saat Ini:</strong><br>
            • Total Anggota Aktif: <strong>$totalMembers</strong><br>
            • Sudah di Direktori: <strong>$alreadyInDirectory</strong><br>
            • Perlu Sinkronisasi: <strong>$needsSync</strong>
          </div>";
    
    if ($needsSync == 0) {
        echo "<div class='success'>
                <strong>✅ Sempurna!</strong> Semua anggota aktif sudah ada di direktori.
              </div>";
    } else {
        echo "<div class='warning'>
                <strong>⚠️ Perhatian:</strong> Ada $needsSync anggota yang belum tampil di direktori.
              </div>";
        
        // Get members that need sync
        $membersToSync = Member::with('user')
            ->where('status', 'active')
            ->where('show_in_directory', false)
            ->get();
        
        echo "<h3>📋 Anggota yang Akan Diaktifkan:</h3>";
        echo "<table class='table'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Institusi</th>
                        <th>Jenis</th>
                    </tr>
                </thead>
                <tbody>";
        
        foreach ($membersToSync as $index => $member) {
            $num = $index + 1;
            $name = $member->user->name ?? 'N/A';
            $email = $member->email ?? 'N/A';
            $institution = $member->institution_name ?? '-';
            $type = $member->member_type === 'individual' ? 'Perorangan' : 'Institusi';
            $typeBadge = $member->member_type === 'individual' ? 'badge-info' : 'badge-warning';
            
            echo "<tr>
                    <td>$num</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$institution</td>
                    <td><span class='badge $typeBadge'>$type</span></td>
                  </tr>";
        }
        
        echo "</tbody></table>";
        
        // Ask for confirmation
        if (!isset($_GET['confirm'])) {
            echo "<div class='warning'>
                    <strong>⚠️ Konfirmasi Diperlukan</strong><br>
                    Script ini akan mengaktifkan <strong>$needsSync anggota</strong> untuk tampil di direktori publik.<br><br>
                    <a href='?confirm=yes' style='display: inline-block; padding: 12px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; font-weight: bold;'>
                        ✅ Ya, Aktifkan Semua
                    </a>
                    <a href='/anggota' style='display: inline-block; padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin-left: 10px;'>
                        ❌ Batal
                    </a>
                  </div>";
        } else {
            // Perform sync
            DB::beginTransaction();
            
            try {
                $updated = Member::where('status', 'active')
                    ->where('show_in_directory', false)
                    ->update(['show_in_directory' => true]);
                
                DB::commit();
                
                echo "<div class='success'>
                        <strong>✅ Berhasil!</strong> $updated anggota telah diaktifkan di direktori.<br><br>
                        <a href='/anggota' style='display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 8px; font-weight: bold;'>
                            👥 Lihat Direktori Anggota
                        </a>
                      </div>";
                
                // Show updated stats
                $newTotal = Member::where('status', 'active')->where('show_in_directory', true)->count();
                $individual = Member::where('status', 'active')->where('show_in_directory', true)->where('member_type', 'individual')->count();
                $institution = Member::where('status', 'active')->where('show_in_directory', true)->where('member_type', 'institution')->count();
                
                echo "<div style='margin-top: 20px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;'>
                        <h3 style='color: white; margin-top: 0;'>📊 Statistik Direktori (Updated)</h3>
                        <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 15px;'>
                            <div style='text-align: center; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px;'>
                                <div style='font-size: 32px; font-weight: bold;'>$newTotal</div>
                                <div style='font-size: 14px; margin-top: 5px;'>Total Anggota</div>
                            </div>
                            <div style='text-align: center; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px;'>
                                <div style='font-size: 32px; font-weight: bold;'>$individual</div>
                                <div style='font-size: 14px; margin-top: 5px;'>Perorangan</div>
                            </div>
                            <div style='text-align: center; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px;'>
                                <div style='font-size: 32px; font-weight: bold;'>$institution</div>
                                <div style='font-size: 14px; margin-top: 5px;'>Institusi</div>
                            </div>
                        </div>
                      </div>";
                
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
    
    echo "<div style='margin-top: 30px; padding: 15px; background: #e7f3ff; color: #004085; border-radius: 8px; border-left: 4px solid #007bff;'>
            <strong>ℹ️ Catatan:</strong>
            <ul style='margin: 10px 0 0 0;'>
                <li>Anggota dapat menonaktifkan profil mereka kapan saja melalui halaman profil</li>
                <li>Hanya anggota dengan status <strong>active</strong> yang akan tampil di direktori</li>
                <li>Member dapat menambahkan bio, keahlian, dan social media di halaman profil</li>
                <li>Script ini hanya mengaktifkan member yang sudah ada, member baru akan opt-in manual</li>
            </ul>
          </div>";
    
    echo "<div style='margin-top: 20px; text-align: center;'>
            <a href='/anggota' style='display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 5px;'>
                👥 Lihat Direktori
            </a>
            <a href='/admin/members' style='display: inline-block; padding: 12px 30px; background: #764ba2; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 5px;'>
                ⚙️ Kelola Anggota
            </a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>
            <strong>❌ Error:</strong> " . $e->getMessage() . "
          </div>";
}

echo "
    </div>
</body>
</html>";
