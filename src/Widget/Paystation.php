<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/paystation.html
 */
class Paystation extends Widget
{
    protected function getMarketplace()
    {
        return 'paystation';
    }

    protected function getRequiredParams()
    {
        return array('project');
    }
}
