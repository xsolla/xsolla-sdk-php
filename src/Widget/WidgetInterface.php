<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

interface WidgetInterface
{
    /**
     * @param  User    $user
     * @param  Invoice $invoice
     * @param  array   $params Additional parameters described in documentation http://xsolla.github.io/en/pswidget.html#title4
     * @return string
     */
    public function getLink(User $user, Invoice $invoice = null, array $params = array());
}
