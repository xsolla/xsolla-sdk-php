<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidClientIpException extends XsollaIPNException
{
    public function getXsollaErrorCode()
    {
        return 'INVALID_CLIENT_IP';//TODO
    }

    public function getHttpStatusCode()
    {
        return 401;
    }
}