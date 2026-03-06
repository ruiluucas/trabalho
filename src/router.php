<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$response = new Response();

$routes = [
    '/hello' => __DIR__ . '/controller/hello.php',
    '/bye'   => __DIR__ . '/controller/bye.php',
];

$path = $request->getPathInfo();

if (isset($routes[$path])) {
    require $routes[$path];
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();
