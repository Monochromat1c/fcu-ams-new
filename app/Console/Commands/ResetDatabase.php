<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    protected $signature = 'db:reset';
    protected $description = 'Resets the database by wiping, migrating, and seeding';

    public function handle()
    {
        $this->call('db:wipe');
        $this->call('migrate');
        $this->call('db:seed');
        
        $this->info('Database reset successfully!');
    }
}
