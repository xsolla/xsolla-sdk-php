<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Message\PaymentMessage;

/**
 * @group unit
 */
class PaymentMessageTest extends \PHPUnit_Framework_TestCase
{
    protected $request = array(
        'notification_type' => 'payment',
        'purchase' => array(
                'virtual_currency' => array(
                        'name' => 'Coins',
                        'quantity' => 10,
                        'currency' => 'USD',
                        'amount' => 100,
                    ),
                'subscription' => array(
                        'plan_id' => 'b5dac9c8',
                        'subscription_id' => '10',
                        'product_id' => 'Demo Product',
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
                'promotions[0]' => array(
                        'technical_name' => 'Demo Promotion',
                        'id' => '853',
                    ),
                'coupon' => array(
                        'coupon_code' => 'ICvj45S4FUOyy',
                        'campaign_code' => '1507',
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
                'payment_date' => '2014-09-24T20:38:16+04:00',
                'payment_method' => 1,
                'dry_run' => 1,
                'agreement' => 1,
        ),
        'payment_details' => array(
                'payment' => array(
                        'currency' => 'USD',
                        'amount' => 230,
                    ),
                'vat' => array(
                        'currency' => 'USD',
                        'amount' => 0,
                    ),
                'payout_currency_rate' => 1,
                'payout' => array(
                        'currency' => 'USD',
                        'amount' => 200,
                    ),
                'xsolla_fee' => array(
                        'currency' => 'USD',
                        'amount' => 10,
                    ),
                'payment_method_fee' => array(
                        'currency' => 'USD',
                        'amount' => 20,
                    ),
        ),
        'custom_parameters' => array(
                'parameter1' => 'value1',
                'parameter2' => 'value2',
        ),
    );

    public function test()
    {
        $message = new PaymentMessage($this->request);
        static::assertEquals($this->request['purchase'], $message->getPurchase());
        static::assertEquals($this->request['transaction'], $message->getTransaction());
        static::assertEquals($this->request['transaction']['id'], $message->getPaymentId());
        static::assertEquals($this->request['transaction']['external_id'], $message->getExternalPaymentId());
        static::assertEquals($this->request['payment_details'], $message->getPaymentDetails());
        static::assertEquals($this->request['custom_parameters'], $message->getCustomParameters());
        static::assertTrue($message->isDryRun());
    }

    public function testEmptyFields()
    {
        $requestCopy = $this->request;
        unset(
            $requestCopy['custom_parameters'],
            $requestCopy['transaction']['dry_run'],
            $requestCopy['transaction']['external_id']
        );
        $message = new PaymentMessage($requestCopy);

        static::assertNull($message->getExternalPaymentId());
        static::assertEquals(array(), $message->getCustomParameters());
        static::assertFalse($message->isDryRun());
    }
}