<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$path = $request->getPathInfo();

$routes = [
    '/hello' => __DIR__ . '/controller/hello.php',
    '/bye'   => __DIR__ . '/controller/bye.php',
];

if (array_key_exists($path, $routes)) {
    $response = require $routes[$path];
} else {
    $response = new Response(
        '<h1>Erro 404</h1><p>Página não encontrada</p>',
        Response::HTTP_NOT_FOUND
    );
}

$response->send();
