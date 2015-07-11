<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidSignatureException extends XsollaIPNException
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