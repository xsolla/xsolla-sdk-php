<?php
namespace Xsolla\SDK;

class Version
{
    const VERSION = 1.0;

    public static function getVersion()
    {
        return sprintf('xsolla-sdk-php/%s PHP/%s', self::VERSION, PHP_VERSION);
    }
}
