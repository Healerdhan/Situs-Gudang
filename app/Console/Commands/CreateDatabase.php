<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'create:database';
    protected $description = 'Creates the database based on the DB_DATABASE config setting';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $databaseName = env('DB_DATABASE', false);

        if (!$databaseName) {
            $this->info('No database specified in .env');
            return;
        }

        try {
            $charset = config("database.connections.mysql.charset", 'utf8mb4');
            $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');
            config(["database.connections.mysql.database" => null]);

            $query = "CREATE DATABASE IF NOT EXISTS $databaseName CHARACTER SET $charset COLLATE $collation;";
            DB::statement($query);

            config(["database.connections.mysql.database" => $databaseName]);

            $this->info("Database '$databaseName' created or already exists.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
