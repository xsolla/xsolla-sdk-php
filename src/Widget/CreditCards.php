<?php

namespace Xsolla\SDK\Widget;


class CreditCards extends Paystation
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
        return array('pid'=> 1380, 'theme' => 201);
    }
}