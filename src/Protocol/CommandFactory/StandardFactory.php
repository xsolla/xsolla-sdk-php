<?php

namespace Xsolla\SDK\Protocol\CommandFactory;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Command\Cancel;
use Xsolla\SDK\Protocol\Command\Check;
use Xsolla\SDK\Protocol\Command\Command;
use Xsolla\SDK\Protocol\Command\PayStandard;
use Xsolla\SDK\Protocol\Protocol;
use Xsolla\SDK\Protocol\Standard;

class StandardFactory
{
    /**
     * @param  Protocol              $protocol
     * @param $commandName
     * @return Command
     * @throws WrongCommandException
     */
    public function getCommand(Standard $protocol, $commandName)
    {
        switch ($commandName) {
            case 'check':
                return new Check($protocol);
            case 'pay':
                return new PayStandard($protocol);
            case 'cancel':
                return new Cancel($protocol, $protocol->getPaymentStandardStorage());
            default:
                throw new WrongCommandException(sprintf(
                    'Wrong command: "%s". Available commands for Standard protocol are: "%s".',
                    $commandName,
                    join('", "', $protocol->getProtocolCommands())
                ));
        }
    }
}
