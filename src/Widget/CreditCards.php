<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/card.html
 */
class CreditCards extends Paystation
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
        return array('pid'=> 1380, 'theme' => 201);
    }
}
