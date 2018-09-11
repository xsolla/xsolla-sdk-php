<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PromotionsTest extends AbstractAPITest
{
    protected static $promotionId;
    protected static $couponPromotionId;

    protected $promotion;

    public function setUp()
    {
        parent::setUp();
        $this->promotion = [
            'technical_name' => uniqid('promotion_', false),
            'name' => [
                'en' => 'name',
            ],
            'description' => [
                'en' => 'description',
            ],
            'project_id' => static::$projectId,
        ];
    }

    public function testListPromotions()
    {
        $response = static::$xsollaClient->ListPromotions();
        static::assertInternalType('array', $response);
    }

    public function testCreatePromotion()
    {
        $response = static::$xsollaClient->CreatePromotion([
            'request' => $this->promotion,
        ]);
        static::assertArrayHasKey('id', $response);
        static::$promotionId = $response['id'];
    }

    /**
     * @depends testCreatePromotion
     */
    public function testGetPromotion()
    {
        $response = static::$xsollaClient->GetPromotion([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotion
     */
    public function testUpdatePromotion()
    {
        $response = static::$xsollaClient->UpdatePromotion([
            'promotion_id' => static::$promotionId,
            'request' => $this->promotion,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testUpdatePromotion
     */
    public function testSetPromotionSubject()
    {
        $response = static::$xsollaClient->SetPromotionSubject([
            'promotion_id' => static::$promotionId,
            'request' => [
                'purchase' => false,
                'items' => null,
                'packages' => [1],
            ],
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testSetPromotionSubject
     */
    public function testGetPromotionSubject()
    {
        $response = static::$xsollaClient->GetPromotionSubject([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    public function testSetPromotionPaymentSystems()
    {
        static::markTestIncomplete('We haven\'t allowed payment systems for test project yet.');
    }

    /**
     * @depends testGetPromotionSubject
     */
    public function testGetPromotionPaymentSystems()
    {
        $response = static::$xsollaClient->GetPromotionPaymentSystems([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionPaymentSystems
     */
    public function testSetPromotionPeriods()
    {
        $randomFutureTimestamp = mt_rand(time() + 60, 2147483647);
        $datetimeStart = \DateTime::createFromFormat('U', $randomFutureTimestamp, new \DateTimeZone('UTC'));
        $response = static::$xsollaClient->SetPromotionPeriods([
            'promotion_id' => static::$promotionId,
            'request' => [
                'periods' => [
                    [
                        'from' => $datetimeStart->format(\DateTime::ISO8601),
                        'to' => $datetimeStart->modify('+ 1 second')->format(\DateTime::ISO8601),
                    ],
                ],
            ],
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testSetPromotionPeriods
     */
    public function testGetPromotionPeriods()
    {
        $response = static::$xsollaClient->GetPromotionPeriods([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionPeriods
     */
    public function testSetPromotionRewards()
    {
        $response = static::$xsollaClient->SetPromotionRewards([
            'promotion_id' => static::$promotionId,
            'request' => [
                'purchase' => [
                    'discount_percent' => 10,
                ],
            ],
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testSetPromotionRewards
     */
    public function testGetPromotionRewards()
    {
        $response = static::$xsollaClient->GetPromotionRewards([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionRewards
     */
    public function testReviewPromotion()
    {
        $response = static::$xsollaClient->ReviewPromotion([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testReviewPromotion
     */
    public function testCreateCouponPromotion()
    {
        $response = static::$xsollaClient->CreateCouponPromotion([
            'request' => [
                'campaign_code' => uniqid('xsolla_api_test_campaign_code_', false),
                'project_id' => self::$projectId,
                'campaign_names' => ['en' => 'xsolla_api_test_campaign_code'],
                'redeems_count_for_user' => 1,
                'campaign_redeems_count_for_user' => 1,
                'expiration_date' => (new \DateTime('+3day'))->format(DATE_RFC3339),
            ],
        ]);
        static::assertInternalType('array', $response);
        static::$couponPromotionId = $response['id'];
    }

    /**
     * @depends testCreateCouponPromotion
     */
    public function testGetCouponPromotions()
    {
        $response = static::$xsollaClient->ListCouponPromotions([
            'limit' => 20,
            'offset' => 0,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testCreateCouponPromotion
     */
    public function testUpdatePromotionCampaigns()
    {
        $response = static::$xsollaClient->UpdatePromotionCampaigns([
            'promotion_id' => static::$promotionId,
            'request' => [
                'campaigns' => [static::$couponPromotionId],
            ],
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testUpdatePromotionCampaigns
     */
    public function testTogglePromotion()
    {
        $response = static::$xsollaClient->TogglePromotion([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testUpdatePromotionCampaigns
     */
    public function testDeletePromotion()
    {
        $response = static::$xsollaClient->DeletePromotion([
            'promotion_id' => static::$promotionId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }
}
