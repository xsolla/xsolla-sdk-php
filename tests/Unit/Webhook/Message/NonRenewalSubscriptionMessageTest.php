<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\NonRenewalSubscriptionMessage;

/**
 * @group unit
 */
class NonRenewalSubscriptionMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'non_renewal_subscription',
        'user' => [
                'id' => '1234567',
                'name' => 'Xsolla User',
                'email' => 'support@xsolla.com',
            ],
        'subscription' => [
                'plan_id' => 1,
                'subscription_id' => '10',
                'date_create' => '2021-10-19T15:00:00+04:00',
                'date_next_charge' => '2021-11-19T15:00:00+04:00',
                'currency' => 'USD',
                'amount' => 5,
            ],
    ];

    public function test()
    {
        $message = new NonRenewalSubscriptionMessage($this->request);
        static::assertSame($this->request['subscription'], $message->getSubscription());
    }
}
