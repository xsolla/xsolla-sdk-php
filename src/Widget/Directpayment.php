<?php

namespace Xsolla\SDK\Widget;

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
