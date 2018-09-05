<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class CouponsTest extends AbstractAPITest
{
    public function testCreateCoupon()
    {
        $response = static::$xsollaClient->CreateCoupon([
            'campaign_id' => (int) getenv('CAMPAIGN_ID'),
            'request' => [
                'coupon_code' => uniqid('sdk_coupon_', false),
            ],
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    public function testGetCoupon()
    {
        $actualCouponData = static::$xsollaClient->GetCoupon([
            'project_id' => static::$projectId,
            'code' => getenv('COUPON_CODE'),
        ]);
        static::assertInternalType('array', $actualCouponData);
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
        static::assertInternalType('array', $actualCouponData);
    }
}
