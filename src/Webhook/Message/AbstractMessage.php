<?php

namespace Xsolla\SDK\Webhook\Message;

use Xsolla\SDK\Exception\Webhook\InvalidParameterException;
use Xsolla\SDK\Webhook\Message\NotificationTypeDictionary;

abstract class AbstractMessage
{
    protected static $classMap = [
        NotificationTypeDictionary::USER_VALIDATION => '\Xsolla\SDK\Webhook\Message\UserValidationMessage',
        NotificationTypeDictionary::USER_SEARCH => '\Xsolla\SDK\Webhook\Message\UserSearchMessage',
        NotificationTypeDictionary::PAYMENT => '\Xsolla\SDK\Webhook\Message\PaymentMessage',
        NotificationTypeDictionary::REFUND => '\Xsolla\SDK\Webhook\Message\RefundMessage',
        NotificationTypeDictionary::PARTIAL_REFUND => '\Xsolla\SDK\Webhook\Message\PartialRefundMessage',
        NotificationTypeDictionary::CREATE_SUBSCRIPTION => '\Xsolla\SDK\Webhook\Message\CreateSubscriptionMessage',
        NotificationTypeDictionary::CANCEL_SUBSCRIPTION => '\Xsolla\SDK\Webhook\Message\CancelSubscriptionMessage',
        NotificationTypeDictionary::UPDATE_SUBSCRIPTION => '\Xsolla\SDK\Webhook\Message\UpdateSubscriptionMessage',
        NotificationTypeDictionary::USER_BALANCE => '\Xsolla\SDK\Webhook\Message\UserBalanceMessage',
        NotificationTypeDictionary::GET_PIN_CODE => '\Xsolla\SDK\Webhook\Message\GetPinCodeMessage',
        NotificationTypeDictionary::AFS_REJECT => '\Xsolla\SDK\Webhook\Message\AfsRejectMessage',
        NotificationTypeDictionary::ORDER_PAID => '\Xsolla\SDK\Webhook\Message\OrderPaidMessage',
        NotificationTypeDictionary::ORDER_CANCELED => '\Xsolla\SDK\Webhook\Message\OrderCanceledMessage',
        NotificationTypeDictionary::PAYMENT_ACCOUNT_ADD => '\Xsolla\SDK\Webhook\Message\PaymentAccountAddMessage',
        NotificationTypeDictionary::PAYMENT_ACCOUNT_REMOVE => '\Xsolla\SDK\Webhook\Message\PaymentAccountRemoveMessage',
        NotificationTypeDictionary::PARTNER_SIDE_CATALOG => '\Xsolla\SDK\Webhook\Message\PartnerSideCatalogMessage',
        NotificationTypeDictionary::REDEEM_KEY => '\Xsolla\SDK\Webhook\Message\RedeemKeyMessage',
    ];

    /**
     * @var array
     */
    protected $request;

    /**
     * @return AbstractMessage
     *@throws InvalidParameterException
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

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
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
        return NotificationTypeDictionary::USER_VALIDATION === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isPayment()
    {
        return NotificationTypeDictionary::PAYMENT === $this->getNotificationType();
    }

    /**
     * @return bool
     */
    public function isRefund()
    {
        return NotificationTypeDictionary::REFUND === $this->getNotificationType();
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
