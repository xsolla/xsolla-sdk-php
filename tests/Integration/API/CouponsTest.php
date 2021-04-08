<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\Exception\API\AccessDeniedException;

/**
 * @group api
 */
class CouponsTest extends AbstractAPITest
{
    public function testCreateCoupon()
    {
        static::$xsollaClient->CreateCoupon([
            'campaign_id' => (int) getenv('CAMPAIGN_ID'),
            'request' => [
                'coupon_code' => uniqid('sdk_coupon_', false),
            ],
        ]);
        static::assertTrue(true);
    }

    public function testWrongCreateCoupon()
    {
        static::expectException(AccessDeniedException::class);
        static::$xsollaClient->CreateCoupon([
            'campaign_id' => (int) 2222,
            'request' => [
                'coupon_code' => uniqid('sdk_coupon_', false),
            ],
        ]);
    }

    public function testGetCoupon()
    {
        $actualCouponData = static::$xsollaClient->GetCoupon([
            'project_id' => static::$projectId,
            'code' => getenv('COUPON_CODE'),
        ]);
        static::assertIsArray($actualCouponData);
    }

    public function testRedeemCoupon()
    {
        $actualCouponData = static::$xsollaClient->RedeemCoupon([
            'project_id' => static::$projectId,
            'code' => getenv('COUPON_CODE'),
            'request' => [
                'user_id' => static::$userId,
            ],
        ]);
        static::assertIsArray($actualCouponData);
    }
}
