<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/paystation.html
 */
class Paystation extends Widget
{
    public function getMarketplace()
    {
        return 'paystation';
    }

    public function getRequiredParams()
    {
        return array('project');
    }
}
