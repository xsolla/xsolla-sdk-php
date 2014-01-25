<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/pswidget.html
 */
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
