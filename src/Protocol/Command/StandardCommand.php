<?php
namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\User;

abstract class StandardCommand extends Command
{
    public function createUser(Request $request)
    {
        return new User(
            $request->query->get('v1'),
            $request->query->get('v2'),
            $request->query->get('v3')
        );
    }
}