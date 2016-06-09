<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Tests\Helper\XsollaClientHelper;

abstract class AbstractAPITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XsollaClient
     */
    protected static $xsollaClient;

    /**
     * @var int
     */
    protected static $projectId;

    /**
     * @var int
     */
    protected static $merchantId;

    /**
     * @var string
     */
    protected static $userId;

    public static function setUpBeforeClass()
    {
        static::$projectId = (int) getenv('PROJECT_ID');
        static::$merchantId = (int) getenv('MERCHANT_ID');
        static::$userId = getenv('USER_ID');
        static::$xsollaClient = XsollaClientHelper::getXsollaClient(static::$merchantId, getenv('API_KEY'));
    }

    public function generateVirtualItemTemplate($sku)
    {
        return array(
            'sku' => $sku,
            'name' => array(
                'en' => 'Virtual Item',
            ),
            'description' => array(
                'en' => 'Virtual Item Description',
            ),
            'prices' => array(
                'USD' => 1,
            ),
            'default_currency' => 'USD',
            'enabled' => true,
            'disposable' => false,
            'item_type' => 'Consumable',
        );
    }
}
