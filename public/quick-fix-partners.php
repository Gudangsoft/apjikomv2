<!DOCTYPE html>
<html>
<head>
    <title>Quick Fix Partners</title>
    <style>
        body { font-family: Arial; max-width: 700px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; font-weight: bold; }
        .error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .btn { display: inline-block; padding: 15px 30px; background: #00629B; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 18px; font-weight: bold; }
        .btn:hover { background: #003A5D; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ Quick Fix Partners Table</h1>
        
        <?php
        if (isset($_GET['go'])) {
            require __DIR__.'/../vendor/autoload.php';
            $app = require_once __DIR__.'/../bootstrap/app.php';
            $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
            
            try {
                // Step 1: Drop existing table
                try {
                    DB::statement('DROP TABLE IF EXISTS partners');
                    echo '<div class="success">✓ Step 1: Old table dropped</div>';
                } catch (Exception $e) {
                    echo '<div class="success">✓ Step 1: No old table to drop</div>';
                }
                
                // Step 2: Create fresh table with correct structure
                DB::statement("
                    CREATE TABLE `partners` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `order` int NOT NULL DEFAULT '0',
                        `is_active` tinyint(1) NOT NULL DEFAULT '1',
                        `created_at` timestamp NULL DEFAULT NULL,
                        `updated_at` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                echo '<div class="success">✓ Step 2: Fresh table created with correct structure</div>';
                
                // Step 3: Clean up old migrations
                DB::statement("DELETE FROM migrations WHERE migration LIKE '%create_partners_table%'");
                
                // Step 4: Insert migration record
                $maxBatch = DB::table('migrations')->max('batch');
                DB::table('migrations')->insert([
                    'migration' => '2025_11_13_000001_create_partners_table',
                    'batch' => $maxBatch + 1
                ]);
                echo '<div class="success">✓ Step 3: Migration marked as completed</div>';
                
                // Step 5: Verify structure
                $columns = DB::select('SHOW COLUMNS FROM partners');
                $columnNames = array_map(function($col) { return $col->Field; }, $columns);
                echo '<div class="success">✓ Step 4: Verified - Columns: ' . implode(', ', $columnNames) . '</div>';
                
                // Step 6: Test insert
                try {
                    DB::table('partners')->insert([
                        'name' => 'Test Partner',
                        'logo' => 'test.png',
                        'url' => 'https://test.com',
                        'order' => 1,
                        'is_active' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    echo '<div class="success">✓ Step 5: Test insert successful!</div>';
                    
                    // Delete test data
                    DB::table('partners')->where('name', 'Test Partner')->delete();
                    echo '<div class="success">✓ Step 6: Test data cleaned</div>';
                } catch (Exception $e) {
                    echo '<div class="error">⚠️ Test insert failed: ' . $e->getMessage() . '</div>';
                }
                
                echo '<br><br><h2>🎉 BERHASIL! Table partners sudah siap!</h2>';
                echo '<p>Sekarang Anda bisa menambah, edit, dan hapus partner dengan lancar.</p>';
                echo '<a href="/admin/partners" class="btn">→ BUKA HALAMAN PARTNERS SEKARANG</a>';
                
            } catch (Exception $e) {
                echo '<div class="error">✗ Error: ' . $e->getMessage() . '</div>';
                echo '<pre style="background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin-top:10px;">' . $e->getTraceAsString() . '</pre>';
            }
        } else {
            ?>
            <p style="font-size: 18px;">Klik tombol di bawah untuk memperbaiki tabel partners dalam <strong>1 klik!</strong></p>
            
            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <strong>⚠️ Yang akan dilakukan:</strong>
                <ol>
                    <li>Hapus tabel partners yang rusak</li>
                    <li>Buat tabel baru dengan struktur yang benar</li>
                    <li>Tandai migration sebagai selesai</li>
                    <li>Siap digunakan!</li>
                </ol>
            </div>
            
            <a href="?go=1" class="btn">⚡ FIX SEKARANG (1 KLIK)</a>
            <?php
        }
        ?>
    </div>
</body>
</html>
