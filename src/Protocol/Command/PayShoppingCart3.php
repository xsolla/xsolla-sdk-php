<?php
namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\ShoppingCart3;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;

class PayShoppingCart3 extends StandardCommand
{
    /**
     * @var PaymentShoppingCart3StorageInterface
     */
    protected $paymentStorage;

    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    public function __construct(ShoppingCart3 $protocol)
    {
        $this->userStorage = $protocol->getUserStorage();
        $this->project = $protocol->getProject();
        $this->paymentStorage = $protocol->getPaymentShoppingCart3Storage();
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'v1', 'foreignInvoice', 'id')) === $request->query->get('md5');
    }

    public function process(Request $request)
    {
        $user = $this->createUser($request);
        if (!$this->userStorage->isUserExists($user)) {
            return array(
                'result' => self::CODE_INVALID_ORDER_DETAILS,
                self::COMMENT_FIELD_NAME => 'User not found'
            );
        }
        $datetime = $this->getDateTimeXsolla('Y-m-d H:i:s', $request->query->get('date'));
        $id = $this->paymentStorage->pay(
            $request->query->get('id'),
            $request->query->get('payment_amount'),
            $request->query->get('payment_currency'),
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

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id', 'v1', 'date', 'payment_amount', 'payment_currency');
    }
}