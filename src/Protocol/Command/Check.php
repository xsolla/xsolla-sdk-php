<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\UsersInterface;

class Check extends StandardCommand
{
    const CODE_SUCCESS = 0;
    const CODE_USER_NOT_FOUND = 7;

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
        try {
            $user = $this->createUser($request);
            $hasUser = $this->users->check($user);
            if ($hasUser) {
                $code = self::CODE_SUCCESS;
            } else {
                $code = self::CODE_USER_NOT_FOUND;
            }
            return array('result' => $code, 'comment' => '');
        } catch (\Exception $e) {
            return array(
                'result' => self::CODE_USER_NOT_FOUND,
                'comment' => $e->getMessage()
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
