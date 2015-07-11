<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidInvoiceException extends XsollaIPNException
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