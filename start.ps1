Start-Process -FilePath "cmd.exe" -ArgumentList "/k php artisan serve" -NoNewWindow:$false
Start-Process -FilePath "cmd.exe" -ArgumentList "/k npm run dev" -NoNewWindow:$false 