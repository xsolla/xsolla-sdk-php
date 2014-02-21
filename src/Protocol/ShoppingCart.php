<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\CommandFactory\ShoppingCartFactory;
use Xsolla\SDK\Protocol\Command\PayShoppingCart;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface;
use Xsolla\SDK\Validator\IpChecker;

class ShoppingCart extends Protocol
{
    /**
     * @var PaymentShoppingCartStorageInterface
     */
    protected $paymentShoppingCartStorage;

    protected $unprocessableRequestResponseCode = PayShoppingCart::CODE_FATAL_ERROR;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        ShoppingCartFactory $commandFactory,
        PaymentShoppingCartStorageInterface $paymentShoppingCartStorage,
        IpChecker $ipChecker = null
    ) {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->paymentShoppingCartStorage = $paymentShoppingCartStorage;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('pay', 'cancel');
    }

    /**
     * @return PaymentShoppingCartStorageInterface
     */
    public function getPaymentShoppingCartStorage()
    {
        return $this->paymentShoppingCartStorage;
    }

    /**
     * @param $message
     * @return array
     */
    public function getResponseForWrongCommand($message)
    {
        return array(
            'result' => PayShoppingCart::CODE_INVALID_REQUEST,
            PayShoppingCart::COMMENT_FIELD_NAME => $message
        );
    }
}
