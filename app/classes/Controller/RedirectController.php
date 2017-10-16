<?php

namespace App\Controller;

use App\Repository\UrlRepository;
use Micro\Controller;
use Micro\Response\NotFoundResponse;
use Micro\Response\RedirectResponse;

class RedirectController extends Controller
{
    public function redirect($shortUrl)
    {
        $urlModel = UrlRepository::findByShortUrl($shortUrl);
        if (!$urlModel->isLoaded()) {
            return new NotFoundResponse();
        }

        return new RedirectResponse($urlModel->getLongUrl());
    }
}