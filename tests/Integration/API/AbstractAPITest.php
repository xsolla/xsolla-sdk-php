<?php

namespace Xsolla\SDK\Tests\Integration\API;

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
            'api_key' => $_SERVER['API_KEY']
        ));
    }
}