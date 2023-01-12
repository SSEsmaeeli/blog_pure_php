<?php

namespace App\Http\Controllers;

use Core\App;
use Core\Database\Migrator;

class MigrationController
{
    public function __construct(private readonly Migrator $migrator)
    {}

    public function run()
    {
        $this->migrator->handle();

        dd('DONE, all new migrations ran.');
    }
}