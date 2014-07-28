<?php
namespace Xsolla\SDK\Protocol\CommandFactory;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Command\Cancel;
use Xsolla\SDK\Protocol\Command\CheckShoppingCart3;
use Xsolla\SDK\Protocol\Command\Command;
use Xsolla\SDK\Protocol\Command\PayShoppingCart3;
use Xsolla\SDK\Protocol\ShoppingCart3;

class ShoppingCart3Factory
{
    /**
     * @param \Xsolla\SDK\Protocol\ShoppingCart3 $protocol
     * @param $commandName
     * @throws WrongCommandException
     * @return Command
     */
    public function getCommand(ShoppingCart3 $protocol, $commandName)
    {
        switch ($commandName) {
            case 'check':
                return new CheckShoppingCart3($protocol);
            case 'pay':
                return new PayShoppingCart3($protocol);
            case 'cancel':
                return new Cancel($protocol, $protocol->getPaymentShoppingCart3Storage());
            default:
                throw new WrongCommandException(sprintf(
                    'Wrong command: "%s". Available commands for Standard protocol are: "%s".',
                    $commandName,
                    join('", "', $protocol->getProtocolCommands())
                ));
        }
    }
} 