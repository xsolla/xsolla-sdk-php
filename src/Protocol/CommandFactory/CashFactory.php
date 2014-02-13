<?php

namespace Xsolla\SDK\Protocol\CommandFactory;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Cash;
use Xsolla\SDK\Protocol\Command\Cancel;
use Xsolla\SDK\Protocol\Command\PayCash;
use Xsolla\SDK\Protocol\Protocol;

class CashFactory
{
    /**
     * @param  Protocol              $protocol
     * @param $commandName
     * @return Cancel|PayCash
     * @throws WrongCommandException
     */
    public function getCommand(Cash $protocol, $commandName)
    {
        switch ($commandName) {
            case 'pay':
                return new PayCash($protocol);
            case 'cancel':
                return new Cancel($protocol, $protocol->getPaymentsCash());
            default:
                throw new WrongCommandException(sprintf(
                    'Wrong command: "%s". Available commands for protocol Cash 2.0 are: "%s".',
                    $commandName,
                    join('", "', $protocol->getProtocolCommands())
                ));
        }
    }

}
