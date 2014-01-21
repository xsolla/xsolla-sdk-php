<?php

namespace Xsolla\SDK;

class User
{
    protected $v1;
    protected $v2;
    protected $v3;
    protected $email;
    protected $phone;
    protected $userIP;

    function __construct($v1, $v2 = null, $v3 = null, $email = null, $phone = null)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->v1 = $v1;
        $this->v2 = $v2;
        $this->v3 = $v3;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getV1()
    {
        return $this->v1;
    }

    public function getV2()
    {
        return $this->v2;
    }

    public function getV3()
    {
        return $this->v3;
    }

    public function getUserIP()
    {
        return $this->userIP;
    }

}