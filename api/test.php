<?php

// Simple test to see if PHP is working and env vars are available
echo json_encode([
    'status' => 'PHP is working!',
    'timestamp' => date('Y-m-d H:i:s'),
    'environment_variables' => [
        'APP_KEY' => isset($_ENV['APP_KEY']) ? 'Set (length: ' . strlen($_ENV['APP_KEY']) . ')' : 'Not set',
        'DB_HOST' => $_ENV['DB_HOST'] ?? 'Not set',
        'DB_DATABASE' => $_ENV['DB_DATABASE'] ?? 'Not set',
        'CLOUDINARY_CLOUD_NAME' => $_ENV['CLOUDINARY_CLOUD_NAME'] ?? 'Not set'
    ],
    'database_test' => test_database_connection()
]);

function test_database_connection() {
    try {
        $pdo = new PDO(
            'pgsql:host=' . ($_ENV['DB_HOST'] ?? '') . ';port=5432;dbname=' . ($_ENV['DB_DATABASE'] ?? '') . ';sslmode=require',
            $_ENV['DB_USERNAME'] ?? '',
            $_ENV['DB_PASSWORD'] ?? ''
        );
        return 'Database connection successful!';
    } catch (Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
}