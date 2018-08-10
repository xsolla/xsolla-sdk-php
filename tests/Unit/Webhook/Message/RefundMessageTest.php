<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

/**
 * @group unit
 */
class RefundMessageTest extends PaymentMessageTest
{
    protected $request = [
        'notification_type' => 'refund',
        'purchase' => [
                'virtual_currency' => [
                        'name' => 'Coins',
                        'quantity' => 10,
                        'currency' => 'USD',
                        'amount' => 100,
                    ],
                'subscription' => [
                        'plan_id' => 1,
                        'subscription_id' => '10',
                        'date_create' => '2014-09-22T19:25:25+04:00',
                        'currency' => 'USD',
                        'amount' => 9.99,
                    ],
                'checkout' => [
                        'currency' => 'USD',
                        'amount' => 50,
                    ],
                'virtual_items' => [
                        'items' => [
                                0 => [
                                        'sku' => 'test_item1',
                                        'amount' => 1,
                                    ],
                            ],
                        'currency' => 'USD',
                        'amount' => 50,
                    ],
                'total' => [
                        'currency' => 'USD',
                        'amount' => 200,
                    ],
            ],
        'user' => [
                'ip' => '127.0.0.1',
                'phone' => '18777976552',
                'email' => 'support@xsolla.com',
                'id' => '1234567',
                'name' => 'Xsolla User',
                'country' => 'US',
            ],
        'transaction' => [
                'id' => 1,
                'external_id' => 1,
                'dry_run' => 1,
                'agreement' => 1,
            ],
        'refund_details' => [
                'code' => 1,
                'reason' => 'Fraud',
            ],
        'payment_details' => [
                'xsolla_fee' => [
                        'currency' => 'USD',
                        'amount' => '10',
                    ],
                'payout' => [
                        'currency' => 'USD',
                        'amount' => '200',
                    ],
                'payment_method_fee' => [
                        'currency' => 'USD',
                        'amount' => '20',
                    ],
                'payment' => [
                        'currency' => 'USD',
                        'amount' => '230',
                    ],
            ],
        'custom_parameters' => [
            'parameter1' => 'value1',
            'parameter2' => 'value2',
        ],
    ];
}
