<?php

namespace Xsolla\SDK\Protocol;

use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\Command\StandardCommand;
use Xsolla\SDK\Protocol\CommandFactory\StandardFactory;
use Xsolla\SDK\Storage\PaymentsStandardInterface;
use Xsolla\SDK\Storage\UsersInterface;
use Xsolla\SDK\Validator\IpChecker;

class Standard extends Protocol
{
    /**
     * @var array
     */
    protected $protocolCommands = array('check', 'pay', 'cancel');

    /**
     * @var UsersInterface
     */
    protected $users;

    /**
     * @var PaymentsStandardInterface
     */
    protected $paymentsStandard;

    public function __construct(
        Project $project,
        XmlResponseBuilder $xmlResponseBuilder,
        StandardFactory $commandFactory,
        UsersInterface $users,
        PaymentsStandardInterface $paymentsStandard,
        IpChecker $ipChecker = null
    )
    {
        parent::__construct($project, $xmlResponseBuilder, $ipChecker);
        $this->commandFactory = $commandFactory;
        $this->users = $users;
        $this->paymentsStandard = $paymentsStandard;
    }

    /**
     * @return array
     */
    public function getProtocolCommands()
    {
        return array('check', 'pay', 'cancel');
    }

    /**
     * @return \Xsolla\SDK\Storage\PaymentsStandardInterface
     */
    public function getPaymentsStandard()
    {
        return $this->paymentsStandard;
    }

    /**
     * @return \Xsolla\SDK\Storage\UsersInterface
     */
    public function getUsers()
    {
        return $this->users;
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
