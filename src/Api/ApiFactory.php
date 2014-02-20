<?php

namespace Xsolla\SDK\Api;

use Guzzle\Http\Client;
use Xsolla\SDK\Project;

class ApiFactory {

    const BASE_URL = 'https://api.xsolla.com';

    protected $client;
    protected $project;

    public function __construct(Client $client, Project $project)
    {
        $this->client = $client;
        $this->client->setBaseUrl(self::BASE_URL);
        $this->project = $project;
    }

    /**
     * @return CalculatorApi
     */
    public function getCalculatorApi()
    {
        return new CalculatorApi($this->client, $this->project);
    }

    /**
     * @return MobilePaymentApi
     */
    public function getMobilePaymentApi()
    {
        return new MobilePaymentApi($this->client, $this->project);
    }

    /**
     * @return NumberApi
     */
    public function getNumberApi()
    {
        return new NumberApi($this->client, $this->project);
    }

    /**
     * @return QiwiWalletApi
     */
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