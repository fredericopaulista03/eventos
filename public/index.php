<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Auto Loader...
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    // Graceful fallback if vendor is missing (e.g. before composer install)
    http_response_code(500);
    die('Please run "composer install" to initialize the application.');
}

// Run The Application...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
