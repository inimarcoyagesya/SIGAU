<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefreshSingleMigration extends Command
{
    protected $signature = 'migrate:refresh-one {path : Relative path to the migration file from base path}';
    protected $description = 'Rollback and re-run a single migration file manually';

    public function handle()
    {
        $relativePath = $this->argument('path');
        $fullPath = base_path($relativePath);

        if (!file_exists($fullPath)) {
            $this->error("Migration file not found: $relativePath");
            return 1;
        }

        require_once $fullPath;

        $className = $this->getMigrationClassName($fullPath);
        if (!class_exists($className)) {
            $this->error("Migration class $className not found in file.");
            return 1;
        }

        /** @var \Illuminate\Database\Migrations\Migration $migrationInstance */
        $migrationInstance = new $className();

        $this->info("Rolling back: $relativePath");
        if (method_exists($migrationInstance, 'down')) {
            $migrationInstance->down();
            DB::table('migrations')->where('migration', Str::afterLast($relativePath, '/'))->delete();
            $this->info("Rollback completed.");
        } else {
            $this->warn("No 'down' method found, skipping rollback.");
        }

        $this->info("Re-running: $relativePath");
        if (method_exists($migrationInstance, 'up')) {
            $migrationInstance->up();
            DB::table('migrations')->insert([
                'migration' => Str::afterLast($relativePath, '/'),
                'batch' => DB::table('migrations')->max('batch') + 1,
            ]);
            $this->info("Re-run completed.");
        } else {
            $this->warn("No 'up' method found, skipping re-run.");
        }

        return 0;
    }

    protected function getMigrationClassName(string $file)
    {
        $contents = file_get_contents($file);
        if (preg_match('/class\s+([^\s]+)\s+extends/', $contents, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
