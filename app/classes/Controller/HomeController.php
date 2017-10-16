<?php

namespace App\Controller;

use App\Router;
use Micro\App;
use Micro\Controller;
use Micro\Controller\TemplateController;
use Micro\Route\StaticRoute;

class HomeController extends TemplateController
{
    public function home()
    {
        /** @var StaticRoute $generateUrlRoute */
        $generateUrlRoute = App::getInstance()->getRoute(Router::ROUTE_GENERATE_URL);

        return $this->render('index.html', [
            'generate_url_route' => '/' . $generateUrlRoute->getUri(),
        ]);
    }
}