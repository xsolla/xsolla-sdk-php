<?php

namespace Xsolla\SDK\Tests\Integration\API;

class SubscriptionsTest extends AbstractAPITest
{
    public function testCreateSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    public function testUpdateSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    public function testDeleteSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    public function testDisableSubscriptionPlan()
    {
        static::markTestSkipped();
    }

    public function testEnableSubscriptionPlan()
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