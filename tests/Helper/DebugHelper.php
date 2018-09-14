<?php

namespace Xsolla\SDK\Tests\Helper;

class DebugHelper
{
    public static function isDebug()
    {
        return in_array('--debug', $GLOBALS['argv'], true);
    }
}
