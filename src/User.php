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

    public function __construct($v1, $v2 = null, $v3 = null, $email = null, $phone = null, $userIp = null)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->v1 = $v1;
        $this->v2 = $v2;
        $this->v3 = $v3;
        $this->userIP = $userIp;
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

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $v2
     */
    public function setV2($v2)
    {
        $this->v2 = $v2;
    }

    /**
     * @param string $v3
     */
    public function setV3($v3)
    {
        $this->v3 = $v3;
    }

    /**
     * @param string $userIP
     */
    public function setUserIp($userIP)
    {
        $this->userIP = $userIP;
    }

}
