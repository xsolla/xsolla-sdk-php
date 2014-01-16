<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;

abstract class Command {

    public function getResponse(Request $request) {
        $this->checkSign($request);
        return $this->process($request);
    }

    abstract public function checkSign(Request $request);

    abstract public function process(Request $request);
}