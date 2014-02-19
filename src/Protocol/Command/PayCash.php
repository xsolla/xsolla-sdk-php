<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvalidRequestException;
use Xsolla\SDK\Protocol\Cash;
use Xsolla\SDK\Protocol\Storage\PaymentCashStorageInterface;

class PayCash extends Command
{
    const CODE_FATAL_ERROR = 40;
    const CODE_TEMPORARY_ERROR = 30;
    const CODE_INVALID_REQUEST = 20;

    const COMMENT_FIELD_NAME = 'description';

    /**
     * @var PaymentCashStorageInterface
     */
    protected $paymentStorage;

    public function __construct(Cash $protocol)
    {
        $this->project = $protocol->getProject();
        $this->paymentStorage = $protocol->getPaymentCashStorage();
    }

    public function getRequiredParams()
    {
        return array('command', 'sign', 'id', 'v1', 'amount', 'currency', 'datetime');
    }

    public function process(Request $request)
    {
        $datetime = $this->getDateTimeXsolla($request->query->get('datetime'));
        $this->paymentStorage->pay(
            $request->query->get('id'),
            $request->query->get('amount'),
            $request->query->get('v1'),
            $this->emptyStringToNull($request->query->get('v2')),
            $this->emptyStringToNull($request->query->get('v3')),
            $request->query->get('currency'),
            $datetime,
            (bool) $request->query->get('dry_run'),
            $request->query->get('userAmount'),
            $request->query->get('userCurrency'),
            $request->query->get('transferAmount'),
            $request->query->get('transferCurrency'),
            $request->query->get('pid'),
            $request->query->get('geotype')
        );

        return array('result' => self::CODE_SUCCESS, self::COMMENT_FIELD_NAME => '');
    }

    public function emptyStringToNull($string)
    {
        $trimmedString = trim($string);
        return $trimmedString == '' ? null : $trimmedString;
    }

    public function checkSign(Request $request)
    {
        $actualSign = $this->generateSign($request, array('v1', 'amount', 'currency', 'id'));

        return $actualSign == $request->query->get('sign');
    }

    protected function getDateTimeXsolla($datetime)
    {
        $xsollaTimeZone = new \DateTimeZone('Europe/Moscow');
        $datetimeObj = \DateTime::createFromFormat('YmdHis', $datetime, $xsollaTimeZone);
        if (!$datetimeObj) {
            throw new InvalidRequestException(sprintf('Datetime string %s could not be converted to DateTime object from format \'YmdHis\'', $datetime));
        }
        $datetimeObj->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $datetimeObj;
    }

    public function getCommentFieldName()
    {
        return self::COMMENT_FIELD_NAME;
    }

    public function getInvalidSignResponseCode()
    {
        return self::CODE_INVALID_REQUEST;
    }

    public function getInvalidRequestResponseCode()
    {
        return self::CODE_INVALID_REQUEST;
    }

    public function getUnprocessableRequestResponseCode()
    {
        return self::CODE_FATAL_ERROR;
    }

    public function getTemporaryServerErrorResponseCode()
    {
        return self::CODE_TEMPORARY_ERROR;
    }
}
