# APJIKOM Export Feature Deployment Script (PowerShell)
# Script untuk deployment fitur export Excel/CSV dengan data kota

Write-Host "==========================================="
Write-Host "DEPLOYMENT: Fitur Export Excel dengan Kota"
Write-Host "==========================================="

Write-Host "1. Backup database (jika diperlukan)"
Write-Host "   php artisan db:backup (jika ada extension backup)"

Write-Host ""
Write-Host "2. Jalankan migrasi database"
Write-Host "   php artisan migrate"

Write-Host ""
Write-Host "3. Clear cache aplikasi"
Write-Host "   php artisan config:cache"
Write-Host "   php artisan route:cache"
Write-Host "   php artisan view:cache"

Write-Host ""
Write-Host "4. Test export functionality:"
Write-Host "   - Buka: https://apjikom.or.id/admin/members?tab=members"
Write-Host "   - Klik tombol 'Export CSV' atau 'Export Excel'"
Write-Host "   - Pastikan file berisi kolom kota/provinsi"

Write-Host ""
Write-Host "==========================================="
Write-Host "FILES YANG TELAH DIBUAT/DIUBAH:"
Write-Host "==========================================="
Write-Host "✅ database/migrations/2026_01_24_000002_add_city_province_to_members_table.php"
Write-Host "✅ database/migrations/2026_01_24_000003_add_city_to_registrations_table.php"
Write-Host "✅ app/Models/Member.php (tambah city/province di fillable)"
Write-Host "✅ app/Models/Registration.php (tambah city di fillable)"
Write-Host "✅ app/Http/Controllers/Admin/MemberController.php (tambah export methods)"
Write-Host "✅ app/Exports/MembersExport.php (class baru)"
Write-Host "✅ resources/views/admin/members/partials/members-tab.blade.php"
Write-Host "✅ routes/web.php (tambah export routes)"

Write-Host ""
Write-Host "==========================================="
Write-Host "FITUR EXPORT YANG TERSEDIA:"
Write-Host "==========================================="
Write-Host "• Export CSV dengan statistik summary"
Write-Host "• Export Excel dengan format HTML dan styling"
Write-Host "• Kolom Kota dan Provinsi tersedia"
Write-Host "• UTF-8 encoding untuk karakter Indonesia"
Write-Host "• Statistik: Total anggota, aktif, terverifikasi, dll"

Write-Host ""
Write-Host "========================================="
Write-Host "PERINTAH DEPLOYMENT:"
Write-Host "========================================="

# Commands to run
$commands = @(
    "php artisan migrate",
    "php artisan config:cache",
    "php artisan route:cache",
    "php artisan view:cache"
)

Write-Host "Jalankan perintah berikut di server production:"
foreach ($cmd in $commands) {
    Write-Host "PS> $cmd"
}

Write-Host ""
Write-Host "========================================="
Write-Host "AUTO DEPLOYMENT (opsional):"
Write-Host "========================================="

$runDeployment = Read-Host "Jalankan deployment otomatis sekarang? (y/N)"
if ($runDeployment -eq 'y' -or $runDeployment -eq 'Y') {
    Write-Host "Memulai deployment..."
    
    foreach ($cmd in $commands) {
        Write-Host "Menjalankan: $cmd" -ForegroundColor Yellow
        Invoke-Expression $cmd
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Berhasil: $cmd" -ForegroundColor Green
        } else {
            Write-Host "❌ Gagal: $cmd" -ForegroundColor Red
            Write-Host "Error code: $LASTEXITCODE"
        }
        Write-Host ""
    }
    
    Write-Host "========================================="
    Write-Host "DEPLOYMENT SELESAI!"
    Write-Host "========================================="
}

Write-Host ""
Write-Host "========================================="
Write-Host "TESTING:"
Write-Host "========================================="
Write-Host "1. Login sebagai admin"
Write-Host "2. Buka https://apjikom.or.id/admin/members?tab=members"
Write-Host "3. Klik 'Export CSV' atau 'Export Excel'"
Write-Host "4. Verifikasi bahwa file export berisi:"
Write-Host "   - Statistik summary di bagian atas"
Write-Host "   - Kolom kota dan provinsi"
Write-Host "   - Data terformat dengan benar"

Write-Host ""
Write-Host "✅ DEPLOYMENT SIAP!" -ForegroundColor Green