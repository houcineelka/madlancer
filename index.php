<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
if(! defined('STDIN')) define('STDIN', fopen("php://stdin","r"));

// When running under `php -S` (no Apache in front to serve static files
// directly), let the built-in server return existing files as-is instead
// of routing them through the Laravel kernel.
if (PHP_SAPI === 'cli-server') {
    $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if ($path !== '/' && file_exists(__DIR__.$path) && !is_dir(__DIR__.$path)) {
        return false;
    }
    // Packages (e.g. Livewire) publish their JS/CSS under public/ but
    // reference it without the "/public" prefix, matching Apache setups
    // where public/ contents are aliased to the site root.
    $publicFile = __DIR__.'/public'.$path;
    if ($path !== '/' && file_exists($publicFile) && !is_dir($publicFile)) {
        $extensionMimes = [
            'js' => 'application/javascript',
            'css' => 'text/css',
            'json' => 'application/json',
            'svg' => 'image/svg+xml',
        ];
        $ext = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
        header('Content-Type: '.($extensionMimes[$ext] ?? mime_content_type($publicFile) ?: 'application/octet-stream'));
        readfile($publicFile);
        return true;
    }
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
