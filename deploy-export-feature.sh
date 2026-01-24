#!/bin/bash

# APJIKOM Export Feature Deployment Script
# Script untuk deployment fitur export Excel/CSV dengan data kota

echo "==========================================="
echo "DEPLOYMENT: Fitur Export Excel dengan Kota"
echo "==========================================="

echo "1. Backup database (jika diperlukan)"
echo "   php artisan db:backup (jika ada extension backup)"

echo ""
echo "2. Jalankan migrasi database"
echo "   php artisan migrate"

echo ""
echo "3. Clear cache aplikasi"
echo "   php artisan config:cache"
echo "   php artisan route:cache" 
echo "   php artisan view:cache"

echo ""
echo "4. Test export functionality:"
echo "   - Buka: https://apjikom.or.id/admin/members?tab=members"
echo "   - Klik tombol 'Export CSV' atau 'Export Excel'"
echo "   - Pastikan file berisi kolom kota/provinsi"

echo ""
echo "==========================================="
echo "FILES YANG TELAH DIBUAT/DIUBAH:"
echo "==========================================="
echo "✅ database/migrations/2026_01_24_000002_add_city_province_to_members_table.php"
echo "✅ database/migrations/2026_01_24_000003_add_city_to_registrations_table.php"
echo "✅ app/Models/Member.php (tambah city/province di fillable)"
echo "✅ app/Models/Registration.php (tambah city di fillable)"
echo "✅ app/Http/Controllers/Admin/MemberController.php (tambah export methods)"
echo "✅ app/Exports/MembersExport.php (class baru)"
echo "✅ resources/views/admin/members/partials/members-tab.blade.php"
echo "✅ routes/web.php (tambah export routes)"

echo ""
echo "==========================================="
echo "FITUR EXPORT YANG TERSEDIA:"
echo "==========================================="
echo "• Export CSV dengan statistik summary"
echo "• Export Excel dengan format HTML dan styling"
echo "• Kolom Kota dan Provinsi tersedia"  
echo "• UTF-8 encoding untuk karakter Indonesia"
echo "• Statistik: Total anggota, aktif, terverifikasi, dll"

echo ""
echo "========================================="
echo "PERINTAH DEPLOYMENT:"
echo "========================================="

# Commands to run
COMMANDS=(
    "php artisan migrate"
    "php artisan config:cache"
    "php artisan route:cache"
    "php artisan view:cache"
)

echo "Jalankan perintah berikut di server production:"
for cmd in "${COMMANDS[@]}"; do
    echo "$ $cmd"
done

echo ""
echo "========================================="
echo "TESTING:"
echo "========================================="
echo "1. Login sebagai admin"
echo "2. Buka https://apjikom.or.id/admin/members?tab=members"  
echo "3. Klik 'Export CSV' atau 'Export Excel'"
echo "4. Verifikasi bahwa file export berisi:"
echo "   - Statistik summary di bagian atas"
echo "   - Kolom kota dan provinsi"
echo "   - Data terformat dengan benar"

echo ""
echo "✅ DEPLOYMENT SIAP!"