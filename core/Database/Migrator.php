<?php

namespace Core\Database;

use PDO;

class Migrator
{
    public function __construct(private readonly PDO $pdo)
    {}

    private array $migrations = [];

    public function handle(): void
    {
        $this->loadFiles();
        $this->migrate();
    }

    private function loadFiles(): void
    {
        $this->migrations = [
            require base_path('migrations/create_users_table.php')
        ];
    }

    private function migrate()
    {
        foreach ($this->migrations as $migration) {
            if($this->isMigrationRanBefore($migration)) {
                continue;
            }

            $this->runQuery($migration['query']);
        }
    }

    private function isMigrationRanBefore($migration): bool
    {
        return $migration['ran'] === 1;
    }
    private function runQuery($query)
    {
        $this->pdo->exec($query);
    }
}