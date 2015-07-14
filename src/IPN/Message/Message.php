<?php

namespace Xsolla\SDK\IPN\Message;

use Symfony\Component\HttpFoundation\ParameterBag;
use Xsolla\SDK\Exception\IPN\InvalidParameterException;

class Message
{
    const IPN_USER_VALIDATION = 'user_validation';
    const IPN_PAYMENT = 'payment';
    const IPN_REFUND = 'refund';
    const IPN_CREATE_SUBSCRIPTION = 'create_subscription';
    const IPN_CANCEL_SUBSCRIPTION = 'cancel_subscription';
    const IPN_USER_BALANCE = 'user_balance_operation';

    protected static $classMap = array(
        self::IPN_USER_VALIDATION => '\Xsolla\SDK\IPN\Message\UserValidationMessage',
        self::IPN_PAYMENT => '\Xsolla\SDK\IPN\Message\PaymentMessage',
        self::IPN_REFUND => '\Xsolla\SDK\IPN\Message\RefundMessage',
        self::IPN_CREATE_SUBSCRIPTION => '\Xsolla\SDK\IPN\Message\CreateSubscriptionMessage',
        self::IPN_CANCEL_SUBSCRIPTION => '\Xsolla\SDK\IPN\Message\CancelSubscriptionMessage',
        self::IPN_USER_BALANCE => '\Xsolla\SDK\IPN\Message\UserBalanceMessage',
    );

    protected $parameterBag;

    public static function fromRequest(ParameterBag $parameterBag)
    {
        $notificationType = $parameterBag->get('notification_type');
        if (!array_key_exists($notificationType, self::$classMap)) {
            throw new InvalidParameterException();
        }
        $className = self::$classMap[$notificationType];
        return new $className($parameterBag);
    }

    public function __construct(ParameterBag $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function toParameterBag()
    {
        return $this->parameterBag;
    }

    public function toArray()
    {
        return $this->parameterBag->all();
    }

    public function getNotificationType()
    {
        return $this->parameterBag->get('notification_type');
    }

    public function isUserValidation()
    {
        return self::IPN_USER_VALIDATION === $this->getNotificationType();
    }

    public function isPayment()
    {
        return self::IPN_PAYMENT === $this->getNotificationType();
    }

    public function isRefund()
    {
        return self::IPN_REFUND === $this->getNotificationType();
    }

    public function getUser()
    {
        return $this->parameterBag->get('user', array());
    }

    public function getUserId()
    {
        return $this->parameterBag->get('user[id]');
    }
}