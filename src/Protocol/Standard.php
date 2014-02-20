<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\Command\StandardCommand;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\Validator\IpChecker;

class Standard extends Protocol
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
     * @var PaymentStandardStorageInterface
     */
    protected $paymentStandardStorage;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        StandardFactory $commandFactory,
        UserStorageInterface $userStorage,
        PaymentStandardStorageInterface $paymentStandardStorage,
        IpChecker $ipChecker = null
    )
    {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->userStorage = $userStorage;
        $this->paymentStandardStorage = $paymentStandardStorage;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('check', 'pay', 'cancel');
    }

    /**
     * @return \Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface
     */
    public function getPaymentStandardStorage()
    {
        return $this->paymentStandardStorage;
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

    /**
     * @param $message
     * @return array
     */
    public function getResponseForInternalServerError($message)
    {
        return array(
            'result' => StandardCommand::CODE_TEMPORARY_ERROR,
            StandardCommand::COMMENT_FIELD_NAME => $message
        );
    }
}
