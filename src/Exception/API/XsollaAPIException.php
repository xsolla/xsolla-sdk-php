<?php

namespace Xsolla\SDK\Exception\API;

use Guzzle\Http\Exception\BadResponseException;
use Xsolla\SDK\Exception\XsollaException;

class XsollaAPIException extends XsollaException
{
    protected static $exceptions = array(
        422 => '\Xsolla\SDK\Exception\API\UnprocessableEntityException',
        403 => '\Xsolla\SDK\Exception\API\AccessDeniedException',
    );

    protected static $messageTemplate =
<<<EOF
Xsolla API Error Response:

Previous Exception:
===================
%s

Request:
===================
%s

Response:
===================
%s
EOF;

    public static function fromBadResponse(BadResponseException $previous)
    {
        $statusCode = $previous->getResponse()->getStatusCode();
        $message = sprintf(
            static::$messageTemplate,
            $previous->getMessage(),
            $previous->getRequest(),
            $previous->getResponse()
        );
        if (array_key_exists($statusCode, static::$exceptions)) {
            return new static::$exceptions[$statusCode]($message, 0, $previous);
        }

        return new self($message, 0, $previous);
    }
}
