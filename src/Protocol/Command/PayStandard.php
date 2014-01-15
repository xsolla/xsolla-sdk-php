<?php

namespace Xsolla\SDK\Protocol;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Command\Command;
use Xsolla\SDK\Security;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Storage\ProjectInterface;

class PayStandard extends Command
{
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @var PaymentsInterface
     */
    protected $payments;

    function __construct(ProjectInterface $project, PaymentsInterface $payments)
    {
        $this->project = $project;
        $this->payments = $payments;
    }

    public function process(Request $request)
    {
        $this->payments->pay();
    }

    public function checkSign(Request $request)
    {

    }
}