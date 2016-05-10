<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Exception\API\UnprocessableEntityException;

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
                'en' => 'name',
            ),
            'description' => array(
                'en' => 'description',
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
                    array('id' => 24),
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
        $randomFutureTimestamp = mt_rand(time() + 60, 2147483647);
        $datetimeStart = \DateTime::createFromFormat('U', $randomFutureTimestamp, new \DateTimeZone('UTC'));
        $this->xsollaClient->SetPromotionPeriods(array(
            'promotion_id' => static::$promotionId,
            'request' => array(
                'periods' => array(
                    array(
                        'from' => $datetimeStart->format(\DateTime::ISO8601),
                        'to' => $datetimeStart->modify('+ 1 second')->format(\DateTime::ISO8601),
                    ),
                ),
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
                ),
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
    }

    /**
     * @depends testReviewPromotion
     */
    public function testTogglePromotion()
    {
        try {
            $this->xsollaClient->TogglePromotion(array(
                'promotion_id' => static::$promotionId,
            ));
        } catch (UnprocessableEntityException $e) {
            if (false === strpos($e->getMessage(), 'The promotion is not ready for launch')) {
                throw $e;
            } else {
                static::markTestIncomplete('The promotion is not ready for launch');
            }
        }
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
