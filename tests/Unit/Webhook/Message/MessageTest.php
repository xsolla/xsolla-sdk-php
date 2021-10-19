<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message;

/**
 * @group unit
 */
class MessageTest extends TestCase
{
    /**
     * @dataProvider factoryProvider
     */
    public function testFactory($notificationType, $expectedClass, $isUserValidation, $isPayment, $isRefund)
    {
        $userId = 'USER_ID';
        $user = ['id' => 'USER_ID'];
        $request = ['notification_type' => $notificationType, 'user' => $user];
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
        return [
            [
                'notificationType' => 'user_validation',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserValidationMessage',
                'isUserValidation' => true,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'payment',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\PaymentMessage',
                'isUserValidation' => false,
                'isPayment' => true,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'refund',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\RefundMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => true,
            ],
            [
                'notificationType' => 'afs_reject',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\AfsRejectMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'create_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\CreateSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'cancel_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'update_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UpdateSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'non_renewal_subscription',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\NonRenewalSubscriptionMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'user_balance_operation',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserBalanceMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'get_pincode',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\GetPinCodeMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
            [
                'notificationType' => 'user_search',
                'expectedClass' => '\Xsolla\SDK\Webhook\Message\UserSearchMessage',
                'isUserValidation' => false,
                'isPayment' => false,
                'isRefund' => false,
            ],
        ];
    }
}
