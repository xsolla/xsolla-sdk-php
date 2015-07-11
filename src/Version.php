<?php

namespace Xsolla\SDK;

class Version 
{
    const VERSION = '2.0-alpha';

    /**
     * @return string
     */
    public static function getVersion()
    {
        $curlVersion = curl_version();
        return sprintf(
            'xsolla-sdk-php/%s curl/%s PHP/%s',
            self::VERSION,
            $curlVersion['version'],
            PHP_VERSION
        );
    }
}