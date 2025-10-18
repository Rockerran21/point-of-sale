<?php

// Ensure we're in the right directory
$root = __DIR__ . '/../';
chdir($root);

try {
    // Bootstrap Laravel with custom Vercel bootstrap
    $app = require_once $root . 'bootstrap/vercel.php';
    
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
