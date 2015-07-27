<?php

namespace Xsolla\SDK\Exception\Webhook;

class InvalidParameterException extends ClientErrorException
{
    public function getXsollaErrorCode()
    {
        return 'INVALID_PARAMETER';
    }

    public function getHttpStatusCode()
    {
        return 422;
    }
}
