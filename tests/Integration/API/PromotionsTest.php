<?php

namespace Xsolla\SDK\Tests\Integration\API;

class PromotionsTest extends AbstractAPITest
{
    public function testCreatePromotion()
    {
        static::markTestSkipped();
    }

    public function testGetPromotion()
    {
        static::markTestSkipped();
    }

    public function testUpdatePromotion()
    {
        static::markTestSkipped();
    }

    public function testReviewPromotion()
    {
        static::markTestSkipped();
    }

    public function testTogglePromotion()
    {
        static::markTestSkipped();
    }

    public function testDeletePromotion()
    {
        static::markTestSkipped();
    }

    public function testListPromotions()
    {
        $response = $this->xsollaClient->ListPromotions();
        static::assertInternalType('array', $response);
    }

    public function testGetPromotionSubject()
    {
        static::markTestSkipped();
    }

    public function testSetPromotionSubject()
    {
        static::markTestSkipped();
    }

    public function testGetPromotionPaymentSystems()
    {
        static::markTestSkipped();
    }

    public function testSetPromotionPaymentSystems()
    {
        static::markTestSkipped();
    }

    public function testGetPromotionPeriods()
    {
        static::markTestSkipped();
    }

    public function testSetPromotionPeriods()
    {
        static::markTestSkipped();
    }

    public function testGetPromotionRewards()
    {
        static::markTestSkipped();
    }

    public function testSetPromotionRewards()
    {
        static::markTestSkipped();
    }
}