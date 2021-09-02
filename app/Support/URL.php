<?php

namespace App\Support;

use Illuminate\Support\Str;

class URL
{
    /**
     * Sanitize and ensure HTTPS addresses
     *
     * @param string $url
     * @return string
     */
    public static function sanitize(string $url): string
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $url = str_replace('http://', 'https://', $url);
        $url = Str::start($url, 'https://');

        return $url;
    }

    /**
     * Get the path, optionally removing the extension.
     *
     * @param string $url
     * @param bool $stripExtension
     * @return string
     */
    public static function getPath(string $url, bool $stripExtension = true): string
    {
        $url = self::sanitize($url);

        $url = parse_url($url, PHP_URL_PATH);
        $url = trim($url, '/');

        if ($stripExtension) {
            $url = preg_replace('/\.[^.]+$/', '', $url);
        }

        return $url;
    }
}
