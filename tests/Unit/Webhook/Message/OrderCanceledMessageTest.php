<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\OrderCanceledMessage;

class OrderCanceledMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'order_canceled',
        'items' => [
            [
                'sku' => 'virtual-good-item_test',
                'type' => 'virtual_good',
                'is_pre_order' => false,
                'quantity' => 3,
                'amount' => '1000',
                'promotions' => [
                    [
                        'amount_without_discount' => '6000',
                        'amount_with_discount' => '5000',
                        'sequence' => 1,
                    ],
                    [
                        'amount_without_discount' => '5000',
                        'amount_with_discount' => '4000',
                        'sequence' => 2,
                    ],
                ],
            ],
            [
                'sku' => 'virtual-good-item_test_bundle',
                'type' => 'bundle',
                'is_pre_order' => false,
                'quantity' => 1,
                'amount' => '1000',
                'promotions' => [],
            ],
            [
                'sku' => 'gold',
                'type' => 'virtual_currency',
                'is_pre_order' => false,
                'quantity' => 1500,
                'amount' => '[null]',
                'promotions' => [],
            ],
        ],
        'order' => [
            'id' => 1,
            'mode' => 'default',
            'currency_type' => 'virtual',
            'currency' => 'sku_currency',
            'amount' => '2000',
            'status' => 'paid',
            'platform' => 'xsolla',
            'comment' => null,
            'invoice_id' => '1',
            'promotions' => [
                [
                    'amount_without_discount' => '4000',
                    'amount_with_discount' => '2000',
                    'sequence' => 1,
                ]
            ],
            'promocodes' => [
                [
                    'code' => 'promocode_some_code',
                    'external_id' => 'promocode_some_sku',
                ]
            ],
            'coupons' => [
                [
                    'code' => 'WINTER2021_example',
                    'external_id' => 'some_coupon_sku',
                ]
            ],
        ],
        'user' => [
            'external_id' => 'id_xsolla_login_1',
            'email' => 'gc_user@xsolla.com',
        ],
    ];

    public function test()
    {
        $message = new OrderCanceledMessage($this->request);
        static::assertSame($this->request['items'], $message->getItems());
        static::assertSame($this->request['order'], $message->getOrder());
    }
}