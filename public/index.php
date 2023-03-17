<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use Dotenv\Dotenv;
use src\Application;


require_once __DIR__ . '/../src/Support/helpers.php';
require_once __DIR__ . '/../routes/web.php';

$env = Dotenv::createImmutable(__DIR__ . '/..');
$env->load();

$app = new Application();
$app->run();





