<?php

namespace Xsolla\SDK\Widget;

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