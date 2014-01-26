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
        if (!$this->users->check($request->get('v1'), $request->get('v2'), $request->get('v3'))) {
            return array(
                'result' => '2',
                'comment' => 'Invalid user’s ID'
            );
        }

        $id = $this->payments->pay(
            $request->get('id'),
            $request->get('sum'),
            $request->get('v1'),
            $request->get('v2'),
            $request->get('v3')
        );

        return array('result' => 0, 'comment' => '', 'id' => $request->get('id'), 'id_shop' => $id);
    }

    public function checkSign(Request $request)
    {
        return ($this->generateSign($request, array('command', 'v1', 'id')) == $request->get('md5'));
    }
}
