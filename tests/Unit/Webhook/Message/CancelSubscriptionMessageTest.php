<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage;

/**
 * @group unit
 */
class CancelSubscriptionMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'cancel_subscription',
        'user' => [
                'id' => '1234567',
                'name' => 'Xsolla User',
            ],
        'subscription' => [
                'plan_id' => 1,
                'subscription_id' => '10',
                'product_id' => 'Demo Product',
                'date_create' => '2014-09-22T19:25:25+04:00',
                'date_end' => '2015-01-22T19:25:25+04:00',
            ],
    ];

    public function test()
    {
        $message = new CancelSubscriptionMessage($this->request);
        static::assertSame($this->request['subscription'], $message->getSubscription());
    }
}
