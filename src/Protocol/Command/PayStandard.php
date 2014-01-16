<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
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
        $signString = $request->get('command').$request->get('v1').$request->get('id').$this->project->getSecretKey();
        return (md5($signString) == $request->get('md5'));
    }
}