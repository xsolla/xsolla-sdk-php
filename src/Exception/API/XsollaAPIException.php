<?php

namespace Xsolla\SDK\Exception\API;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Message;
use Psr\Http\Message\MessageInterface;
use Xsolla\SDK\Exception\XsollaException;
use function GuzzleHttp\Psr7\str;

class XsollaAPIException extends XsollaException
{
    protected static $exceptions = [
        422 => '\Xsolla\SDK\Exception\API\UnprocessableEntityException',
        403 => '\Xsolla\SDK\Exception\API\AccessDeniedException',
    ];

    protected static $messageTemplate =
<<<'EOF'
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

    /**
     * @return XsollaAPIException
     */
    public static function fromBadResponse(BadResponseException $previous)
    {
        $statusCode = $previous->getResponse()->getStatusCode();
        $message = sprintf(
            static::$messageTemplate,
            $previous->getMessage(),
            self::str($previous->getRequest()),
            self::str($previous->getResponse())
        );
        if (array_key_exists($statusCode, static::$exceptions)) {
            return new static::$exceptions[$statusCode]($message, 0, $previous);
        }

        return new self($message, 0, $previous);
    }

    /**
     * Returns the string representation of an HTTP message.
     *
     * Function str() is removed in guzzlehttp/psr7:2.0. Use method Message::toString() instead.
     *
     * @return string
     * @see https://github.com/guzzle/psr7#upgrading-from-function-api
     */
    protected static function str(MessageInterface $message)
    {
        if (method_exists(Message::class, 'toString')) {
            return Message::toString($message);
        }

        return str($message);
    }
}
