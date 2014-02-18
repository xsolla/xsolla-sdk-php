<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/mversion.html
 */
class MobilePayment extends Paystation
{

    protected function getMarketplace()
    {
        return 'landing';
    }

    protected function getRequiredParams()
    {
        return array('project', 'pid', 'marketplace');
    }

    protected function getDefaultParams()
    {
        return array('pid'=> 1738, 'theme' => 201);
    }
}
