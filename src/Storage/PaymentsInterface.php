<?php

namespace Xsolla\SDK\Storage;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\InvoiceNotBeRollbackException;

interface PaymentsInterface
{
    /**
     * @throws InvoiceNotFoundException
     * @throws InvoiceNotBeRollbackException
     */
    public function cancel($invoiceId);
}
