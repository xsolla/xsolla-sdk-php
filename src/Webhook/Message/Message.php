<?php

namespace Xsolla\SDK\Webhook\Message;

use Symfony\Component\HttpFoundation\ParameterBag;
use Xsolla\SDK\Exception\Webhook\InvalidParameterException;

abstract class Message
{
    const USER_VALIDATION = 'user_validation';
    const PAYMENT = 'payment';
    const REFUND = 'refund';
    const CREATE_SUBSCRIPTION = 'create_subscription';
    const CANCEL_SUBSCRIPTION = 'cancel_subscription';
    const USER_BALANCE = 'user_balance_operation';

    protected static $classMap = array(
        self::USER_VALIDATION => '\Xsolla\SDK\Webhook\Message\UserValidationMessage',
        self::PAYMENT => '\Xsolla\SDK\Webhook\Message\PaymentMessage',
        self::REFUND => '\Xsolla\SDK\Webhook\Message\RefundMessage',
        self::CREATE_SUBSCRIPTION => '\Xsolla\SDK\Webhook\Message\CreateSubscriptionMessage',
        self::CANCEL_SUBSCRIPTION => '\Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage',
        self::USER_BALANCE => '\Xsolla\SDK\Webhook\Message\UserBalanceMessage',
    );

    /**
     * @var array
     */
    protected $request;

    /**
     * @param array $request
     *
     * @return Message
     *
     * @throws InvalidParameterException
     */
    public static function fromArray(array $request)
    {
        if (!array_key_exists('notification_type', $request)) {
            throw new InvalidParameterException('notification_type key not found in Xsolla webhook request');
        }
        $notificationType = $request['notification_type'];
        if (!array_key_exists($notificationType, self::$classMap)) {
            throw new InvalidParameterException('Unknown notification_type in Xsolla webhook request: '.$notificationType);
        }
        $className = self::$classMap[$notificationType];

        return new $className($request);
    }

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * @return ParameterBag
     */
    public function toArray()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getNotificationType()
    {
        return $this->request['notification_type'];
    }

    /**
     * @return bool
     */
    public function isUserValidation()
    {
        return self::USER_VALIDATION === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isPayment()
    {
        return self::PAYMENT === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isRefund()
    {
        return self::REFUND === $this->getNotificationType();
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->request['user'];
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->request['user']['id'];
    }
}
