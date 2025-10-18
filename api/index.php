<?php

// Ensure we're in the right directory
$root = __DIR__ . '/../';
chdir($root);

// Define Laravel constants
if (!defined('LARAVEL_START')) {
    define('LARAVEL_START', microtime(true));
}

// Load the autoloader
require $root . 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once $root . 'bootstrap/app.php';

// Create the HTTP kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Capture the request
$request = Illuminate\Http\Request::capture();

// Handle the request
$response = $kernel->handle($request);

// Send the response
$response->send();

// Terminate the request
$kernel->terminate($request, $response);
