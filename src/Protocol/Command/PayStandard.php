<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Storage\UsersInterface;

class PayStandard extends StandardCommand
{
    /**
     * @var PaymentsInterface
     */
    protected $payments;

    /**
     * @var UsersInterface
     */
    protected $users;

    public function __construct(Standard $protocol)
    {
        $this->users = $protocol->getUsers();
        $this->project = $protocol->getProject();
        $this->payments = $protocol->getPaymentsStandard();
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id', 'sum', 'v1');
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        if (!$this->users->check($user)) {
            return array(
                'result' => self::CODE_INVALID_ORDER_DETAILS,
                self::COMMENT_FIELD_NAME => 'User not found'
            );
        }
        $id = $this->payments->pay(
            $request->query->get('id'),
            $request->query->get('sum'),
            $user,
            (bool) $request->query->get('dry_run')
        );

        return array(
            'result' => self::CODE_SUCCESS,
            self::COMMENT_FIELD_NAME => '',
            'id_shop' => $id
        );
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'v1', 'id')) == $request->query->get('md5');
    }
}
