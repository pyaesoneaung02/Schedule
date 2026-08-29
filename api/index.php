<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

try {
    require_once __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $request = Request::capture();

    $response = $app->handleRequest($request);

    $response->send();

    $app->terminate($request, $response);

} catch (\Throwable $e) {

    http_response_code(500);

    header('Content-Type: text/plain; charset=utf-8');

    echo "Laravel Vercel Error\n\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
