<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\Response;
use Xsolla\SDK\Exception\IPN\XsollaIPNException;
use Xsolla\SDK\Version;

class IPNResponse
{
    protected $httpStatusCode;

    protected $body;

    protected $symfonyResponse;

    public static function fromException(\Exception $e)
    {
        if ($e instanceof XsollaIPNException) {
            return self::fromErrorCode($e->getXsollaErrorCode(), $e->getMessage(), $e->getHttpStatusCode());
        } else {
            return self::fromErrorCode('FATAL_ERROR', $e->getMessage());
        }
    }

    public static function fromErrorCode($xsollaErrorCode, $message = '', $httpStatus = 500)
    {
        $body = [
            'code' => $xsollaErrorCode,
            'message' => $message
        ];
        $encodedBody = json_encode($body, JSON_PRETTY_PRINT);
        return new static($httpStatus, $encodedBody);
    }

    public function __construct($httpStatusCode = 204, $body = '')
    {
        $this->symfonyResponse = new Response($body, $httpStatusCode, array('X-Xsolla-SDK' => Version::getVersion()));
    }

    public function sendResponse()
    {
        $this->symfonyResponse->send();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->symfonyResponse;
    }
}