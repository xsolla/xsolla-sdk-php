<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentStorageInterface
{
    /**
     * @param int $xsollaPaymentId If this xsollaPaymentId is already canceled you MUST NOT thrown error or exception
     * @throws InvoiceNotFoundException
     * @throws UnprocessableRequestException
     */
    public function cancel($xsollaPaymentId);
}
