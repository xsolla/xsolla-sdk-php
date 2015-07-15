<?php

namespace Xsolla\SDK\Exception\IPN;

class ClientErrorException extends XsollaIPNException
{
    /**
     * @return string
     */
    public function getXsollaErrorCode()
    {
        return 'CLIENT_ERROR';
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return 400;
    }
}