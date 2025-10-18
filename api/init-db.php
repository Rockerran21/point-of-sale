<?php

// Ensure we're in the right directory
$root = __DIR__ . '/../';
chdir($root);

try {
    // Bootstrap Laravel with custom Vercel bootstrap
    $app = require_once $root . 'bootstrap/vercel.php';
    
    // Check if already initialized
    $pdo = new PDO(
        'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';sslmode=require',
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    
    // Check if users table exists
    $stmt = $pdo->query("SELECT to_regclass('users')");
    $exists = $stmt->fetchColumn();
    
    if ($exists) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Database already initialized',
            'admin_credentials' => [
                'email' => 'super.admin@test.com',
                'password' => '12345678'
            ]
        ]);
        exit;
    }
    
    // Run migrations
    $artisan = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "Running migrations...\n";
    $artisan->call('migrate', ['--force' => true]);
    
    echo "Running seeders...\n";
    $artisan->call('db:seed', ['--force' => true]);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Database initialized successfully!',
        'admin_credentials' => [
            'email' => 'super.admin@test.com',
            'password' => '12345678'
        ],
        'next_steps' => [
            'Visit your app URL',
            'Login with the admin credentials above',
            'Start using your POS system!'
        ]
    ]);
    
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}