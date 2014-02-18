<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentsInterface
{
    /**
     * @throws InvoiceNotFoundException
     * @throws UnprocessableRequestException
     */
    public function cancel($invoiceId);
}
