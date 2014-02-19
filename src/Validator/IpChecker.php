<?php

namespace Xsolla\SDK\Validator;

use Symfony\Component\HttpFoundation\IpUtils;
use Xsolla\SDK\Exception\SecurityException;

class IpChecker
{
    protected $ipWhitelist = array(
        '94.103.26.176/29',
        '159.255.220.240/28',
        '185.30.20.16/29',
        '185.30.21.16/29'
    );

    public function checkIp($clientIp)
    {
        if (!IpUtils::checkIp($clientIp, $this->ipWhitelist)) {
            throw new SecurityException(sprintf(
                'IP whitelist(%s) doesn\'t contain client IP address(%s). If you use reverse proxy, you should set a list of trusted proxies via Request::setTrustedProxies(). If you are in development environment, you can skip "IpChecker" parameter in ProtocolBuilder.',
                implode(', ', $this->ipWhitelist),
                $clientIp
            ));
        }
    }
}
