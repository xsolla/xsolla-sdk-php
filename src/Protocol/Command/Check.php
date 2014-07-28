<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;

class Check extends StandardCommand
{
    const CODE_USER_NOT_FOUND = 7;

    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    public function __construct(Standard $protocol)
    {
        $this->userStorage = $protocol->getUserStorage();
        $this->project = $protocol->getProject();
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        $hasUser = $this->userStorage->isUserExists($user);
        if ($hasUser) {
            $response = array('result' => self::CODE_SUCCESS);
            $spec = $this->userStorage->getAdditionalUserFields($user);
            if (count($spec) > 0) {
                $response['specification'] = $spec;
            }
        } else {
            $response = array('result' => self::CODE_USER_NOT_FOUND);
        }
        $response['comment'] = '';

        return $response;
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'v1')) === $request->query->get('md5');
    }

    public function getRequiredParams()
    {
        return array('command', 'v1', 'md5');
    }
}
