<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\IPN\InvalidParameterException;
use Xsolla\SDK\Exception\IPN\XsollaIPNException;

class IPNRequest
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $clientIp;

    /**
     * @return IPNRequest
     * @throws XsollaIPNException
     */
    public static function fromGlobals()
    {
        $request = Request::createFromGlobals();
        $headers = array();
        foreach ($request->headers->all() as $header => $arrayValue) {
            $headers[$header] = $arrayValue[0];
        }
        return new static($headers, $request->getContent(), $request->getClientIp());
    }

    /**
     * @param array $headers
     * @param string $body
     * @param string $clientIp
     */
    public function __construct(array $headers, $body, $clientIp = null)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->clientIp = $clientIp;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     * @throws XsollaIPNException
     */
    public function toArray()
    {
        $data = json_decode($this->body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidParameterException('Unable to parse request body into JSON: ' . json_last_error());
        }
        return $data === null ? array() : $data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }
}