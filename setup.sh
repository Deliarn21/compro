#!/bin/bash

# Setup script untuk Digitalisasi Monitoring System

echo "=========================================="
echo "Setup Digitalisasi Monitoring System"
echo "=========================================="

# 1. Install Composer Dependencies
echo ""
echo "1. Installing composer dependencies..."
composer install

# 2. Setup Environment
echo ""
echo "2. Setting up environment..."
cp .env.example .env 2>/dev/null || true
php artisan key:generate

# 3. Database Setup
echo ""
echo "3. Setting up database..."
php artisan migrate --seed

# 4. Install NPM Dependencies
echo ""
echo "4. Installing npm dependencies..."
npm install

# 5. Build Assets
echo ""
echo "5. Building assets..."
npm run build

# 6. Clear Caches
echo ""
echo "6. Clearing caches..."
php artisan optimize:clear

echo ""
echo "=========================================="
echo "✅ Setup complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Run: php artisan serve"
echo "2. In another terminal: npm run dev"
echo "3. Open: http://localhost:8000/monitoring"
echo ""
