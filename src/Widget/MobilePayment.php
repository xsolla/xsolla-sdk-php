<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/mversion.html
 */
class MobilePayment extends Paystation
{

    public function getMarketplace()
    {
        return 'landing';
    }

    public function getRequiredParams()
    {
        return array('project','pid','marketplace');
    }

    public function getDefaultParams()
    {
        return array('pid'=> 1738,'theme' => 201);
    }
}
