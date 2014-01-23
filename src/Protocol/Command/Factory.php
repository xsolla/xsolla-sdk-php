<?php

namespace Xsolla\SDK\Protocol\Command;

use Xsolla\SDK\Exception\WrongCommandException;
use Xsolla\SDK\Protocol\Cash;
use Xsolla\SDK\Protocol\Protocol;
use Xsolla\SDK\Protocol\Standard;

class Factory
{

    /**
     * @param  Protocol $protocol
     * @param $command
     * @return Command
     */
    public function getCommand(Protocol $protocol, $command)
    {
        if ($protocol->getProtocol() == Cash::PROTOCOL) {
            if ($command == 'pay') {
                return new PayCash($protocol->getProject(), $protocol->getPayments());
            } elseif ($command == 'cancel') {
                return new Cancel($protocol->getProject(), $protocol->getUsers());
            }
        } elseif ($protocol->getProtocol() == Standard::PROTOCOL) {
            if ($command == 'check') {
                return new Check($protocol->getProject(), $protocol->getUsers());
            } elseif ($command == 'pay') {
                return new PayStandard($protocol->getProject(), $protocol->getUsers(), $protocol->getPayments());
            } elseif ($command == 'cancel') {
                return new Cancel($protocol->getProject(), $protocol->getUsers());
            }
        }

        throw new WrongCommandException;
    }
}
