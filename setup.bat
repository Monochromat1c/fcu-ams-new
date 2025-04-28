@echo off
echo Installing Composer dependencies...
composer install

echo Installing NPM dependencies...
npm install

echo Copying environment file...
copy .env.example .env

echo Generating application key...
php artisan key:generate

echo Running database migrations...
echo NOTE: If the database does not exist, you might be prompted to create it (Type 'yes').
php artisan migrate

echo Seeding database...
php artisan db:seed

echo Linking storage directory...
php artisan storage:link

echo Building front-end assets...
npm run build

echo Starting development server...
start cmd.exe /k "php artisan serve"

echo Setup complete. The development server should be starting in a new window.
echo You can access it at http://127.0.0.1:8000 once it's running.
pause 