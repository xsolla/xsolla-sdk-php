<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Protocol\CommandFactory\CashFactory;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Protocol\Storage\PaymentCashStorageInterface;
use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;

class ProtocolFactory
{
    protected $project;
    protected $ipChecker = null;
    protected $enableVersionHeader = true;

    public function __construct($project, $ipChecker = null)
    {
        $this->project = $project;
        $this->ipChecker = $ipChecker;
    }

    public function getCashProtocol(PaymentCashStorageInterface $paymentStorage)
    {
        return new Cash(
            $this->project,
            new XmlResponseBuilder($this->enableVersionHeader),
            new CashFactory(),
            $paymentStorage,
            $this->ipChecker
        );
    }

    public function getStandardProtocol(UserStorageInterface $userStorage, PaymentStandardStorageInterface $paymentStorage)
    {
        return new Standard(
            $this->project,
            new XmlResponseBuilder($this->enableVersionHeader),
            new StandardFactory(),
            $userStorage,
            $paymentStorage,
            $this->ipChecker
        );
    }
}
