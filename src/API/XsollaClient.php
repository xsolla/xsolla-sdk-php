<?php

namespace Xsolla\SDK\API;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Xsolla\SDK\API\PaymentUI\TokenRequest;
use Xsolla\SDK\Version;

class XsollaClient extends Client
{
    /**
     * @var int
     */
    protected $merchantId;

    /**
     * @var Client
     */
    protected $guzzleClient;

    public static function factory($config = array())
    {
        $default = array('base_url' => 'https://api.xsolla.com');
        $required = array(
            'merchant_id',
            'api_token'
        );
        $config = Collection::fromConfig($config, $default, $required);
        $client = new static(isset($config['base_url']) ? $config['base_url'] : null, $config);
        $client->setDescription(ServiceDescription::factory(__DIR__.'/../../resources/xsolla-api.php'));
        $client->setDefaultOption('auth', array($config['merchant_id'], $config['api_token'], 'Basic'));
        $client->setDefaultOption('headers', array('Accept' => 'application/json'));
        $client->setDefaultOption('command.params', array('merchant_id' => $config['merchant_id']));
        $client->setUserAgent(Version::getVersion());
        return $client;
    }

    /**
     * @param int $projectId
     * @param string $userId
     * @return string
     */
    public function getPaymentUIToken($projectId, $userId)
    {
        $tokenRequest = new TokenRequest($projectId, $userId);
        return $this->getPaymentUITokenFromRequest($tokenRequest);
    }

    /**
     * @param TokenRequest $tokenRequest
     * @return string
     */
    public function getPaymentUITokenFromRequest(TokenRequest $tokenRequest)
    {
        return $this->getPaymentUITokenFromArray($tokenRequest->toArray());
    }

    /**
     * @param array $tokenRequest
     * @return string
     */
    public function getPaymentUITokenFromArray(array $tokenRequest)
    {
        $guzzleRequest = $this->post(
            "/merchant/merchants/{$this->merchantId}/token",
            array('Content-Type' => 'application/json; charset=UTF-8'),
            json_encode($tokenRequest, JSON_PRETTY_PRINT)
        );
        $response = $guzzleRequest->send();
        $parsedResponse = $response->json();
        return $parsedResponse['token'];
    }
}