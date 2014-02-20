<?php

namespace Xsolla\SDK\Api;

use Guzzle\Http\Client;
use Xsolla\SDK\Project;
use Xsolla\SDK\Version;

class ApiFactory
{
    const BASE_URL = 'https://api.xsolla.com';

    protected $client;

    protected $project;

    public function __construct(Project $project, Client $client = null)
    {
        $this->client = $client ?: $this->setUpClient();
        $this->project = $project;
    }

    protected function setUpClient()
    {
        $client = new Client(self::BASE_URL);
        $client->setUserAgent(Version::getVersion());
        return $client;
    }

    public function getCalculatorApi()
    {
        return new CalculatorApi($this->client, $this->project);
    }

    public function getMobilePaymentApi()
    {
        return new MobilePaymentApi($this->client, $this->project);
    }

    public function getNumberApi()
    {
        return new NumberApi($this->client, $this->project);
    }

    public function getQiwiWalletApi()
    {
        return new QiwiWalletApi($this->client, $this->project);
    }

    /**
     * @param bool $isTest
     * @return SubscriptionsApi
     */
    public function getSubscriptionsApi($isTest = false)
    {
        return new SubscriptionsApi($this->client, $this->project, $isTest);
    }
}
