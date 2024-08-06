<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Env;
use App\Router;

Env::load(__DIR__ . '/../.env');

$router = new Router();
$router->handleRequest();
