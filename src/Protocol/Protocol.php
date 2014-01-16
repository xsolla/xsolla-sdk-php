<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\SecurityException;
use Xsolla\SDK\Protocol\Command\Factory;
use Xsolla\SDK\Security;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\Storage\UsersInterface;

abstract class Protocol
{
    const PROTOCOL = '';
    protected $response;
    /**
     * @var ProjectInterface
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
     * @var Security
     */
    protected $security;
    /**
     * @var Factory
     */
    protected $commandFactory;

    public function __construct(Security $security, Factory $factory, ProjectInterface $project, UsersInterface $users, PaymentsInterface $payments)
    {
        $this->security = $security;
        $this->commandFactory = $factory;
        $this->project = $project;
        $this->users = $users;
        $this->payments = $payments;
    }

    /**
     * @return ProjectInterface
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

    protected function checkSecurity(Request $request)
    {
        if (!$this->security->checkIp($request->getClientIp())) {
            throw new SecurityException('Wrong ip');
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getResponse(Request $request)
    {
        $this->checkSecurity($request);
        return $this->process($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function process(Request $request)
    {
        $command = $this->commandFactory->getCommand($this, $request->get('command'));
        return $command->getResponse($request);
    }
}