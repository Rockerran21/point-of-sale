<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Require the Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Create necessary directories in /tmp for serverless
if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0755, true);
    mkdir('/tmp/storage/framework', 0755, true);
    mkdir('/tmp/storage/framework/cache', 0755, true);
    mkdir('/tmp/storage/framework/sessions', 0755, true);
    mkdir('/tmp/storage/framework/views', 0755, true);
    mkdir('/tmp/bootstrap', 0755, true);
    mkdir('/tmp/bootstrap/cache', 0755, true);
}

// Bootstrap Laravel
$app = require_once __DIR__ . '/app.php';

// Override paths for serverless
$app->useStoragePath('/tmp/storage');
$app->useDatabasePath('/tmp');

// Boot the application first to register all service providers
$app->boot();

// Now override configuration after services are registered
$app['config']->set('view.compiled', '/tmp/storage/framework/views');
$app['config']->set('cache.stores.file.path', '/tmp/storage/framework/cache');
$app['config']->set('session.files', '/tmp/storage/framework/sessions');
$app['config']->set('filesystems.disks.local.root', '/tmp/storage/app');
$app['config']->set('cache.default', 'array');
$app['config']->set('session.driver', 'cookie');

return $app;
