<?php

namespace App\DbModel;

use App\Helpers\UrlShortenerHelper;
use App\Repository\UrlRepository;
use Micro\DbModel;

/**
 * Class UrlDbModel
 * @package App\DbModel
 */
class UrlDbModel extends DbModel
{
    /**
     * @var string
     */
    const DB = 'url_shortener';

    /**
     * @var string
     */
    const COLLECTION = 'urls';

    /**
     * @var string
     */
    protected $shortUrl;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * @var string
     */
    public static $database = 'url_shortener';

    /**
     * @var string
     */
    public static $collection = 'urls';

    /**
     * @var array
     */
    protected static $fieldsForInsert = ['id', 'short_url', 'long_url'];

    /**
     * @var array
     */
    protected static $fieldsForUpdate = ['id', 'short_url', 'long_url'];

    /**
     * UrlDbModel constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->longUrl = !empty($params['long_url']) ? $params['long_url'] : null;
        $this->shortUrl = !empty($params['short_url']) ? $params['short_url'] : null;
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * @return string
     */
    public function getLongUrl()
    {
        return $this->longUrl;
    }

    /**
     * @param string $shortUrl
     * @return void
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * @param string $longUrl
     * @return void
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;
    }

    /**
     * @param $longUrl
     * @return UrlDbModel
     */
    public static function createByLongUrl($longUrl)
    {
        $urlModel = UrlRepository::findByLongUrl($longUrl);

        if (!$urlModel->isLoaded()) {
            $id = UrlRepository::getMaxId() + 1;
            $urlModel = new self([
                'id' => $id,
                'short_url' => UrlShortenerHelper::generateShortUrlById($id),
                'long_url' => $longUrl,
            ]);
        }

        return $urlModel;
    }
}