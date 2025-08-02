<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// composer autoload
require __DIR__.'/../vendor/autoload.php';

// bootstrap the app
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// capture the request and send it through the kernel
$request  = Request::capture();
$response = $kernel->handle($request);

$response->send();

// terminate (fires middleware terminate methods, etc)
$kernel->terminate($request, $response);
