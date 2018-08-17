<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use Xsolla\SDK\Webhook\Message;

/**
 * @group unit
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider factoryProvider
     */
    public function testFactory($notificationType, $expectedClass, $isUserValidation, $isPayment, $isRefund)
    {
        $userId = 'USER_ID';
        $user = array('id' => 'USER_ID');
        $request = array('notification_type' => $notificationType, 'user' => $user);
        $message = Message\Message::fromArray($request);
        static::assertInstanceOf($expectedClass, $message);
        static::assertSame($userId, $message->getUserId());
        static::assertSame($user, $message->getUser());
        static::assertSame($request, $message->toArray());
        static::assertSame($notificationType, $message->getNotificationType());
        static::assertSame($isUserValidation, $message->isUserValidation());
        static::assertSame($isPayment, $message->isPayment());
        static::assertSame($isRefund, $message->isRefund());
    }

    public function factoryProvider()
    {
        return array(
            array(
                'notificationType' => 'user_validation',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserValidationMessage',
                'isUserValidation' => true,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'payment',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\PaymentMessage',
                'isUserValidation' => false,
                'isPayment' => true,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'refund',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\RefundMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => true,
            ),
            array(
                'notificationType' => 'create_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\CreateSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'cancel_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'update_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UpdateSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'user_balance_operation',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserBalanceMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'get_pincode',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\GetPinCodeMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'user_search',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserSearchMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
        );
    }
}
