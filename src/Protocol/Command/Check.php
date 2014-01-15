<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\Storage\UsersInterface;

class CheckNickname extends Command
{

    /**
     * @var UsersInterface
     */
    protected $users;
    /**
     * @var ProjectInterface
     */
    protected $project;

    function __construct(ProjectInterface $project, UsersInterface $users)
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

    protected function checkSign(Request $request)
    {
        // TODO: Implement checkSign() method.
    }
}