<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Protocol\CommandFactory\ShoppingCart3Factory;
use Xsolla\SDK\Protocol\CommandFactory\ShoppingCartFactory;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface;
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

    /**
     * @param PaymentShoppingCartStorageInterface $paymentStorage
     * @return ShoppingCart
     * @see http://xsolla.github.io/en/cash.html
     */
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

    /**
     * @param UserStorageInterface $userStorage
     * @param PaymentStandardStorageInterface $paymentStorage
     * @return Standard
     * @see http://xsolla.github.io/en/currency.html
     */
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

    /**
     * @param UserStorageInterface $userStorage
     * @param PaymentShoppingCart3StorageInterface $paymentStorage
     * @return ShoppingCart3
     * @see http://xsolla.github.io/en/shopingcart3.html
     */
    public function getShoppingCart3Protocol(UserStorageInterface $userStorage, PaymentShoppingCart3StorageInterface $paymentStorage)
    {
        return new ShoppingCart3(
            $this->project,
            new XmlResponseBuilder($this->enableVersionHeader),
            new ShoppingCart3Factory(),
            $userStorage,
            $paymentStorage,
            $this->ipChecker
        );
    }
}
