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

    /**
     * @var ParameterBag
     */
    protected $parameterBag;

    /**
     * @param ParameterBag $parameterBag
     * @return Message
     * @throws InvalidParameterException
     */
    public static function fromRequest(ParameterBag $parameterBag)
    {
        $notificationType = $parameterBag->get('notification_type');
        if (!array_key_exists($notificationType, self::$classMap)) {
            throw new InvalidParameterException();
        }
        $className = self::$classMap[$notificationType];
        return new $className($parameterBag);
    }

    /**
     * @param ParameterBag $parameterBag
     */
    public function __construct(ParameterBag $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return ParameterBag
     */
    public function toParameterBag()
    {
        return $this->parameterBag;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->parameterBag->all();
    }

    /**
     * @return string
     */
    public function getNotificationType()
    {
        return $this->parameterBag->get('notification_type');
    }

    /**
     * @return bool
     */
    public function isUserValidation()
    {
        return self::IPN_USER_VALIDATION === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isPayment()
    {
        return self::IPN_PAYMENT === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isRefund()
    {
        return self::IPN_REFUND === $this->getNotificationType();
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->parameterBag->get('user', array());
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->parameterBag->get('user[id]');
    }
}