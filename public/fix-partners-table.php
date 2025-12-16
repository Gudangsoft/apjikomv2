<!DOCTYPE html>
<html>
<head>
    <title>Fix Partners Table</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 30px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #00629B; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; margin: 5px; }
        .btn:hover { background: #003A5D; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        pre { background: #1a1a1a; color: #00ff00; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        table th { background: #00629B; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Fix Partners Table Structure</h1>
        
        <?php
        require __DIR__.'/../vendor/autoload.php';
        $app = require_once __DIR__.'/../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        if (isset($_GET['action'])) {
            echo '<h2>📋 Hasil:</h2>';
            
            try {
                if ($_GET['action'] == 'check') {
                    // Check current structure
                    echo '<div class="success"><strong>✓ Struktur Tabel Saat Ini:</strong></div>';
                    $columns = DB::select('DESCRIBE partners');
                    
                    echo '<table>';
                    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
                    foreach($columns as $col) {
                        echo '<tr>';
                        echo '<td>' . $col->Field . '</td>';
                        echo '<td>' . $col->Type . '</td>';
                        echo '<td>' . $col->Null . '</td>';
                        echo '<td>' . $col->Key . '</td>';
                        echo '<td>' . ($col->Default ?? 'NULL') . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    
                    $count = DB::table('partners')->count();
                    echo '<div class="success">✓ Jumlah data: ' . $count . ' records</div>';
                    
                } elseif ($_GET['action'] == 'drop') {
                    // Drop and recreate table
                    DB::statement('DROP TABLE IF EXISTS partners');
                    echo '<div class="success">✓ Tabel partners dihapus</div>';
                    
                    // Create fresh table
                    DB::statement("
                        CREATE TABLE partners (
                            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            logo VARCHAR(255) NOT NULL,
                            url VARCHAR(255) NULL,
                            `order` INT NOT NULL DEFAULT 0,
                            is_active TINYINT(1) NOT NULL DEFAULT 1,
                            created_at TIMESTAMP NULL,
                            updated_at TIMESTAMP NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                    ");
                    echo '<div class="success">✓ Tabel partners dibuat ulang dengan struktur yang benar!</div>';
                    
                    // Mark migration as done
                    DB::table('migrations')->where('migration', '2025_11_13_000001_create_partners_table')->delete();
                    DB::table('migrations')->insert([
                        'migration' => '2025_11_13_000001_create_partners_table',
                        'batch' => DB::table('migrations')->max('batch') + 1
                    ]);
                    echo '<div class="success">✓ Migration ditandai sebagai selesai</div>';
                    
                    echo '<br><a href="/admin/partners" class="btn">→ Buka Halaman Partners</a>';
                    
                } elseif ($_GET['action'] == 'alter') {
                    // Try to add missing columns
                    $columns = DB::select("SHOW COLUMNS FROM partners WHERE Field IN ('name', 'logo', 'url', 'order', 'is_active')");
                    $existing = array_column($columns, 'Field');
                    
                    if (!in_array('name', $existing)) {
                        DB::statement("ALTER TABLE partners ADD COLUMN name VARCHAR(255) NOT NULL AFTER id");
                        echo '<div class="success">✓ Kolom "name" ditambahkan</div>';
                    }
                    
                    if (!in_array('logo', $existing)) {
                        DB::statement("ALTER TABLE partners ADD COLUMN logo VARCHAR(255) NOT NULL AFTER name");
                        echo '<div class="success">✓ Kolom "logo" ditambahkan</div>';
                    }
                    
                    if (!in_array('url', $existing)) {
                        DB::statement("ALTER TABLE partners ADD COLUMN url VARCHAR(255) NULL AFTER logo");
                        echo '<div class="success">✓ Kolom "url" ditambahkan</div>';
                    }
                    
                    if (!in_array('order', $existing)) {
                        DB::statement("ALTER TABLE partners ADD COLUMN `order` INT NOT NULL DEFAULT 0 AFTER url");
                        echo '<div class="success">✓ Kolom "order" ditambahkan</div>';
                    }
                    
                    if (!in_array('is_active', $existing)) {
                        DB::statement("ALTER TABLE partners ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER `order`");
                        echo '<div class="success">✓ Kolom "is_active" ditambahkan</div>';
                    }
                    
                    echo '<div class="success"><strong>✓ Tabel berhasil diperbaiki!</strong></div>';
                    echo '<br><a href="?action=check" class="btn">Cek Ulang Struktur</a>';
                    echo '<a href="/admin/partners" class="btn">→ Buka Halaman Partners</a>';
                }
                
            } catch (Exception $e) {
                echo '<div class="error">✗ Error: ' . $e->getMessage() . '</div>';
                echo '<pre>' . $e->getTraceAsString() . '</pre>';
            }
        } else {
            ?>
            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <strong>⚠️ Pilih Aksi:</strong>
            </div>
            
            <h3>1️⃣ Cek Struktur Tabel Saat Ini</h3>
            <p>Lihat kolom apa saja yang ada di tabel partners saat ini.</p>
            <a href="?action=check" class="btn">🔍 Cek Struktur</a>
            
            <hr style="margin: 30px 0;">
            
            <h3>2️⃣ Tambah Kolom yang Kurang (Aman)</h3>
            <p>Menambahkan kolom yang kurang tanpa menghapus data existing.</p>
            <a href="?action=alter" class="btn">➕ Tambah Kolom</a>
            
            <hr style="margin: 30px 0;">
            
            <h3>3️⃣ Drop & Recreate Table (Fresh)</h3>
            <p style="color: red;"><strong>⚠️ PERINGATAN:</strong> Ini akan menghapus semua data!</p>
            <a href="?action=drop" class="btn btn-danger" onclick="return confirm('YAKIN? Semua data partner akan hilang!')">🗑️ Drop & Recreate</a>
            <?php
        }
        ?>
    </div>
</body>
</html>
