<?php

namespace Xsolla\SDK\Tests\Helper;

use Xsolla\SDK\API\XsollaClient;

class XsollaClientHelper
{
    private static $xsollaClient;

    public static function getXsollaClient($merchantId, $apiKey)
    {
        if (!self::$xsollaClient) {
            self::$xsollaClient = self::createXsollaClient($merchantId, $apiKey);
        }

        return self::$xsollaClient;
    }

    private static function createXsollaClient($merchantId, $apiKey)
    {
        $xsollaClient = XsollaClient::factory(array(
            'merchant_id' => $merchantId,
            'api_key' => $apiKey,
        ));
        if (DebugHelper::isDebug()) {
            DebugHelper::addDebugOptionsToHttpClient($xsollaClient);
        }

        return $xsollaClient;
    }
}
