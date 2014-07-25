<?php
namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\ShoppingCart3;

class CheckShoppingCart3 extends Check
{
    public function __construct(ShoppingCart3 $protocol)
    {
        $this->userStorage = $protocol->getUserStorage();
        $this->project = $protocol->getProject();
    }

    public function checkSign(Request $request)
    {
        return $this->generateSign($request, array('command', 'v1', 'foreignInvoice')) === $request->query->get('md5');
    }
} 