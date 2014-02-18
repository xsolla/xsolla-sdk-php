<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\CommandFactory\CashFactory;
use Xsolla\SDK\Protocol\Command\PayCash;
use Xsolla\SDK\Protocol\Storage\PaymentsCashInterface;
use Xsolla\SDK\Validator\IpChecker;

class Cash extends Protocol
{
    /**
     * @var PaymentsCashInterface
     */
    protected $paymentsCash;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        CashFactory $commandFactory,
        PaymentsCashInterface $paymentsCash,
        IpChecker $ipChecker = null
    ) {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->paymentsCash = $paymentsCash;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('pay', 'cancel');
    }

    /**
     * @return PaymentsCashInterface
     */
    public function getPaymentsCash()
    {
        return $this->paymentsCash;
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
