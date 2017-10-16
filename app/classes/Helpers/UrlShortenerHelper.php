<?php

namespace App\Helpers;

/**
 * Class UrlShortenerHelper
 * @package App\Helpers
 */
class UrlShortenerHelper
{
    /**
     * @var int
     */
    const BASE = 62;

    /**
     * @var string
     */
    const CHARACTERS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @param int $id
     * @return string
     */
    public static function generateShortUrlById($id)
    {
        return self::encode($id);
    }

    /**
     * @param $shortUrl
     * @return string
     */
    public static function getFullUrl($shortUrl)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
            ? "https://"
            : "http://";

        return $protocol . $_SERVER['HTTP_HOST'] . '/' . $shortUrl;
    }

    /**
     * @param int $var
     * @return string
     */
    protected static function encode($var)
    {
        $stack = [];

        while (bccomp($var, 0) != 0) {
            $remainder = bcmod($var, self::BASE);
            $var = bcdiv( bcsub($var, $remainder), self::BASE);
            array_push($stack, self::CHARACTERS[$remainder]);
        }

        return implode('', array_reverse($stack));
    }
}