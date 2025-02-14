<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SoftDeleteAllInventories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:soft-delete-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete all inventories that are not already deleted';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->confirm('Are you sure you want to soft delete all non-deleted inventories? This cannot be undone.')) {
            try {
                $affected = DB::table('inventories')
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now()]);

                $this->info("Successfully soft deleted {$affected} inventory records.");
                return Command::SUCCESS;
            } catch (\Exception $e) {
                $this->error("Failed to soft delete inventories: {$e->getMessage()}");
                return Command::FAILURE;
            }
        }

        $this->info('Operation cancelled.');
        return Command::SUCCESS;
    }
}
