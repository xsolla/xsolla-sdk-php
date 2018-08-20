<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class SubscriptionsTest extends AbstractAPITest
{
    protected static $planId;

    protected static $productId;

    protected $plan = [
        'name' => [
            'en' => 'Subscription Plan Name',
        ],
        'group_id' => 'group_id',
        'charge' => [
            'amount' => 1,
            'currency' => 'USD',
            'period' => [
                'value' => 1,
                'type' => 'month',
            ],
        ],
        'expiration' => [
            'value' => 3,
            'type' => 'month',
        ],
    ];

    protected $product = [
        'name' => 'Product Name',
        'group_id' => 'group_id',
    ];

    public function testCreateSubscriptionPlan()
    {
        $response = static::$xsollaClient->CreateSubscriptionPlan([
            'project_id' => static::$projectId,
            'request' => $this->plan,
        ]);
        static::assertArrayHasKey('plan_id', $response);
        static::assertInternalType('integer', $response['plan_id']);
        static::$planId = $response['plan_id'];
    }

    /**
     * @depends testCreateSubscriptionPlan
     */
    public function testListSubscriptionPlans()
    {
        $response = static::$xsollaClient->ListSubscriptionPlans([
            'project_id' => static::$projectId,
            'limit' => 100,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListSubscriptionPlans
     */
    public function testUpdateSubscriptionPlan()
    {
        $response = static::$xsollaClient->UpdateSubscriptionPlan([
            'project_id' => static::$projectId,
            'plan_id' => static::$planId,
            'request' => $this->plan,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testUpdateSubscriptionPlan
     */
    public function testDisableSubscriptionPlan()
    {
        $response = static::$xsollaClient->DisableSubscriptionPlan([
            'project_id' => static::$projectId,
            'plan_id' => static::$planId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testDisableSubscriptionPlan
     */
    public function testEnableSubscriptionPlan()
    {
        $response = static::$xsollaClient->EnableSubscriptionPlan([
            'project_id' => static::$projectId,
            'plan_id' => static::$planId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testEnableSubscriptionPlan
     */
    public function testDeleteSubscriptionPlan()
    {
        $response = static::$xsollaClient->DeleteSubscriptionPlan([
            'project_id' => static::$projectId,
            'plan_id' => static::$planId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testDeleteSubscriptionPlan
     */
    public function testCreateSubscriptionProduct()
    {
        $response = static::$xsollaClient->CreateSubscriptionProduct([
            'project_id' => static::$projectId,
            'request' => $this->product,
        ]);
        static::assertArrayHasKey('product_id', $response);
        static::$productId = $response['product_id'];
    }

    /**
     * @depends testCreateSubscriptionProduct
     */
    public function testListSubscriptionPlansWithParams()
    {
        $response = static::$xsollaClient->ListSubscriptionPlans([
            'project_id' => static::$projectId,
            'limit' => 100,
            'offset' => 0,
            'product_id' => static::$productId,
            'group_id' => $this->product['group_id'],
            'external_id' => 12345,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testCreateSubscriptionProduct
     */
    public function testUpdateSubscriptionProduct()
    {
        $response = static::$xsollaClient->UpdateSubscriptionProduct([
            'project_id' => static::$projectId,
            'product_id' => static::$productId,
            'request' => $this->product,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testUpdateSubscriptionProduct
     */
    public function testDeleteSubscriptionProduct()
    {
        $response = static::$xsollaClient->DeleteSubscriptionProduct([
            'project_id' => static::$projectId,
            'product_id' => static::$productId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    public function testListSubscriptionProducts()
    {
        $response = static::$xsollaClient->ListSubscriptionProducts([
            'project_id' => static::$projectId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionProductsWithParams()
    {
        $response = static::$xsollaClient->ListSubscriptionProducts([
            'project_id' => static::$projectId,
            'product_id' => static::$productId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testUpdateSubscription()
    {
        static::markTestIncomplete('We haven\'t active subscriptions in test project.');
    }

    public function testListSubscriptions()
    {
        $response = static::$xsollaClient->ListSubscriptions([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionWithParams()
    {
        $response = static::$xsollaClient->ListSubscriptions([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'plan_id' => static::$planId,
            'product_id' => static::$productId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testListUserSubscriptionPayments()
    {
        $response = static::$xsollaClient->ListUserSubscriptionPayments([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionPayments()
    {
        $response = static::$xsollaClient->ListSubscriptionPayments([
            'project_id' => static::$projectId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionCurrencies()
    {
        $response = static::$xsollaClient->ListSubscriptionCurrencies([
            'project_id' => static::$projectId,
        ]);
        static::assertInternalType('array', $response);
    }
}
