<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PromotionsTest extends AbstractAPITest
{
    protected static $promotionId;

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
        static::$xsollaClient->UpdatePromotion([
            'promotion_id' => static::$promotionId,
            'request' => $this->promotion,
        ]);
    }

    /**
     * @depends testUpdatePromotion
     */
    public function testSetPromotionSubject()
    {
        static::$xsollaClient->SetPromotionSubject([
            'promotion_id' => static::$promotionId,
            'request' => [
                'purchase' => false,
                'items' => null,
                'packages' => [1],
            ],
        ]);
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
        static::$xsollaClient->SetPromotionPeriods([
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
        static::$xsollaClient->SetPromotionRewards([
            'promotion_id' => static::$promotionId,
            'request' => [
                'purchase' => [
                    'discount_percent' => 10,
                ],
            ],
        ]);
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
    public function testTogglePromotion()
    {
        static::$xsollaClient->TogglePromotion([
            'promotion_id' => static::$promotionId,
        ]);
    }

    /**
     * @depends testTogglePromotion
     */
    public function testDeletePromotion()
    {
        static::$xsollaClient->DeletePromotion([
            'promotion_id' => static::$promotionId,
        ]);
    }
}
