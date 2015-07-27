<?php

namespace Xsolla\SDK\Exception\Webhook;

class InvalidAmountException extends ClientErrorException
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
