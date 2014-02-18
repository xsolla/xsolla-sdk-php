<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Protocol\Storage\UsersInterface;

class Check extends StandardCommand
{
    const CODE_USER_NOT_FOUND = 7;

    /**
     * @var UsersInterface
     */
    protected $users;

    public function __construct(Standard $protocol)
    {
        $this->users = $protocol->getUsers();
        $this->project = $protocol->getProject();
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        $hasUser = $this->users->check($user);
        if ($hasUser) {
            $code = self::CODE_SUCCESS;
        } else {
            $code = self::CODE_USER_NOT_FOUND;
        }

        return array('result' => $code, self::COMMENT_FIELD_NAME => '');
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'v1')) == $request->query->get('md5');
    }

    public function getRequiredParams()
    {
        return array('command', 'v1', 'md5');
    }
}
