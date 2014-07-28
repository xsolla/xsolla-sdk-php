<?php
namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\Command\StandardCommand;
use Xsolla\SDK\Protocol\CommandFactory\ShoppingCart3Factory;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\Validator\IpChecker;

class ShoppingCart3 extends Protocol
{

    /**
     * @var array
     */
    protected $protocolCommands = array('check', 'pay', 'cancel');

    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    /**
     * @var PaymentShoppingCart3StorageInterface
     */
    protected $paymentShoppingCart3Storage;

    protected $unprocessableRequestResponseCode = StandardCommand::CODE_FATAL_ERROR;

    protected $commentFieldName = StandardCommand::COMMENT_FIELD_NAME;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        ShoppingCart3Factory $commandFactory,
        UserStorageInterface $userStorage,
        PaymentShoppingCart3StorageInterface $paymentShoppingCart3Storage,
        IpChecker $ipChecker = null
    )
    {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->userStorage = $userStorage;
        $this->paymentShoppingCart3Storage = $paymentShoppingCart3Storage;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('check', 'pay', 'cancel');
    }

    /**
     * @return \Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface
     */
    public function getPaymentShoppingCart3Storage()
    {
        return $this->paymentShoppingCart3Storage;
    }

    /**
     * @return \Xsolla\SDK\Protocol\Storage\UserStorageInterface
     */
    public function getUserStorage()
    {
        return $this->userStorage;
    }

    /**
     * @param $message
     * @return array
     */
    public function getResponseForWrongCommand($message)
    {
        return array(
            'result' => StandardCommand::CODE_INVALID_REQUEST,
            StandardCommand::COMMENT_FIELD_NAME => $message
        );
    }
}