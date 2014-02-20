<?php
namespace Xsolla\SDK\Tests;

use Xsolla\SDK\Subscription;

class SubscriptionTest extends \PHPUnit_Framework_TestCase
{
    const ID = 1;
    const NAME = 'test_name';
    const TYPE = 'type';
    const CURRENCY = 'RUB';
    
    public function testGetters()
    {
        $subscription = new Subscription(self::ID, self::NAME, self::TYPE, self::CURRENCY);
        $this->assertSame(self::ID, $subscription->getId());
        $this->assertSame(self::NAME, $subscription->getName());
        $this->assertSame(self::TYPE, $subscription->getType());
        $this->assertSame(self::CURRENCY, $subscription->getCurrency());
    }
}
