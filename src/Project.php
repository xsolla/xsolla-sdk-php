<?php
namespace Xsolla\SDK;

class Project
{
    protected $projectId;
    protected $secretKey;

    public function __construct($projectId, $secretKey)
    {
        $this->projectId = $projectId;
        $this->secretKey = $secretKey;
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
}
