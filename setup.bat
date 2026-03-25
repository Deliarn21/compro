@echo off
REM ==============================================
REM Setup Digitalisasi Monitoring System (Windows)
REM ==============================================

echo.
echo ==========================================
echo Setup Digitalisasi Monitoring System
echo ==========================================
echo.

REM Step 1: Install Composer Dependencies
echo.
echo [1/5] Installing composer dependencies...
call composer install
if errorlevel 1 (
    echo Error installing composer dependencies!
    exit /b 1
)

REM Step 2: Environment Setup
echo.
echo [2/5] Setting up environment...
if not exist .env (
    copy .env.example .env
)
call php artisan key:generate

REM Step 3: Database Setup
echo.
echo [3/5] Setting up database...
call php artisan migrate --seed
if errorlevel 1 (
    echo Database migration failed!
    exit /b 1
)

REM Step 4: Install NPM Dependencies
echo.
echo [4/5] Installing npm dependencies...
call npm install
if errorlevel 1 (
    echo Error installing npm dependencies!
    exit /b 1
)

REM Step 5: Build Assets
echo.
echo [5/5] Building frontend assets...
call npm run build
if errorlevel 1 (
    echo Error building assets!
    exit /b 1
)

REM Clear Caches
echo.
echo Clearing caches...
call php artisan optimize:clear

echo.
echo ==========================================
echo ✅ Setup Complete!
echo ==========================================
echo.
echo Next Steps:
echo 1. Open Terminal 1: php artisan serve
echo 2. Open Terminal 2: npm run dev
echo 3. Open browser: http://localhost:8000/monitoring
echo.
pause
