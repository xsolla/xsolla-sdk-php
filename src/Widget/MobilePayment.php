<?php

namespace Xsolla\SDK\Widget;

/**
 * @link http://xsolla.github.io/en/mversion.html
 */
class MobilePayment extends Widget
{
    protected $marketplace = 'landing';

    protected $defaultParameters = array('pid'=> 1738, 'theme' => 201);
}
