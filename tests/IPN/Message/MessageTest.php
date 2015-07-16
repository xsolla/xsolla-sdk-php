<?php

namespace Xsolla\SDK\Tests\IPN\Message;

use Xsolla\SDK\IPN\Message;

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
        static::assertEquals($userId, $message->getUserId());
        static::assertEquals($user, $message->getUser());
        static::assertEquals($request, $message->toArray());
        static::assertEquals($notificationType, $message->getNotificationType());
        static::assertEquals($isUserValidation, $message->isUserValidation());
        static::assertEquals($isPayment, $message->isPayment());
        static::assertEquals($isRefund, $message->isRefund());
    }

    public function factoryProvider()
    {
        return array(
            array(
                'notificationType' => 'user_validation',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\UserValidationMessage',
                'isUserValidation' => true,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'payment',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\PaymentMessage',
                'isUserValidation' => false,
                'isPayment' => true,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'refund',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\RefundMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => true,
            ),
            array(
                'notificationType' => 'create_subscription',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\CreateSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'cancel_subscription',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\CancelSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
            array(
                'notificationType' => 'user_balance_operation',
                'expectedClass' => '\Xsolla\SDK\IPN\Message\UserBalanceMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ),
        );
    }

    public function testPayment(array $customParameters, $dryRun)
    {
        $request = array(
            'purchase' => '',
            'transaction' => array(
                'dry_run' => $dryRun,
            ),
            'payment_details' => '',
            'custom_parameters' => $customParameters,
        );

    }

    public function testRefund()
    {

    }

    public function testCreateSubscription()
    {

    }

    public function testCancelSubscription()
    {

    }

    public function testUserBalance()
    {

    }
}