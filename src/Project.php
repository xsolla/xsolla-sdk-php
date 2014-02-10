<?php
namespace Xsolla\SDK;

use Xsolla\SDK\Protocol\Protocol;

class Project
{
    protected $projectId;
    protected $secretKey;
    protected $protocol;

    public function __construct($projectId, $secretKey, $protocol = Protocol::PROTOCOL_STANDARD)
    {
        $this->projectId = $projectId;
        $this->secretKey = $secretKey;
        $this->protocol = $protocol;
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }
}
