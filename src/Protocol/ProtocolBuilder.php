<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Protocol\CommandFactory\CashFactory;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Storage\PaymentsCashInterface;
use Xsolla\SDK\Storage\PaymentsStandardInterface;
use Xsolla\SDK\Storage\UsersInterface;

class ProtocolBuilder
{
    protected $project;
    protected $ipChecker = null;
    protected $enableVersionHeader = true;

    public function __construct($project, $ipChecker = null)
    {
        $this->project = $project;
        $this->ipChecker = $ipChecker;
    }

    public function getCashProtocol(PaymentsCashInterface $paymentStorage)
    {
        return new Cash(
            $this->project,
            new XmlResponseBuilder($this->enableVersionHeader),
            new CashFactory(),
            $paymentStorage,
            $this->ipChecker
        );
    }

    public function getStandardProtocol(UsersInterface $userStorage, PaymentsStandardInterface $paymentStorage)
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
