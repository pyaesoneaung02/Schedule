<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    $autoload = __DIR__ . '/../vendor/autoload.php';

    if (!file_exists($autoload)) {
        throw new Exception('vendor/autoload.php not found');
    }

    require_once $autoload;

    $bootstrap = __DIR__ . '/../bootstrap/app.php';

    if (!file_exists($bootstrap)) {
        throw new Exception('bootstrap/app.php not found');
    }

    $app = require_once $bootstrap;

    $request = Request::capture();

    $response = $app->handleRequest($request);

    $response->send();

    $app->terminate($request, $response);

} catch (Throwable $e) {

    http_response_code(500);

    header('Content-Type: text/plain; charset=utf-8');

    echo "LARAVEL VERCEL ERROR\n\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Trace:\n";
    echo $e->getTraceAsString();
}
