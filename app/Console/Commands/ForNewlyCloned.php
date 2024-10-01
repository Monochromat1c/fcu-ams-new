<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ForNewlyCloned extends Command
{
    protected $signature = 'initialize';
    protected $description = 'asdf';

    public function handle()
    {
        $this->info('Installing dependencies...');
        exec('npm install');

        $this->info('Copying .env.example to .env...');
        exec('cp .env.example .env');

        $this->info('Generating application key...');
        $this->call('key:generate');

        $this->info('Running migrations...');
        $this->call('php artisan migrate');

        $this->info('Seeding the database...');
        $this->call('db:seed');

        $this->info('Building assets...');
        exec('npm run build');

        $this->info('Starting the development server...');
        exec('php artisan serve');

        $this->info('Project initialized successfully!');
    }
}
