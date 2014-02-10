<?php

namespace Xsolla\SDK\Protocol\Command;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Protocol;

class Factory
{
    /**
     * @param  Protocol $protocol
     * @param $command
     * @return Command
     */
    public function getCommand(Protocol $protocol, $command)
    {
        $protocolName = $protocol->getProject()->getProtocol();
        if (Protocol::PROTOCOL_CASH == $protocolName) {
            if ($command == 'pay') {
                return new PayCash($protocol->getProject(), $protocol->getPayments());
            } elseif ($command == 'cancel') {
                return new Cancel($protocol->getProject(), $protocol->getPayments());
            }
        } elseif (Protocol::PROTOCOL_STANDARD == $protocolName) {
            if ($command == 'check') {
                return new Check($protocol->getProject(), $protocol->getUsers());
            } elseif ($command == 'pay') {
                return new PayStandard($protocol->getProject(), $protocol->getUsers(), $protocol->getPayments());
            } elseif ($command == 'cancel') {
                return new Cancel($protocol->getProject(), $protocol->getPayments());
            }
        }

        throw new WrongCommandException;
    }
}
