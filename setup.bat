@echo off
echo Installing Composer dependencies...
call composer install

echo Installing NPM dependencies...
call npm install

echo Copying environment file...
copy .env.example .env

echo Generating application key...
call php artisan key:generate

echo Running database migrations...
echo NOTE: If the database does not exist, you might be prompted to create it (Type 'yes').
call php artisan migrate

echo Seeding database...
call php artisan db:seed

echo Linking storage directory...
call php artisan storage:link

echo Building front-end assets...
call npm run build

echo Starting development server...
start cmd.exe /k "php artisan serve"

echo Setup complete. The development server should be starting in a new window.
echo You can access it at http://127.0.0.1:8000 once it's running.

timeout /t 1 /nobreak
start "" "http://127.0.0.1:8000" 