<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentStorageInterface
{
    /**
     * @param int $xsollaPaymentId
     * @throws InvoiceNotFoundException
     * @throws UnprocessableRequestException
     */
    public function cancel($xsollaPaymentId);
}
