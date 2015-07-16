<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class SubscriptionsTest extends AbstractAPITest
{
    protected static $planId;

    public function testCreateSubscriptionPlan()
    {
        static::markTestSkipped();
        /*
        $response = $this->xsollaClient->CreateSubscriptionPlan(array(
            'project_id' => $this->projectId,
            'request' => array(
                'name' => array(
                    'en' => 'subscription_plan'
                ),
                'group_id' => 'test',
                'charge' => array(
                    'amount' => 1,
                    'currency' => 'USD',
                    'period' => array(
                        'value' => 1,
                        'type' => 'month',
                    ),
                ),
                'expiration' => array(
                    'value' => 3,
                    'type' => 'month',
                ),
            ),
        ));
        static::assertArrayHasKey('plan_id', $response);
        static::$planId = $response['plan_id'];
        */
    }

    /**
     * @depends testCreateSubscriptionPlan
     */
    public function testUpdateSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    /**
     * @depends testUpdateSubscriptionPlan
     */
    public function testDisableSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    /**
     * @depends testDisableSubscriptionPlan
     */
    public function testEnableSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    /**
     * @depends testEnableSubscriptionPlan
     */
    public function testDeleteSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    public function testListSubscriptionPlans()
    {
        $response = $this->xsollaClient->ListSubscriptionPlans(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testCreateSubscriptionProduct()
    {
        static::markTestSkipped();
    }

    public function testUpdateSubscriptionProduct()
    {
        static::markTestSkipped();
    }

    public function testDeleteSubscriptionProduct()
    {
        static::markTestSkipped();
    }

    public function testListSubscriptionProducts()
    {
        $response = $this->xsollaClient->ListSubscriptionProducts(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testUpdateSubscription()
    {
        static::markTestSkipped();
    }

    public function testListSubscriptions()
    {
        $response = $this->xsollaClient->ListSubscriptions(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionPayments()
    {
        $response = $this->xsollaClient->ListSubscriptionPayments(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionCurrencies()
    {
        $response = $this->xsollaClient->ListSubscriptionCurrencies(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
        ));
        static::assertInternalType('array', $response);
    }
}