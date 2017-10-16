<?php

use App\Router;
use Micro\Route;
use Micro\Route\StaticRoute;

return [
    Router::ROUTE_GENERATE_URL => new StaticRoute([
        'uri' => 'api',
        'action' => '\App\Controller\ApiController::generateShortUrl',
        'params' => ['url'],
    ]),
    new StaticRoute([
        'uri' => '',
        'action' => '\App\Controller\HomeController::home',
    ]),
    Router::DEFAULT_ROUTE => new StaticRoute([
        'action' => '\App\Controller\RedirectController::redirect',
        'params' => [
            Route::PARAM_REQUEST_URI => 'key',
        ],
    ])
];