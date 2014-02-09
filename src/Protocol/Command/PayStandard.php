<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Storage\PaymentsStandardInterface;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\UsersInterface;

class PayStandard extends Command
{
    /**
     * @var PaymentsInterface
     */
    protected $payments;

    /**
     * @var UsersInterface
     */
    protected $users;

    public function __construct(Project $project, UsersInterface $users, PaymentsStandardInterface $payments)
    {
        $this->users = $users;
        $this->project = $project;
        $this->payments = $payments;
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id', 'sum', 'v1');
    }

    public function process(Request $request)
    {
        if (!$this->users->check($request->query->get('v1'), $request->query->get('v2'), $request->query->get('v3'))) {
            return array(
                'result' => '2',
                'comment' => 'Invalid user’s ID'
            );
        }

        $id = $this->payments->pay(
            $request->query->get('id'),
            $request->query->get('sum'),
            $request->query->get('v1'),
            $request->query->get('v2'),
            $request->query->get('v3')
        );

        return array('result' => 0, 'comment' => '', 'id' => $request->query->get('id'), 'id_shop' => $id);
    }

    public function checkSign(Request $request)
    {
        return ($this->generateSign($request, array('command', 'v1', 'id')) == $request->query->get('md5'));
    }
}
