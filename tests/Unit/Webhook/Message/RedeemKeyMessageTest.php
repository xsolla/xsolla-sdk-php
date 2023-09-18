<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\RedeemKeyMessage;

class RedeemKeyMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'redeem_key',
        'settings' => [
            'project_id' => '4567',
            'merchant_id' => '123',
        ],
        'key' => 'wqdqwwddq9099022',
        'sku' => '123',
        'user_id' => 'sample_user',
        'activation_date' => '2018-11-20T08:38:51+03:00',
        'user_country' => 'EN',
        'restriction' => [
            'name' => 'cls_1',
            'types' => [
                'activation'
            ],
            'countries' => [
                'RU'
            ]
        ],
    ];

    public function test()
    {
        $message = new RedeemKeyMessage($this->request);
        static::assertSame($this->request['settings'], $message->getSettings());
        static::assertSame($this->request['key'], $message->getKey());
        static::assertSame($this->request['sku'], $message->getSku());
        static::assertSame($this->request['user_id'], $message->getUserId());
        static::assertSame($this->request['activation_date'], $message->getActivationDate());
        static::assertSame($this->request['user_country'], $message->getUserCountry());
        static::assertSame($this->request['restriction'], $message->getRestriction());
    }
}