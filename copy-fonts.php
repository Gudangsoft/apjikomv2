<?php
/**
 * Script untuk copy font Arial dari Windows ke storage Laravel
 */

// Buat direktori fonts jika belum ada
$fontsDir = __DIR__ . '/storage/fonts';
if (!is_dir($fontsDir)) {
    mkdir($fontsDir, 0755, true);
    echo "✅ Direktori fonts dibuat: $fontsDir\n";
}

// Path font Windows
$windowsFontsPath = 'C:/Windows/Fonts/';

// Font yang akan di-copy
$fonts = [
    'arial.ttf' => 'Arial Regular',
    'arialbd.ttf' => 'Arial Bold',
    'ariali.ttf' => 'Arial Italic',
    'arialbi.ttf' => 'Arial Bold Italic'
];

echo "📂 Mencari font Arial di Windows...\n\n";

foreach ($fonts as $filename => $fontName) {
    $sourcePath = $windowsFontsPath . $filename;
    $destPath = $fontsDir . '/' . $filename;
    
    if (file_exists($sourcePath)) {
        if (copy($sourcePath, $destPath)) {
            echo "✅ $fontName copied: $filename\n";
            echo "   Source: $sourcePath\n";
            echo "   Dest: $destPath\n\n";
        } else {
            echo "❌ Gagal copy $fontName\n\n";
        }
    } else {
        echo "⚠️  $fontName tidak ditemukan di Windows Fonts\n\n";
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Selesai! Font siap digunakan.\n";
echo "Path: " . realpath($fontsDir) . "\n";
