# PowerShell Script untuk Deploy Responsive Update ke Production
# APJIKOM - Mobile Responsive Update

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "APJIKOM Mobile Responsive Deployment" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Configuration
$ProductionPath = "\\server\path\to\apjikom.or.id"  # Update dengan path server production
$BackupDate = Get-Date -Format "yyyyMMdd_HHmmss"
$BackupPath = "$ProductionPath\backups\responsive_update_$BackupDate"

Write-Host "Step 1: Creating backup directory..." -ForegroundColor Yellow
New-Item -ItemType Directory -Path $BackupPath -Force | Out-Null

Write-Host "Step 2: Backing up current files..." -ForegroundColor Yellow
Copy-Item "$ProductionPath\resources\views\member\login.blade.php" "$BackupPath\" -Force
Copy-Item "$ProductionPath\resources\views\auth\login.blade.php" "$BackupPath\" -Force
Copy-Item "$ProductionPath\resources\views\welcome.blade.php" "$BackupPath\" -Force

Write-Host "✓ Backup completed: $BackupPath" -ForegroundColor Green
Write-Host ""

Write-Host "Step 3: Copying updated files..." -ForegroundColor Yellow
Copy-Item ".\resources\views\member\login.blade.php" "$ProductionPath\resources\views\member\" -Force
Copy-Item ".\resources\views\auth\login.blade.php" "$ProductionPath\resources\views\auth\" -Force
Copy-Item ".\resources\views\welcome.blade.php" "$ProductionPath\resources\views\" -Force

Write-Host "✓ Files copied successfully" -ForegroundColor Green
Write-Host ""

Write-Host "Step 4: Clearing caches..." -ForegroundColor Yellow
Set-Location $ProductionPath
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

Write-Host "✓ Cache cleared" -ForegroundColor Green
Write-Host ""

Write-Host "Step 5: Optimizing for production..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host "✓ Optimization completed" -ForegroundColor Green
Write-Host ""

Write-Host "==========================================" -ForegroundColor Green
Write-Host "Deployment completed successfully! ✓" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:"
Write-Host "1. Test homepage: https://apjikom.or.id/"
Write-Host "2. Test member login: https://apjikom.or.id/member/login"
Write-Host "3. Test admin login: https://apjikom.or.id/login"
Write-Host ""
Write-Host "Backup location: $BackupPath" -ForegroundColor Cyan
Write-Host ""
Write-Host "If something goes wrong, rollback with:" -ForegroundColor Yellow
Write-Host "  Copy-Item $BackupPath\* $ProductionPath\resources\views\ -Force" -ForegroundColor Yellow
Write-Host ""
