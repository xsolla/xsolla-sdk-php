<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\Exception\API\UnprocessableEntityException;

/**
 * @group api
 */
class SubscriptionsTest extends AbstractAPITest
{
    protected static $planId;

    protected static $productId;

    protected $plan;

    protected $product;

    public function setUp()
    {
        parent::setUp();
        $this->plan = array(
            'name' => array(
                'en' => 'Subscription Plan Name',
            ),
            'group_id' => 'group_id',
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
        );
        $this->product = array(
            'name' => 'Product Name',
            'group_id' => 'group_id',
        );
    }

    public function testCreateSubscriptionPlan()
    {
        try {
            $response = $this->xsollaClient->CreateSubscriptionPlan(array(
                'project_id' => $this->projectId,
                'request' => $this->plan,
            ));
            static::assertArrayHasKey('plan_id', $response);
            static::$planId = $response['plan_id'];
        } catch (UnprocessableEntityException $e) {
            if (false === strpos($e->getMessage(), 'External id is already exist')) {
                throw $e;
            } else {
                static::markTestSkipped('External id is already exist');
            }
        }
    }

    /**
     * @depends testCreateSubscriptionPlan
     */
    public function testListSubscriptionPlans()
    {
        $response = $this->xsollaClient->ListSubscriptionPlans(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListSubscriptionPlans
     */
    public function testUpdateSubscriptionPlan()
    {
        $response = $this->xsollaClient->UpdateSubscriptionPlan(array(
            'project_id' => $this->projectId,
            'plan_id' => static::$planId,
            'request' => $this->plan,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testUpdateSubscriptionPlan
     */
    public function testDisableSubscriptionPlan()
    {
        $this->xsollaClient->DisableSubscriptionPlan(array(
            'project_id' => $this->projectId,
            'plan_id' => static::$planId,
        ));
    }

    /**
     * @depends testDisableSubscriptionPlan
     */
    public function testEnableSubscriptionPlan()
    {
        $this->xsollaClient->EnableSubscriptionPlan(array(
            'project_id' => $this->projectId,
            'plan_id' => static::$planId,
        ));
    }

    /**
     * @depends testEnableSubscriptionPlan
     */
    public function testDeleteSubscriptionPlan()
    {
        $this->xsollaClient->DeleteSubscriptionPlan(array(
            'project_id' => $this->projectId,
            'plan_id' => static::$planId,
        ));
    }

    /**
     * @depends testDeleteSubscriptionPlan
     */
    public function testCreateSubscriptionProduct()
    {
        $response = $this->xsollaClient->CreateSubscriptionProduct(array(
            'project_id' => $this->projectId,
            'request' => $this->product,
        ));
        static::assertArrayHasKey('product_id', $response);
        static::$productId = $response['product_id'];
    }

    /**
     * @depends testCreateSubscriptionProduct
     */
    public function testUpdateSubscriptionProduct()
    {
        $response = $this->xsollaClient->UpdateSubscriptionProduct(array(
            'project_id' => $this->projectId,
            'product_id' => static::$productId,
            'request' => $this->product,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testUpdateSubscriptionProduct
     */
    public function testDeleteSubscriptionProduct()
    {
        $this->xsollaClient->DeleteSubscriptionProduct(array(
            'project_id' => $this->projectId,
            'product_id' => static::$productId,
        ));
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
        static::markTestSkipped('TODO: unit test');
    }

    public function testListSubscriptions()
    {
        $response = $this->xsollaClient->ListSubscriptions(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListUserSubscriptionPayments()
    {
        $response = $this->xsollaClient->ListUserSubscriptionPayments(array(
            'project_id' => $this->projectId,
            'user_id' => '1',
        ));
        static::assertInternalType('array', $response);
    }

    public function testListSubscriptionPayments()
    {
        $response = $this->xsollaClient->ListSubscriptionPayments(array(
            'project_id' => $this->projectId,
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
