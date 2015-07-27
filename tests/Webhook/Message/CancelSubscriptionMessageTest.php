<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage;

/**
 * @group unit
 */
class CancelSubscriptionMessageTest extends \PHPUnit_Framework_TestCase
{
    protected $request = array (
        'notification_type' => 'cancel_subscription',
        'user' =>
            array (
                'id' => '1234567',
                'name' => 'Xsolla User',
            ),
        'subscription' =>
            array (
                'plan_id' => 'b5dac9c8',
                'subscription_id' => '10',
                'product_id' => 'Demo Product',
                'date_create' => '2014-09-22T19:25:25+04:00',
                'date_end' => '2015-01-22T19:25:25+04:00',
            ),
    );

    public function test()
    {
        $message = new CancelSubscriptionMessage($this->request);
        static::assertSame($this->request['subscription'], $message->getSubscription());
    }
}

