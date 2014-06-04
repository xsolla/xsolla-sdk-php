<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Protocol\Protocol;
use Xsolla\SDK\Protocol\Storage\PaymentStorageInterface;

class Cancel extends StandardCommand
{
    protected $paymentStorage;

    public function __construct(Protocol $protocol, PaymentStorageInterface $paymentStorage)
    {
        $this->project = $protocol->getProject();
        $this->paymentStorage = $paymentStorage;
    }

    public function process(Request $request)
    {
        try {
            $this->paymentStorage->cancel(
                $request->query->get('id'),
                $request->query->get('reason_code'),
                $request->query->get('reason')
            );

            return array(
                'result' => self::CODE_SUCCESS,
                self::COMMENT_FIELD_NAME => '',
            );
        } catch (InvoiceNotFoundException $e) {
            return array(
                'result' => self::CODE_INVALID_ORDER_DETAILS,
                self::COMMENT_FIELD_NAME => trim('Invoice not found. ' . $e->getMessage()),
            );
        }
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'id')) == $request->query->get('md5');
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id');
    }

}
