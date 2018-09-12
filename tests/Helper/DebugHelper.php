<?php

namespace Xsolla\SDK\Tests\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Event\EventInterface;

class DebugHelper
{
    public static function isDebug()
    {
        return in_array('--debug', $GLOBALS['argv'], true);
    }

    public static function addDebugOptionsToHttpClient(Client $guzzleClient)
    {
        $guzzleClient->setDefaultOption('debug', true);
        $echoCb = function (EventInterface $event) {
            echo (string) $event->getRequest().PHP_EOL;
            echo (string) $event->getResponse().PHP_EOL;
        };

        $guzzleClient->getEmitter()->on('complete', $echoCb);
        $guzzleClient->getEmitter()->on('error', $echoCb);
    }
}
