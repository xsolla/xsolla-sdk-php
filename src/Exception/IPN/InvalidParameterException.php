<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidParameterException extends XsollaIPNException
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