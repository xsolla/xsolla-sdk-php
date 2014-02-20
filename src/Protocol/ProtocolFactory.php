<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Protocol\CommandFactory\ShoppingCartFactory;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface;
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

    public function getShoppingCartProtocol(PaymentShoppingCartStorageInterface $paymentStorage)
    {
        return new ShoppingCart(
            $this->project,
            new XmlResponseBuilder($this->enableVersionHeader),
            new ShoppingCartFactory(),
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
