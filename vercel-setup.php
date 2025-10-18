<?php

/**
 * Vercel Setup Script
 * 
 * This script helps initialize the database for serverless deployment
 * Run this once after setting up your database connection
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    echo "🚀 Setting up Hamro POS for Vercel deployment...\n";
    
    // Check database connection
    echo "📡 Testing database connection...\n";
    $pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Database connection successful\n";
    
    // Run migrations
    echo "🔄 Running database migrations...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo "✅ Migrations completed\n";
    
    // Run seeders
    echo "🌱 Running database seeders...\n";
    Artisan::call('db:seed', ['--force' => true]);
    echo "✅ Seeders completed\n";
    
    // Generate app key if not exists
    if (empty(getenv('APP_KEY'))) {
        echo "🔑 Generating application key...\n";
        Artisan::call('key:generate', ['--force' => true]);
        echo "✅ Application key generated\n";
        echo "⚠️  Please update your Vercel environment variables with the new APP_KEY\n";
    }
    
    // Cache configurations
    echo "⚡ Caching configurations...\n";
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    echo "✅ Configurations cached\n";
    
    echo "\n🎉 Setup completed successfully!\n";
    echo "📝 Next steps:\n";
    echo "   1. Update your Vercel environment variables\n";
    echo "   2. Deploy to Vercel: vercel --prod\n";
    echo "   3. Access your app at: https://your-app.vercel.app\n";
    echo "   4. Login with: super.admin@test.com / 12345678\n\n";
    
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    echo "💡 Make sure your database credentials are correct in environment variables\n";
    exit(1);
}