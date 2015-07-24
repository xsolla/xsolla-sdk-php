<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Message\UserBalanceMessage;

/**
 * @group unit
 */
class UserBalanceMessageTest extends \PHPUnit_Framework_TestCase
{
    protected $request = array (
        'virtual_currency_balance' =>
            array (
                'old_value' => '0',
                'new_value' => '200',
                'diff' => '200',
            ),
        'user' =>
            array (
                'name' => 'Xsolla User',
                'id' => '1234567',
                'email' => 'support@xsolla.com',
            ),
        'transaction' =>
            array (
                'id' => '123456789',
                'date' => '2015-05-19T15:54:40+03:00',
            ),
        'operation_type' => 'payment',
        'notification_type' => 'user_balance_operation',
        'id_operation' => '66989',
        'coupon' => array(
            'coupon_code' => 'test123',
            'campaign_code' => 'Xsolla Campaign',
        ),
        'items_operation_type' => 'add',
    );

    public function test()
    {
        $message = new UserBalanceMessage($this->request);
        static::assertEquals($this->request['operation_type'], $message->getOperationType());
        static::assertEquals($this->request['id_operation'], $message->getOperationId());
        static::assertEquals($this->request['coupon'], $message->getCoupon());
        static::assertEquals($this->request['virtual_currency_balance'], $message->getVirtualCurrencyBalance());
        static::assertEquals($this->request['items_operation_type'], $message->getItemsOperationType());
    }

    public function testEmptyFields()
    {
        $requestCopy = $this->request;
        unset(
            $requestCopy['virtual_currency_balance'],
            $requestCopy['coupon'],
            $requestCopy['items_operation_type']
        );
        $message = new UserBalanceMessage($requestCopy);
        static::assertEquals(array(), $message->getCoupon());
        static::assertEquals(array(), $message->getVirtualCurrencyBalance());
        static::assertNull($message->getItemsOperationType());
    }
}