<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

interface WidgetInterface
{
    public function getLink(User $user, Invoice $invoice = null, array $params = array());
}
