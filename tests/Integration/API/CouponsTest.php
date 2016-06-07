<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class CouponsTest extends AbstractAPITest
{
    public function testGetCoupon()
    {
        $actualCouponData = static::$xsollaClient->GetCoupon(array(
            'project_id' => static::$projectId,
            'code' => getenv('COUPON_CODE'),
        ));
        static::assertInternalType('array', $actualCouponData);
    }

    public function testRedeemCoupon()
    {
        $actualCouponData = static::$xsollaClient->RedeemCoupon(array(
            'project_id' => static::$projectId,
            'code' => getenv('COUPON_CODE'),
            'request' => array(
                'user_id' => static::$userId,
            ),
        ));
        static::assertInternalType('array', $actualCouponData);
    }
}
