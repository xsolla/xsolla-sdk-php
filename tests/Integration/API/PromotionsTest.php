<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\API\XsollaClient;

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
        $this->promotion = array(
            'technical_name' => uniqid('promotion_'),
            'name' => array(
                'en' => 'name'
            ),
            'description' => array(
                'en' => 'description'
            ),
            'project_id' => $this->projectId,
        );
    }

    public function testListPromotions()
    {
        $response = $this->xsollaClient->ListPromotions();
        static::assertInternalType('array', $response);
    }

    public function testCreatePromotion()
    {
        $response = $this->xsollaClient->CreatePromotion(array(
            'request' => $this->promotion,
        ));
        static::assertArrayHasKey('id', $response);
        static::$promotionId = $response['id'];
    }

    /**
     * @depends testCreatePromotion
     */
    public function testGetPromotion()
    {
        $response = $this->xsollaClient->GetPromotion(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotion
     */
    public function testUpdatePromotion()
    {
        $this->xsollaClient->UpdatePromotion(array(
            'promotion_id' => static::$promotionId,
            'request' => $this->promotion,
        ));
    }

    /**
     * @depends testUpdatePromotion
     */
    public function testSetPromotionSubject()
    {
        $this->xsollaClient->SetPromotionSubject(array(
            'promotion_id' => static::$promotionId,
            'request' => array(
                'purchase' => false,
                'items' => null,
                'packages' => array(1),
            ),
        ));
    }

    /**
     * @depends testSetPromotionSubject
     */
    public function testGetPromotionSubject()
    {
        $response = $this->xsollaClient->GetPromotionSubject(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionSubject
     */
    public function testSetPromotionPaymentSystems()
    {
        $this->xsollaClient->SetPromotionPaymentSystems(array(
            'promotion_id' => static::$promotionId,
            'request' => array(
                'payment_systems' => array(
                    array('id' => 2682),
                ),
            ),
        ));
    }

    /**
     * @depends testSetPromotionPaymentSystems
     */
    public function testGetPromotionPaymentSystems()
    {
        $response = $this->xsollaClient->GetPromotionPaymentSystems(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionPaymentSystems
     */
    public function testSetPromotionPeriods()
    {
        $dateTime = new \DateTime('next month');
        $this->xsollaClient->SetPromotionPeriods(array(
            'promotion_id' => static::$promotionId,
            'request' => array(
                'periods' => array(
                    array(
                        'from' => $dateTime->format(\DateTime::ISO8601),
                        'to' => $dateTime->modify('+ 1 month')->format(\DateTime::ISO8601),
                    ),
                )
            ),
        ));
    }

    /**
     * @depends testSetPromotionPeriods
     */
    public function testGetPromotionPeriods()
    {
        $response = $this->xsollaClient->GetPromotionPeriods(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionPeriods
     */
    public function testSetPromotionRewards()
    {
        $this->xsollaClient->SetPromotionRewards(array(
            'promotion_id' => static::$promotionId,
            'request' => array(
                'purchase' => array(
                    'discount_percent' => 10,
                )
            ),
        ));
    }

    /**
     * @depends testSetPromotionRewards
     */
    public function testGetPromotionRewards()
    {
        $response = $this->xsollaClient->GetPromotionRewards(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetPromotionRewards
     */
    public function testReviewPromotion()
    {
        $response = $this->xsollaClient->ReviewPromotion(array(
            'promotion_id' => static::$promotionId,
        ));
        static::assertInternalType('array', $response);
        if (array() !== $response) {
            echo PHP_EOL.XsollaClient::jsonEncode($response).PHP_EOL;
        }
    }

    /**
     * @depends testReviewPromotion
     */
    public function testTogglePromotion()
    {
        $this->xsollaClient->TogglePromotion(array(
            'promotion_id' => static::$promotionId,
        ));
    }

    /**
     * @depends testTogglePromotion
     */
    public function testDeletePromotion()
    {
        $this->xsollaClient->DeletePromotion(array(
            'promotion_id' => static::$promotionId,
        ));
    }
}