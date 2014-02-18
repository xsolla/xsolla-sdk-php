<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/directpayment.html
 */
class Directpayment extends Paystation
{
    protected function getMarketplace()
    {
        return 'landing';
    }

    protected function getRequiredParams()
    {
        return array('project', 'pid', 'marketplace');
    }

}
