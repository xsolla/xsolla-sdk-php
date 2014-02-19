<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Protocol\Storage\PaymentStorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;

class PayStandard extends StandardCommand
{
    /**
     * @var PaymentStorageInterface
     */
    protected $paymentStorage;

    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    public function __construct(Standard $protocol)
    {
        $this->userStorage = $protocol->getUserStorage();
        $this->project = $protocol->getProject();
        $this->paymentStorage = $protocol->getPaymentStandardStorage();
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id', 'sum', 'v1', 'date');
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        if (!$this->userStorage->check($user)) {
            return array(
                'result' => self::CODE_INVALID_ORDER_DETAILS,
                self::COMMENT_FIELD_NAME => 'User not found'
            );
        }
        $datetime = $this->getDateTimeXsolla('Y-m-d H:i:s', $request->query->get('date'));
        $id = $this->paymentStorage->pay(
            $request->query->get('id'),
            $request->query->get('sum'),
            $user,
            $datetime,
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
