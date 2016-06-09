<?php

namespace Xsolla\SDK\Tests\Helper;

use Guzzle\Common\Event;
use Guzzle\Http\Client;

class DebugHelper
{
    public static function isDebug()
    {
        return in_array('--debug', $GLOBALS['argv'], true);
    }

    public static function addDebugOptionsToHttpClient(Client $guzzleClient)
    {
        $guzzleClient->setDefaultOption('debug', true);
        $echoCb = function (Event $event) {
            echo (string) $event['request'].PHP_EOL;
            echo (string) $event['response'].PHP_EOL;
        };
        $guzzleClient->getEventDispatcher()->addListener('request.complete', $echoCb);
        $guzzleClient->getEventDispatcher()->addListener('request.exception', $echoCb);
    }
}
