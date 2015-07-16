<?php

namespace Xsolla\SDK\API\PaymentUI;

class TokenRequest
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param int $projectId
     * @param string $userId
     */
    public function __construct($projectId, $userId)
    {
        $this->data['user']['id']['value'] = $userId;
        $this->data['settings']['project_id'] = $projectId;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setUserEmail($email)
    {
        $this->data['user']['email']['value'] = $email;
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setUserName($name)
    {
        $this->data['user']['name']['value'] = $name;
        return $this;
    }

    /**
     * @param string $currencyIsoCode
     * @return self
     */
    public function setCurrency($currencyIsoCode)
    {
        $this->data['settings']['currency'] = $currencyIsoCode;
        return $this;
    }

    /**
     * @param array $customParameters
     * @return self
     */
    public function setCustomParameters(array $customParameters)
    {
        $this->data['custom_parameters'] = $customParameters;
        return $this;
    }

    /**
     * @param string $externalId
     * @return self
     */
    public function setExternalPaymentId($externalId)
    {
        $this->data['settings']['external_id'] = $externalId;
        return $this;
    }

    /**
     * @param bool $isSandbox
     * @return self
     */
    public function setSandboxMode($isSandbox = true)
    {
        if (true === $isSandbox) {
            $this->data['settings']['mode'] = 'sandbox';
        } else {
            unset($this->data['settings']['mode']);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}