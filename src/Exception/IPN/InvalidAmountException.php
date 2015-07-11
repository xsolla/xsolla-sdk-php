<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidAmountException extends XsollaIPNException
{
    public function getXsollaErrorCode()
    {
        return 'INCORRECT_AMOUNT';
    }

    public function getHttpStatusCode()
    {
        return 422;
    }
}