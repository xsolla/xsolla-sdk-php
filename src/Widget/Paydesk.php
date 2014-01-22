<?php

namespace Xsolla\SDK\Widget;


class Paydesk extends Paystation
{
    public function getMarketplace()
    {
        return 'paydesk';
    }

    public function getRequiredParams()
    {
        return array('project','marketplace');
    }

}