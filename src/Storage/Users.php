<?php
namespace Xsolla\SDK\Storage;

class Users implements UsersInterface
{
    public function check($v1, $v2 = null, $v3 = null)
    {
        return ($v1 == 'demo');
    }
}
