<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Command\Factory;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\UsersInterface;

class Protocol
{
    const PROTOCOL_STANDARD = 'Standard';
    const PROTOCOL_CASH = 'Cash';

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

    public function __construct(Factory $factory, Project $project, UsersInterface $users, PaymentsInterface $payments, IpChecker $ipChecker = null)
    {
        $this->commandFactory = $factory;
        $this->project = $project;
        $this->users = $users;
        $this->payments = $payments;
        $this->ipChecker = $ipChecker;
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
     * @param  Request $request
     * @return array
     */
    public function getResponse(Request $request)
    {
        if ($this->ipChecker) {
            $this->ipChecker->checkIp($request->getClientIp());
        }

        return $this->process($request);
    }

    /**
     * @param  Request $request
     * @return array
     */
    protected function process(Request $request)
    {
        $command = $this->commandFactory->getCommand($this, $request->query->get('command'));

        return $command->getResponse($request);
    }
}
