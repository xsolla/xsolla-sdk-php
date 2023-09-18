<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\PaymentAccountRemoveMessage;

class PaymentAccountRemoveMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'payment_account_remove',
        'user' => [
            'ip' => '127.0.0.1',
            'id' => '1234567',
            'name' => 'Xsolla User',
            'email' => 'testuser@xsolla.com',
            'country' => 'VV',
            'zip' => '111222',
        ],
        'settings' => [
            'project_id' => '4567',
            'merchant_id' => '123',
        ],
        'payment_account' => [
            'id' => '98765512341',
            'name' => 'email@example.com',
            'payment_method' => '24',
            'country' => 'VV',
            'type' => 'paypal'
        ],
    ];

    public function test()
    {
        $message = new PaymentAccountRemoveMessage($this->request);
        static::assertSame($this->request['user'], $message->getUser());
        static::assertSame($this->request['settings'], $message->getSettings());
        static::assertSame($this->request['payment_account'], $message->getPaymentAccount());
    }
}