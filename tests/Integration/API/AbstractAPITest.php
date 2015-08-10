<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Guzzle\Common\Event;
use Xsolla\SDK\API\XsollaClient;

abstract class AbstractAPITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XsollaClient
     */
    protected $xsollaClient;

    protected $projectId;

    public function setUp()
    {
        $this->projectId = (int) $_SERVER['PROJECT_ID'];
        $this->xsollaClient = XsollaClient::factory(array(
            'merchant_id' => $_SERVER['MERCHANT_ID'],
            'api_key' => $_SERVER['API_KEY'],
        ));
        global $argv;
        if (in_array('--debug', $argv, true)) {
            $echoCb = function (Event $event) {
                echo (string) $event['request'].PHP_EOL;
                echo (string) $event['response'].PHP_EOL;
            };
            $this->xsollaClient->getEventDispatcher()->addListener('request.complete', $echoCb);
            $this->xsollaClient->getEventDispatcher()->addListener('request.exception', $echoCb);
        }
    }
}
