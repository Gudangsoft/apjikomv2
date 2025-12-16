<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Run Migration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #00629B;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover { background: #003A5D; }
        .output {
            background: #1a1a1a;
            color: #00ff00;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 400px;
            overflow-y: auto;
        }
        .success { color: #00ff00; }
        .error { color: #ff0000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Database Migration Helper</h1>
        <p>Jalankan migration untuk membuat tabel <strong>partners</strong> di database.</p>
        
        <form method="GET" action="">
            <input type="hidden" name="run" value="1">
            <button type="submit" class="btn">▶ Jalankan Migration Sekarang</button>
        </form>

        <?php
        if (isset($_GET['run'])) {
            echo '<div class="output">';
            echo "=== MENJALANKAN MIGRATION ===\n\n";
            
            // Change to project directory
            chdir(__DIR__);
            
            // Run migration command
            $command = 'php artisan migrate --force 2>&1';
            $output = shell_exec($command);
            
            echo $output;
            echo "\n\n=== SELESAI ===\n";
            echo '<span class="success">✓ Migration berhasil dijalankan!</span>' . "\n";
            echo '<a href="/admin/partners" style="color: #00ff00; text-decoration: underline;">→ Buka Halaman Partners</a>';
            echo '</div>';
        }
        ?>

        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 5px;">
            <strong>⚠️ Catatan:</strong>
            <ul>
                <li>Tool ini hanya untuk development</li>
                <li>Pastikan database sudah terkonfigurasi di file .env</li>
                <li>Jika migration gagal, cek koneksi database</li>
            </ul>
        </div>
    </div>
</body>
</html>
