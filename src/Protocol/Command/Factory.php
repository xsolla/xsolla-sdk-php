<?php

namespace Xsolla\SDK\Protocol\Command;

use Xsolla\SDK\Protocol\PayCash;
use Xsolla\SDK\Protocol\PayStandard;
use Xsolla\SDK\Protocol\Protocol;

class Factory
{

    /**
     * @param Protocol $protocol
     * @param $command
     * @return Command
     */
    public function getCommand(Protocol $protocol, $command)
    {
        switch ($command) {
            case 'check':
                $command = new CheckNickname(new Security(), new Project(), new Users());
                break;

            case 'pay':
                if($protocol->getProtocol() == 'cash') {
                    $command = new PayCash($protocol->getProject(), new Payments());
                }
                else {
                    $command = new PayStandard(new Security(), new Project(), new Payments());
                }
                break;

            case 'cancel':
                $command = new Cancel($protocol->getProject(), $protocol->getUsers());
                break;
        }
        return $command;
    }
}