<?php

namespace Xsolla\SDK\Exception\Webhook;

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
