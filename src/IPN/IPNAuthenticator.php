<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\IpUtils;
use Xsolla\SDK\Exception\IPN\InvalidClientIpException;
use Xsolla\SDK\Exception\IPN\InvalidSignatureException;

class IPNAuthenticator
{
    protected static $xsollaSubnets = array(
        '159.255.220.240/28',
        '185.30.20.16/29',
        '185.30.21.0/24',
        '185.30.21.16/29'
    );

    /**
     * @var string
     */
    protected $xsollaApiToken;

    /**
     * @param string $xsollaApiToken
     */
    public function __construct($xsollaApiToken)
    {
        $this->xsollaApiToken = $xsollaApiToken;
    }

    /**
     * @param IPNRequest $IPNRequest
     * @param bool $checkClientIp
     * @throws InvalidClientIpException
     * @throws InvalidSignatureException
     */
    public function authenticate(IPNRequest $IPNRequest, $checkClientIp = true)
    {
        if (true === $checkClientIp) {
            $this->authenticateClientIp($IPNRequest->getClientIp());
        }
        $this->authenticateSignature($IPNRequest);
    }

    /**
     * @param string $clientIp
     * @throws InvalidClientIpException
     */
    public function authenticateClientIp($clientIp)
    {
        if (false === IpUtils::checkIp($clientIp, self::$xsollaSubnets)) {
            throw new InvalidClientIpException();
        }
    }

    /**
     * @param IPNRequest $IPNRequest
     * @throws InvalidSignatureException
     */
    public function authenticateSignature(IPNRequest $IPNRequest)
    {
        $headers = $IPNRequest->getHeaders();
        if (!array_key_exists('Authorization', $headers)) {
            throw new InvalidSignatureException();
        }
        $matches = array();
        preg_match('~^Signature: ([0-9a-f]{40})$~', $headers['Authorization'], $matches);
        if (array_key_exists(1, $matches)) {
            $clientSignature = $matches[1];
        } else {
            throw new InvalidSignatureException();
        }
        $serverSignature = sha1($IPNRequest->getBody().$this->xsollaApiToken);
        if ($clientSignature !== $serverSignature) {
            throw new InvalidSignatureException();
        }
    }
}