<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Command\Factory;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\UsersInterface;

abstract class Protocol
{
    const PROTOCOL = '';
    protected $response;
    /**
     * @var \Xsolla\SDK\Project
     */
    protected $project;
    /**
     * @var UsersInterface
     */
    protected $users;
    /**
     * @var PaymentsInterface
     */
    protected $payments;
    /**
     * @var IpChecker
     */
    protected $ipChecker;
    /**
     * @var Factory
     */
    protected $commandFactory;

    public function __construct(IpChecker $ipChecker, Factory $factory, Project $project, UsersInterface $users, PaymentsInterface $payments)
    {
        $this->ipChecker = $ipChecker;
        $this->commandFactory = $factory;
        $this->project = $project;
        $this->users = $users;
        $this->payments = $payments;
    }

    /**
     * @return \Xsolla\SDK\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return PaymentsInterface
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @return UsersInterface
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return static::PROTOCOL;
    }

    /**
     * @param  Request $request
     * @return array
     */
    public function getResponse(Request $request)
    {
        $this->ipChecker->checkIp($request->getClientIp());

        return $this->process($request);
    }

    /**
     * @param  Request $request
     * @return array
     */
    protected function process(Request $request)
    {
        $command = $this->commandFactory->getCommand($this, $request->get('command'));

        return $command->getResponse($request);
    }
}
