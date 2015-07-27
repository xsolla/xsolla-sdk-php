<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Message\CreateSubscriptionMessage;

/**
 * @group unit
 */
class CreateSubscriptionMessageTest extends \PHPUnit_Framework_TestCase
{
    protected $request = array(
        'notification_type' => 'create_subscription',
        'user' => array(
                'id' => '1234567',
                'name' => 'Xsolla User',
            ),
        'subscription' => array(
                'plan_id' => 'b5dac9c8',
                'subscription_id' => '10',
                'product_id' => 'Demo Product',
                'date_create' => '2014-09-22T19:25:25+04:00',
                'date_next_charge' => '2015-01-22T19:25:25+04:00',
                'trial' => array(
                        'value' => 90,
                        'type' => 'day',
                    ),
            ),
        'coupon' => array(
                'coupon_code' => 'ICvj45S4FUOyy',
                'campaign_code' => '1507',
            ),
    );

    public function test()
    {
        $message = new CreateSubscriptionMessage($this->request);
        static::assertSame($this->request['subscription'], $message->getSubscription());
        static::assertSame($this->request['coupon'], $message->getCoupon());
    }
}
