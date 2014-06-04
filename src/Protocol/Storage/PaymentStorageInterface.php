<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentStorageInterface
{
    /**
     * @param integer $xsollaPaymentId      If this xsollaPaymentId is already canceled you MUST NOT thrown error or exception
     * @param integer $reasonCode           Numeric cancellation code
     * @param integer $reasonDescription    Reason for payment cancellation
     * @throws InvoiceNotFoundException
     * @throws UnprocessableRequestException
     */
    public function cancel($xsollaPaymentId, $reasonCode = null, $reasonDescription = null);
}
