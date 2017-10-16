<?php

namespace App\Repository;

use App\DbModel\UrlDbModel;
use App\Helpers\UrlShortenerHelper;
use Micro\Repository;

class UrlRepository extends Repository
{
    /**
     * @var string
     */
    protected static $dbModel = UrlDbModel::class;

    /**
     * @param $longUrl
     * @return UrlDbModel|null
     */
    public static function findByLongUrl($longUrl)
    {
        /** @var UrlDbModel $model */
        $model = new self::$dbModel();

        return $model->find([
            'long_url' => $longUrl,
        ]);
    }

    /**
     * @param $shortUrl
     * @return UrlDbModel|null
     */
    public static function findByShortUrl($shortUrl)
    {
        /** @var UrlDbModel $model */
        $model = new self::$dbModel();

        return $model->find([
            'short_url' => $shortUrl,
        ]);
    }

    /**
     * @return int
     */
    public static function getMaxId()
    {
        /** @var UrlDbModel $model */
        $model = new self::$dbModel();

        return $model->findMax('id');
    }
}