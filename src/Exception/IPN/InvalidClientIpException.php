<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidClientIpException extends ClientErrorException
{
    public function getXsollaErrorCode()
    {
        return 'INVALID_CLIENT_IP';
    }

    public function getHttpStatusCode()
    {
        return 401;
    }
}