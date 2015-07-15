<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\Response;
use Xsolla\SDK\Exception\IPN\XsollaIPNException;
use Xsolla\SDK\Version;

class IPNResponse
{
    /**
     * @var int
     */
    protected $httpStatusCode;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var Response
     */
    protected $symfonyResponse;

    /**
     * @param \Exception $e
     * @return IPNResponse
     */
    public static function fromException(\Exception $e)
    {
        if ($e instanceof XsollaIPNException) {
            return static::fromErrorCode($e->getXsollaErrorCode(), $e->getMessage(), $e->getHttpStatusCode());
        } else {
            return static::fromErrorCode('FATAL_ERROR', $e->getMessage());
        }
    }

    /**
     * @param string $xsollaErrorCode
     * @param string $message
     * @param int $httpStatus
     * @return IPNResponse
     */
    public static function fromErrorCode($xsollaErrorCode, $message = '', $httpStatus = 500)
    {
        $body = [
            'code' => $xsollaErrorCode,
            'message' => $message
        ];
        $encodedBody = json_encode($body, JSON_PRETTY_PRINT);
        return new static($httpStatus, $encodedBody);
    }

    /**
     * @param int $httpStatusCode
     * @param string $body
     */
    public function __construct($httpStatusCode = 204, $body = '')
    {
        $this->symfonyResponse = new Response($body, $httpStatusCode, array('x-xsolla-sdk' => Version::getVersion()));
    }

    /**
     * @return Response
     */
    public function getSymfonyResponse()
    {
        return $this->symfonyResponse;
    }
}