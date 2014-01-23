<?php

namespace Xsolla\SDK\User;


use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\RequestException;
use Xsolla\SDK\Exception\InvalidArgumentException;
use Xsolla\SDK\Exception\SecurityException;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\Subscription;
use Xsolla\SDK\User;

class Subscriptions
{
    const TYPE_CARD = 'card';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_YANDEX = 'yandex';
    const TYPE_WEBMONEY = 'wm';

    const URL = '/v1/subscriptions';

    /**
     * @var ProjectInterface
     */
    protected $project;
    protected $client;
    protected $isTest;

    public function __construct(Client $client, ProjectInterface $project, $isTest = false)
    {
        $this->client = $client;
        $this->project = $project;
        $this->isTest = $isTest;
    }

    public function search(User $user, $type = null)
    {
        $parameters = array(
            'merchant_id' => $this->project->getProjectId(),
            'v1' => $user->getV1(),
            'v2' => $user->getV2(),
            'v3' => $user->getV3(),
            'type' => $type,
            'test' => $this->isTest
        );

        $request = $this->client->get(
            self::URL,
            array('X-Xsolla-Sign' => $this->generateSign($parameters)),
            array('query' => $parameters)
        );

        try {
            $response = $request->send();
        } catch (ClientErrorResponseException $e) {
            $this->processException($e);
        }

        $subscriptions = array();
        $rows = json_decode($response->getBody(true), true);

        foreach ($rows['subscriptions'] as $row) {
            $subscriptions[] = new Subscription($row['id'], $row['name'], $row['type'], $row['currency']);
        }
        return $subscriptions;
    }

    public function pay(Subscription $subscription, Invoice $invoice, $cardCvv = null)
    {
        $parameters = array(
            'subscription_id' => $subscription->getId(),
            'merchant_id' => $this->project->getProjectId(),
            'amount_virtual' => $invoice->getOut(),
            'card_cvv' => $cardCvv
        );

        $request = $this->client->post(
            self::URL . '/' . $subscription->getType(),
            array('X-Xsolla-Sign' => $this->generateSign($parameters)),
            array('query' => $parameters)
        );

        try {
            $result = json_decode($request->send()->getBody(true), true);
        } catch (ClientErrorResponseException $e) {
            $this->processException($e);
        }
        return $result['id'];
    }

    public function delete(Subscription $subscription)
    {
        $parameters = array(
            'merchant_id' => $this->project->getProjectId(),
            'subscription_id' => $subscription->getId()
        );
        $request = $this->client->delete(
            self::URL . '/' . $subscription->getType(),
            array('X-Xsolla-Sign' => $this->generateSign($parameters)),
            array('query' => $parameters)
        );

        try {
            return ($request->send()->getStatusCode() == 204);
        } catch (ClientErrorResponseException $e) {
            $this->processException($e);
        }
    }

    protected function generateSign($parameters)
    {
        $signString = '';
        ksort($parameters);
        foreach ($parameters as $key => $val) {
            $signString .= $key . '=' . $val;
        }

        return md5($signString . $this->project->getSecretKey());
    }

    public function processException(ClientErrorResponseException $e)
    {
        $response = json_decode($e->getResponse()->getBody(true), true);
        if ($response['error']['code'] == 23) {
            throw new SecurityException($response['error']['message'], $response['error']['code']);
        }
        throw new InvalidArgumentException($response['error']['message'], $response['error']['code']);
    }
} 