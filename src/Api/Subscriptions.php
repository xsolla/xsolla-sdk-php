<?php

namespace Xsolla\SDK\Api;

use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Xsolla\SDK\Exception\InvalidArgumentException;
use Xsolla\SDK\Exception\InvalidRequestException;
use Xsolla\SDK\Exception\SecurityException;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\Subscription;
use Xsolla\SDK\User;

class Subscriptions
{
    const TYPE_CARD = 'card';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_YANDEX = 'yandex';
    const TYPE_WEBMONEY = 'wm';

    const URL = '/v1/subscriptions';

    const ERROR_CODE_INVALID_SIGN = 23;

    protected $project;
    protected $client;
    protected $isTest;

    public function __construct(Client $client, Project $project, $isTest = false)
    {
        $this->client = $client;
        $this->project = $project;
        $this->isTest = $isTest;
    }

    /**
     * @param  User           $user
     * @param  int            $type One of Subscriptions::TYPE_* constants
     * @return Subscription[]
     */
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
            $rows = $request->send()->json();
        } catch (ClientErrorResponseException $e) {
            $this->processException($e);
        }

        $subscriptions = array();
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
            'amount_virtual' => $invoice->getVirtualCurrencyAmount(),
            'card_cvv' => $cardCvv
        );

        $request = $this->client->post(
            self::URL . '/' . $subscription->getType(),
            array('X-Xsolla-Sign' => $this->generateSign($parameters)),
            null,
            array('query' => $parameters)
        );

        try {
            $result = $request->send()->json();

            return $result['id'];
        } catch (ClientErrorResponseException $e) {
            $this->processException($e);
        }
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
            null,
            array('query' => $parameters)
        );

        try {
            return Response::HTTP_NO_CONTENT == $request->send()->getStatusCode();
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
        $response = $e->getResponse()->json();
        if (self::ERROR_CODE_INVALID_SIGN == $response['error']['code']) {
            throw new SecurityException($response['error']['message'], $response['error']['code']);
        }
        throw new InvalidArgumentException($response['error']['message'], $response['error']['code']);
    }
}
