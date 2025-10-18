<?php

// Ensure we're in the right directory
$root = __DIR__ . '/../';
chdir($root);

// Define Laravel start time
if (!defined('LARAVEL_START')) {
    define('LARAVEL_START', microtime(true));
}

// Create necessary directories for serverless
if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0755, true);
    mkdir('/tmp/storage/framework', 0755, true);
    mkdir('/tmp/storage/framework/cache', 0755, true);
    mkdir('/tmp/storage/framework/sessions', 0755, true);
    mkdir('/tmp/storage/framework/views', 0755, true);
    mkdir('/tmp/bootstrap', 0755, true);
    mkdir('/tmp/bootstrap/cache', 0755, true);
}

// Load the autoloader
require $root . 'vendor/autoload.php';

try {
    // Bootstrap Laravel normally
    $app = require_once $root . 'bootstrap/app.php';
    
    // Override storage path for serverless
    $app->useStoragePath('/tmp/storage');
    
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
    
} catch (Throwable $e) {
    // Fallback error response
    http_response_code(500);
    echo json_encode([
        'error' => 'Application Error',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
