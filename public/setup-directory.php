<?php
/**
 * Setup script for Member Directory feature
 * Adds directory fields to members table
 * 
 * Access: http://127.0.0.1:8000/setup-directory.php
 */

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup Member Directory</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        h1 { color: #667eea; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #28a745; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #17a2b8; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #dc3545; }
        .code { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-success { background: #28a745; color: white; }
        .badge-info { background: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🗂️ Setup Member Directory</h1>
        <p>Script ini akan menambahkan field direktori anggota ke tabel members.</p>
        <hr>";

try {
    DB::beginTransaction();
    
    // Check if columns already exist
    $hasShowInDirectory = Schema::hasColumn('members', 'show_in_directory');
    $hasExpertise = Schema::hasColumn('members', 'expertise');
    $hasBio = Schema::hasColumn('members', 'bio');
    $hasLinkedin = Schema::hasColumn('members', 'linkedin');
    
    if ($hasShowInDirectory && $hasExpertise && $hasBio && $hasLinkedin) {
        echo "<div class='info'>
                <strong>ℹ️ Info:</strong> Field direktori sudah ada di tabel members. Tidak perlu migrasi.
              </div>";
    } else {
        echo "<div class='info'>
                <strong>⏳ Proses:</strong> Menambahkan field direktori ke tabel members...
              </div>";
        
        Schema::table('members', function (Blueprint $table) use ($hasShowInDirectory, $hasExpertise, $hasBio, $hasLinkedin) {
            if (!$hasShowInDirectory) {
                $table->boolean('show_in_directory')->default(false)->after('website');
            }
            if (!$hasExpertise) {
                $table->text('expertise')->nullable()->after('show_in_directory');
            }
            if (!$hasBio) {
                $table->text('bio')->nullable()->after('expertise');
            }
            if (!$hasLinkedin) {
                $table->string('linkedin')->nullable()->after('bio');
                $table->string('facebook')->nullable()->after('linkedin');
                $table->string('twitter')->nullable()->after('facebook');
                $table->string('instagram')->nullable()->after('twitter');
            }
        });
        
        echo "<div class='success'>
                <strong>✅ Berhasil:</strong> Field direktori berhasil ditambahkan!
                <div class='code'>
                    - show_in_directory (boolean, default: false)<br>
                    - expertise (text, nullable)<br>
                    - bio (text, nullable)<br>
                    - linkedin (string, nullable)<br>
                    - facebook (string, nullable)<br>
                    - twitter (string, nullable)<br>
                    - instagram (string, nullable)
                </div>
              </div>";
    }
    
    DB::commit();
    
    // Feature summary
    echo "<div style='margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;'>
            <h3 style='color: white; margin-top: 0;'>✨ Fitur Member Directory Aktif!</h3>
            <ul style='margin: 10px 0;'>
                <li><span class='badge badge-success'>PUBLIC</span> <strong>Direktori Anggota:</strong> /anggota</li>
                <li><span class='badge badge-success'>PUBLIC</span> <strong>Profil Anggota:</strong> /anggota/{member}</li>
                <li><span class='badge badge-info'>MEMBER</span> <strong>Pengaturan Privasi:</strong> Toggle di halaman profil</li>
                <li><span class='badge badge-info'>MEMBER</span> <strong>Bio & Keahlian:</strong> Tambahkan informasi detail</li>
                <li><span class='badge badge-info'>MEMBER</span> <strong>Social Media:</strong> LinkedIn, Facebook, Twitter, Instagram</li>
            </ul>
            <p style='margin-bottom: 0;'><strong>📋 Fitur:</strong></p>
            <ul style='margin-top: 5px;'>
                <li>🔍 Pencarian by nama, keahlian, institusi</li>
                <li>🔎 Filter by jenis anggota & institusi</li>
                <li>📊 Statistik total anggota</li>
                <li>🔒 Kontrol privasi (opt-in)</li>
                <li>🌐 Social media links</li>
                <li>💼 Showcase expertise & bio</li>
            </ul>
          </div>";
    
    echo "<div style='margin-top: 20px; text-align: center;'>
            <a href='/sync-directory.php' style='display: inline-block; padding: 12px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 5px;'>
                🔄 Sinkronkan Anggota Existing
            </a>
            <a href='/anggota' style='display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 5px;'>
                👥 Lihat Direktori Anggota
            </a>
            <a href='/member/profile' style='display: inline-block; padding: 12px 30px; background: #764ba2; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 5px;'>
                ⚙️ Atur Profil Saya
            </a>
          </div>";
    
    echo "<div style='margin-top: 20px; padding: 15px; background: #fff3cd; color: #856404; border-radius: 8px; border-left: 4px solid #ffc107;'>
            <strong>⚠️ Catatan Penting:</strong>
            <ul style='margin: 10px 0 0 0;'>
                <li>Anggota harus <strong>mengaktifkan toggle</strong> \"Tampilkan profil saya di direktori anggota\" di halaman profil</li>
                <li>Hanya anggota dengan status <strong>active</strong> yang akan ditampilkan</li>
                <li>Profil dapat dilihat publik (tanpa login)</li>
                <li>Anggota dapat menambahkan bio, keahlian, dan link social media</li>
            </ul>
          </div>";
    
} catch (Exception $e) {
    DB::rollBack();
    echo "<div class='error'>
            <strong>❌ Error:</strong> " . $e->getMessage() . "
            <div class='code'>" . $e->getTraceAsString() . "</div>
          </div>";
}

echo "
    </div>
</body>
</html>";
