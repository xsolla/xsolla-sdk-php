<?php

namespace Xsolla\SDK\Validator;

use Symfony\Component\HttpFoundation\IpUtils;

class IpChecker
{
    protected $ips = array(
        '94.103.26.176/29',
        '159.255.220.240/28',
        '185.30.20.16/29',
        '185.30.21.16/29'
    );

    public function checkIp($ip)
    {
        return IpUtils::checkIp($ip, $this->ips);
    }
}
