<?php

namespace Xsolla\SDK\Tests\Api;

use Xsolla\SDK\Api\ApiFactory;

class ApiFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var ApiFactory
     */
    protected $apiFactory;

    public function setUp()
    {
        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->apiFactory = new ApiFactory($this->projectMock);
    }

    public function testGetCalculatorApi()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\CalculatorApi', $this->apiFactory->getCalculatorApi());
    }

    public function testGetMobilePaymentApi()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\MobilePaymentApi', $this->apiFactory->getMobilePaymentApi());
    }

    public function testGetNumberApi()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\NumberApi', $this->apiFactory->getNumberApi());
    }

    public function testGetQiwiWalletApi()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\QiwiWalletApi', $this->apiFactory->getQiwiWalletApi());
    }

    public function testGetSubscriptionsApi()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\SubscriptionsApi', $this->apiFactory->getSubscriptionsApi());
    }

    public function testGetSubscriptionsApiIsTest()
    {
        $this->assertInstanceOf('Xsolla\SDK\Api\SubscriptionsApi', $this->apiFactory->getSubscriptionsApi(true));
    }
}
