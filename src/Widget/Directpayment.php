<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/directpayment.html
 */
class Directpayment extends Paystation
{
    public function getMarketplace()
    {
        return 'landing';
    }

    public function getRequiredParams()
    {
        return array('project','pid','marketplace');
    }

}
