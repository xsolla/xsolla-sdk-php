<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\AfsRejectMessage;

/**
 * @group unit
 */
class AfsRejectMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'afs_reject',
        'user' => [
            'ip' => '127.0.0.1',
            'phone' => '18777976552',
            'email' => 'email@example.com',
            'id' => '1234567',
            'country' => 'US',
         ],
        'transaction' => [
            'id' => 87654321,
            'payment_date' => '2014-09-23T19:25:25+04:00',
            'payment_method' => 1380,
            'external_id' => 12345678,
        ],
        'refund_details' => [
            'code' => 4,
            'reason' => 'Potential fraud',
        ],
    ];

    public function test()
    {
        $message = new AfsRejectMessage($this->request);
        static::assertSame($this->request['transaction']['id'], $message->getPaymentId());
        static::assertSame($this->request['transaction']['external_id'], $message->getExternalPaymentId());
        static::assertSame($this->request['refund_details'], $message->getRefundDetails());
    }
}
