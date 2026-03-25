@echo off
REM Start Digitalisasi Development Server

title Digitalisasi - Dev Server
echo.
echo ==========================================
echo Starting Digitalisasi Development Server
echo ==========================================
echo.
echo Terminal 1: Running Laravel Backend Server
echo Terminal 2: Running Frontend Dev (Hot Reload)
echo.
echo Browser: http://localhost:8000/monitoring
echo.
echo Press Ctrl+C to stop both servers
echo ==========================================
echo.

REM Start Laravel server
echo Starting Laravel server on port 8000...
start "Digitalisasi - Laravel Server" cmd /k php artisan serve

REM Wait a moment for server to start
timeout /t 3

REM Start Vite dev server
echo Starting Vite dev server on port 5173...
start "Digitalisasi - Front End Dev" cmd /k npm run dev

echo.
echo ✅ Development servers started!
echo.
pause
