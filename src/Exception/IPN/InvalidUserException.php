<?php

namespace Xsolla\SDK\Exception\IPN;

class InvalidUserException extends ClientErrorException
{
    public function getXsollaErrorCode()
    {
        return 'INVALID_USER';
    }

    public function getHttpStatusCode()
    {
        return 422;
    }
}