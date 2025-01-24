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
        $message = '$previous getResponse() return null';

        $response = $previous->getResponse();
        if ($response === null) {
            return new self ($message, 0, $previous);
        }

        $statusCode = $response->getStatusCode();
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
     * Alternative function for str() cuz it's deleted in guzzlehttp/psr7:2.0. Now Message::toString() instead of it.
     *
     * @return string
     */
    protected static function str(MessageInterface $message)
    {
        if (method_exists(Message::class, 'toString')) {
            return Message::toString($message);
        }

        return str($message);
    }
}
