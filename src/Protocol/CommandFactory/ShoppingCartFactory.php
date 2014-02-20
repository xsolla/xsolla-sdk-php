<?php

namespace Xsolla\SDK\Protocol\CommandFactory;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\ShoppingCart;
use Xsolla\SDK\Protocol\Command\Cancel;
use Xsolla\SDK\Protocol\Command\PayShoppingCart;
use Xsolla\SDK\Protocol\Protocol;

class ShoppingCartFactory
{
    /**
     * @param  Protocol              $protocol
     * @param $commandName
     * @return Cancel|PayShoppingCart
     * @throws WrongCommandException
     */
    public function getCommand(ShoppingCart $protocol, $commandName)
    {
        switch ($commandName) {
            case 'pay':
                return new PayShoppingCart($protocol);
            case 'cancel':
                return new Cancel($protocol, $protocol->getPaymentShoppingCartStorage());
            default:
                throw new WrongCommandException(sprintf(
                    'Wrong command: "%s". Available commands for protocol ShoppingCart 2.0 are: "%s".',
                    $commandName,
                    join('", "', $protocol->getProtocolCommands())
                ));
        }
    }

}
