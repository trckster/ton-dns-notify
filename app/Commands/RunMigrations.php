<?php

namespace App\Commands;

use App\Interfaces\CommandInterface;
use App\Services\Log;
use Doctrine\DBAL\DriverManager;

class RunMigrations implements CommandInterface
{
    public function handle(): void
    {
        Log::info('Running migrations:');

        $this->migrate();

        Log::info('Migrated.');
    }

    private function migrate(): void
    {
        $directoryContent = scandir(getBaseDir('migrations'));
        $files = array_diff($directoryContent, ['.', '..']);

        $connection = DriverManager::getConnection(getDatabaseEnv(true));

        foreach ($files as $file) {
            Log::info("Migrating $file...");

            $migrationFile = getBaseDir('migrations/' . $file);

            $connection->executeQuery(file_get_contents($migrationFile));
        }
    }
}