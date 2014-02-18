<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/pswidget.html
 */
class Paydesk extends Paystation
{
    protected function getMarketplace()
    {
        return 'paydesk';
    }

    protected function getRequiredParams()
    {
        return array('project', 'marketplace');
    }

}
