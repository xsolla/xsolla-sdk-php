<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\Request;
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
    protected $parsedBody;

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
        return new static($request->headers->all(), $request->getContent(), $request->getClientIp());
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
    public function getParsedBody()
    {
        if (!$this->parsedBody) {
            $data = json_decode($this->body, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new XsollaIPNException('Unable to parse request body into JSON: ' . json_last_error());
            }
            $this->parsedBody = $data === null ? array() : $data;
        }
        return $this->parsedBody;
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