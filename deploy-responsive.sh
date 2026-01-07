#!/bin/bash
# Script untuk deploy responsive update ke production server
# APJIKOM - Mobile Responsive Update

echo "=========================================="
echo "APJIKOM Mobile Responsive Deployment"
echo "=========================================="
echo ""

# Warna
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Configuration
PRODUCTION_PATH="/path/to/apjikom.or.id"  # Update dengan path server production
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_PATH="$PRODUCTION_PATH/backups/responsive_update_$BACKUP_DATE"

echo -e "${YELLOW}Step 1: Creating backup directory...${NC}"
mkdir -p "$BACKUP_PATH"

echo -e "${YELLOW}Step 2: Backing up current files...${NC}"
cp "$PRODUCTION_PATH/resources/views/member/login.blade.php" "$BACKUP_PATH/"
cp "$PRODUCTION_PATH/resources/views/auth/login.blade.php" "$BACKUP_PATH/"
cp "$PRODUCTION_PATH/resources/views/welcome.blade.php" "$BACKUP_PATH/"

echo -e "${GREEN}✓ Backup completed: $BACKUP_PATH${NC}"
echo ""

echo -e "${YELLOW}Step 3: Copying updated files...${NC}"
# Update paths sesuai dengan lokasi file di komputer development
cp "./resources/views/member/login.blade.php" "$PRODUCTION_PATH/resources/views/member/"
cp "./resources/views/auth/login.blade.php" "$PRODUCTION_PATH/resources/views/auth/"
cp "./resources/views/welcome.blade.php" "$PRODUCTION_PATH/resources/views/"

echo -e "${GREEN}✓ Files copied successfully${NC}"
echo ""

echo -e "${YELLOW}Step 4: Clearing caches...${NC}"
cd "$PRODUCTION_PATH"
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo -e "${GREEN}✓ Cache cleared${NC}"
echo ""

echo -e "${YELLOW}Step 5: Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "${GREEN}✓ Optimization completed${NC}"
echo ""

echo -e "${GREEN}=========================================="
echo "Deployment completed successfully! ✓"
echo "==========================================${NC}"
echo ""
echo "Next steps:"
echo "1. Test homepage: https://apjikom.or.id/"
echo "2. Test member login: https://apjikom.or.id/member/login"
echo "3. Test admin login: https://apjikom.or.id/login"
echo ""
echo "Backup location: $BACKUP_PATH"
echo ""
echo "If something goes wrong, rollback with:"
echo "  cp $BACKUP_PATH/* $PRODUCTION_PATH/resources/views/"
echo ""
