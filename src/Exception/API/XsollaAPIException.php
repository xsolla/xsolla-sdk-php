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

    protected $messageTemplate =
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

    protected $errorDetails;

    public static function factory(BadResponseException $previous)
    {
        $statusCode = $previous->getResponse()->getStatusCode();
        if (array_key_exists($statusCode, static::$exceptions)) {
            return new static::$exceptions[$statusCode]($previous);
        }
        return new self($previous);
    }

    public function __construct(BadResponseException $previous)
    {
        $message = sprintf(
            $this->messageTemplate,
            $previous->getMessage(),
            $previous->getRequest(),
            $previous->getResponse()
        );
        $parsedResponse = json_decode($previous->getResponse()->getBody(true), true);
        if (is_array($parsedResponse)) {
            $this->errorDetails = $parsedResponse;
        };
        parent::__construct($message);
    }

    public function getApiErrorMessage()
    {
        return $this->errorDetails['message'];
    }

}