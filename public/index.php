<?php

use Core\Kernel;

const BASE_PATH = __DIR__.'/../';

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../core/bootstrap.php';

$kernel = $app->get(Kernel::class);

$kernel->handle();