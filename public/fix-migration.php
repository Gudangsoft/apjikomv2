<!DOCTYPE html>
<html>
<head>
    <title>Fix Migration</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #00629B; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; margin: 5px; }
        .btn:hover { background: #003A5D; }
        pre { background: #1a1a1a; color: #00ff00; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Fix Migration Partners</h1>
        <p>Tabel 'partners' sudah ada di database, tapi migration belum ditandai sebagai selesai.</p>
        
        <?php
        if (isset($_GET['fix'])) {
            echo '<h2>Hasil:</h2>';
            
            // Load Laravel
            require __DIR__.'/../vendor/autoload.php';
            $app = require_once __DIR__.'/../bootstrap/app.php';
            $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
            
            try {
                // Get migration file name
                $migrationFile = '2025_11_13_000001_create_partners_table';
                
                // Check if already in migrations table
                $exists = DB::table('migrations')
                    ->where('migration', $migrationFile)
                    ->exists();
                
                if ($exists) {
                    echo '<div class="success">✓ Migration sudah terdaftar di database!</div>';
                } else {
                    // Insert to migrations table
                    DB::table('migrations')->insert([
                        'migration' => $migrationFile,
                        'batch' => DB::table('migrations')->max('batch') + 1
                    ]);
                    echo '<div class="success">✓ Migration berhasil ditandai sebagai selesai!</div>';
                }
                
                // Check if table exists
                $tableExists = Schema::hasTable('partners');
                echo '<div class="success">✓ Tabel partners: ' . ($tableExists ? 'ADA' : 'TIDAK ADA') . '</div>';
                
                // Count partners
                $count = DB::table('partners')->count();
                echo '<div class="success">✓ Jumlah partner di database: ' . $count . '</div>';
                
                echo '<br><a href="/admin/partners" class="btn">→ Buka Halaman Partners</a>';
                
            } catch (Exception $e) {
                echo '<div class="error">✗ Error: ' . $e->getMessage() . '</div>';
            }
        } else {
            ?>
            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <strong>Apa yang akan dilakukan:</strong>
                <ul>
                    <li>Menandai migration 'create_partners_table' sebagai sudah dijalankan</li>
                    <li>Tidak akan membuat tabel baru (karena sudah ada)</li>
                    <li>Setelah ini, halaman Partners bisa diakses normal</li>
                </ul>
            </div>
            
            <a href="?fix=1" class="btn">▶ Fix Migration Sekarang</a>
            <?php
        }
        ?>
    </div>
</body>
</html>
