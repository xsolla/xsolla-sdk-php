<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\CommandFactory\CashFactory;
use Xsolla\SDK\Protocol\Command\PayCash;
use Xsolla\SDK\Protocol\Storage\PaymentCashStorageInterface;
use Xsolla\SDK\Validator\IpChecker;

class Cash extends Protocol
{
    /**
     * @var PaymentCashStorageInterface
     */
    protected $paymentCashStorage;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        CashFactory $commandFactory,
        PaymentCashStorageInterface $paymentCashStorage,
        IpChecker $ipChecker = null
    ) {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->paymentCashStorage = $paymentCashStorage;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('pay', 'cancel');
    }

    /**
     * @return PaymentCashStorageInterface
     */
    public function getPaymentCashStorage()
    {
        return $this->paymentCashStorage;
    }

    /**
     * @param $message
     * @return array
     */
    public function getResponseForWrongCommand($message)
    {
        return array(
            'result' => PayCash::CODE_INVALID_REQUEST,
            PayCash::COMMENT_FIELD_NAME => $message
        );
    }

    /**
     * @param $message
     * @return array
     */
    public function getResponseForInternalServerError($message)
    {
        return array(
            'result' => PayCash::CODE_TEMPORARY_ERROR,
            PayCash::COMMENT_FIELD_NAME => $message
        );
    }
}
