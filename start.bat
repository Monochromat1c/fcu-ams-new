@echo off
start cmd.exe /k "php artisan serve"
start cmd.exe /k "npm run dev"
timeout /t 1 /nobreak
start "" "http://127.0.0.1:8000" 