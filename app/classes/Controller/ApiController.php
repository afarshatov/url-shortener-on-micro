<?php

namespace App\Controller;

use App\DbModel\UrlDbModel;
use App\Helpers\UrlShortenerHelper;
use Exception;
use Micro\Controller\AjaxController;
use Micro\Locale;
use Micro\Validator\UrlValidator;

class ApiController extends AjaxController
{
    /**
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function generateShortUrl($url)
    {
        $urlValidator = new UrlValidator([
            UrlValidator::MESSAGE_INVALID => Locale::translate('api.errors.url_invalid'),
        ]);

        if (!$urlValidator->isValid($url)) {
            return $this->sendResponse(false, [
                'message' => $urlValidator->getErrorMessage(),
            ]);
        }

        /** @var UrlDbModel $urlModel */
        if (!($urlModel = UrlDbModel::createByLongUrl($url)->save())) {
            return $this->sendResponse(false, [
                'message' => Locale::translate('api.errors.url_not_saved')
            ]);
        }

        return $this->sendResponse(true, [
            'short_url' => UrlShortenerHelper::getFullUrl($urlModel->getShortUrl()),
        ]);
    }
}