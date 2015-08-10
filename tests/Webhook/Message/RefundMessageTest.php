<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

/**
 * @group unit
 */
class RefundMessageTest extends PaymentMessageTest
{
    protected $request = array(
        'notification_type' => 'refund',
        'purchase' => array(
                'virtual_currency' => array(
                        'name' => 'Coins',
                        'quantity' => 10,
                        'currency' => 'USD',
                        'amount' => 100,
                    ),
                'subscription' => array(
                        'plan_id' => 1,
                        'subscription_id' => '10',
                        'date_create' => '2014-09-22T19:25:25+04:00',
                        'currency' => 'USD',
                        'amount' => 9.99,
                    ),
                'checkout' => array(
                        'currency' => 'USD',
                        'amount' => 50,
                    ),
                'virtual_items' => array(
                        'items' => array(
                                0 => array(
                                        'sku' => 'test_item1',
                                        'amount' => 1,
                                    ),
                            ),
                        'currency' => 'USD',
                        'amount' => 50,
                    ),
                'total' => array(
                        'currency' => 'USD',
                        'amount' => 200,
                    ),
            ),
        'user' => array(
                'ip' => '127.0.0.1',
                'phone' => '18777976552',
                'email' => 'support@xsolla.com',
                'id' => '1234567',
                'name' => 'Xsolla User',
                'country' => 'US',
            ),
        'transaction' => array(
                'id' => 1,
                'external_id' => 1,
                'dry_run' => 1,
                'agreement' => 1,
            ),
        'refund_details' => array(
                'code' => 1,
                'reason' => 'Fraud',
            ),
        'payment_details' => array(
                'xsolla_fee' => array(
                        'currency' => 'USD',
                        'amount' => '10',
                    ),
                'payout' => array(
                        'currency' => 'USD',
                        'amount' => '200',
                    ),
                'payment_method_fee' => array(
                        'currency' => 'USD',
                        'amount' => '20',
                    ),
                'payment' => array(
                        'currency' => 'USD',
                        'amount' => '230',
                    ),
            ),
        'custom_parameters' => array(
            'parameter1' => 'value1',
            'parameter2' => 'value2',
        ),
    );
}
