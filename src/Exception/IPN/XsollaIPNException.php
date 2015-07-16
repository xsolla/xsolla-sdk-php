<?php

namespace Xsolla\SDK\Exception\IPN;

use Xsolla\SDK\Exception\XsollaException;

class XsollaIPNException extends XsollaException
{
    /**
     * @return string
     */
    public function getXsollaErrorCode()
    {
        return 'SERVER_ERROR';
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return 500;
    }
}