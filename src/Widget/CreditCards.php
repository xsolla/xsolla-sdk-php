<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/card.html
 */
class CreditCards extends Paystation
{
    protected $marketplace = 'landing';

    protected $defaultParameters = array('pid'=> 1380, 'theme' => 201);
}
