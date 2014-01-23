<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\Storage\UsersInterface;

class Check extends Command
{

    /**
     * @var UsersInterface
     */
    protected $users;

    public function __construct(ProjectInterface $project, UsersInterface $users)
    {
        $this->users = $users;
        $this->project = $project;
    }

    public function process(Request $request)
    {
        if ($this->users->check($request->get('v1'), $request->get('v2'), $request->get('v3'))) {
            return array(
                'result' => '0'
            );
        } else {
            return array(
                'result' => '7',
                'comment' => 'Account is disabled or not present'
            );
        }
    }

    public function checkSign(Request $request)
    {
        return ($this->generateSign($request, array('command', 'v1')) == $request->get('md5'));
    }

    public function getRequiredParams()
    {
        return array('command', 'v1', 'md5');
    }
}
