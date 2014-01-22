<?php
/**
 * Created by PhpStorm.
 * User: abets
 * Date: 22.01.14
 * Time: 11:13
 */

namespace Xsolla\SDK\Widget;


class MobilePayment extends Paystation
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
        return array('pid'=> 1738,'theme' => 201);
    }
} 