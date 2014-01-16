<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Storage\ProjectInterface;

class PayCash extends Command
{

    /**
     * @var PaymentsInterface
     */
    protected $users;
    /**
     * @var ProjectInterface
     */
    protected $project;

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
        $signString = $request->get('v1').$request->get('amount').$request->get('currency').$request->get('id').$this->project->getSecretKey();
        return (md5($signString) == $request->get('sign'));
    }
}