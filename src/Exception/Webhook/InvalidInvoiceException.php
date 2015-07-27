<?php

namespace Xsolla\SDK\Exception\Webhook;

class InvalidInvoiceException extends ClientErrorException
{
    public function getXsollaErrorCode()
    {
        return 'INCORRECT_INVOICE';
    }

    public function getHttpStatusCode()
    {
        return 422;
    }
}
