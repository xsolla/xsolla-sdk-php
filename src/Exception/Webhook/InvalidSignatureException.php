<?php

namespace Xsolla\SDK\Exception\Webhook;

class InvalidSignatureException extends ClientErrorException
{
    public function getXsollaErrorCode()
    {
        return 'INVALID_SIGNATURE';
    }

    public function getHttpStatusCode()
    {
        return 401;
    }
}
