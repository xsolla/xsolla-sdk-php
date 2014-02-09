<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\UsersInterface;

class Check extends StandardCommand
{

    /**
     * @var UsersInterface
     */
    protected $users;

    public function __construct(Project $project, UsersInterface $users)
    {
        $this->users = $users;
        $this->project = $project;
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        if ($this->users->check($user)) {
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
        return ($this->generateSign($request, array('command', 'v1')) == $request->query->get('md5'));
    }

    public function getRequiredParams()
    {
        return array('command', 'v1', 'md5');
    }
}
