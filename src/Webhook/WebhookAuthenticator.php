<?php

namespace Xsolla\SDK\Webhook;

use Symfony\Component\HttpFoundation\IpUtils;
use Xsolla\SDK\Exception\Webhook\InvalidClientIpException;
use Xsolla\SDK\Exception\Webhook\InvalidSignatureException;

class WebhookAuthenticator
{
    protected static $xsollaSubnets = array(
        '159.255.220.240/28',
        '185.30.20.16/29',
        '185.30.21.0/24',
        '185.30.21.16/29',
    );

    /**
     * @var string
     */
    protected $projectSecretKey;

    /**
     * @param string $projectSecretKey
     */
    public function __construct($projectSecretKey)
    {
        $this->projectSecretKey = $projectSecretKey;
    }

    /**
     * @param WebhookRequest $webhookRequest
     * @param bool           $checkClientIp
     *
     * @throws InvalidClientIpException
     * @throws InvalidSignatureException
     */
    public function authenticate(WebhookRequest $webhookRequest, $checkClientIp = true)
    {
        if (true === $checkClientIp) {
            $this->authenticateClientIp($webhookRequest->getClientIp());
        }
        $this->authenticateSignature($webhookRequest);
    }

    /**
     * @param string $clientIp
     *
     * @throws InvalidClientIpException
     */
    public function authenticateClientIp($clientIp)
    {
        if (false === IpUtils::checkIp($clientIp, self::$xsollaSubnets)) {
            throw new InvalidClientIpException(sprintf(
                'Xsolla trusted subnets (%s) doesn\'t contain client IP address (%s). If you use reverse proxy, you should set correct client IPv4 to WebhookRequest. If you are in development environment, you can set $authenticateClientIp = false in $webhookServer->start();',
                implode(', ', self::$xsollaSubnets),
                $clientIp
            ));
        }
    }

    /**
     * @param WebhookRequest $webhookRequest
     *
     * @throws InvalidSignatureException
     */
    public function authenticateSignature(WebhookRequest $webhookRequest)
    {
        $headers = $webhookRequest->getHeaders();
        if (!array_key_exists('authorization', $headers)) {
            throw new InvalidSignatureException('"Authorization" header not found in Xsolla webhook request');
        }
        $matches = array();
        preg_match('~^Signature ([0-9a-f]{40})$~', $headers['authorization'], $matches);
        if (array_key_exists(1, $matches)) {
            $clientSignature = $matches[1];
        } else {
            throw new InvalidSignatureException('Signature not found in "Authorization" header from Xsolla webhook request: '.$headers['authorization']);
        }
        $serverSignature = sha1($webhookRequest->getBody().$this->projectSecretKey);
        if ($clientSignature !== $serverSignature) {
            throw new InvalidSignatureException("Invalid Signature. Signature provided in \"Authorization\" header ($clientSignature) does not match with expected");
        }
    }
}
