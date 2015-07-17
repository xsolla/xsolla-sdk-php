<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\Exception\API\UnprocessableEntityException;

/**
 * @group api
 */
class CouponsTest extends AbstractAPITest
{
    protected $code = '1wpb1igjBig0g';

    protected $expectedCouponData = array (
        'coupon_id' => 20886988,
        'project_id' => 15861,
        'coupon_code' => '1wpb1igjBig0g',
        'campaign_code' => 'xsolla-sdk-php',
        'virtual_currency_amount' => 1,
        'is_active' => 1,
        'redeems_count_remain' => NULL,
        'redeems_count_for_user' => NULL,
        'expiration_date' => NULL,
        'virtual_items' => array (),
    );

    public function testGetCoupon()
    {
        $actualCouponData = $this->xsollaClient->GetCoupon(array(
            'project_id' => $this->projectId,
            'code' => $this->code,
        ));
        static::assertEquals($this->expectedCouponData, $actualCouponData);
    }

    public function testRedeemCoupon()
    {
        try {
            $actualCouponData = $this->xsollaClient->RedeemCoupon(array(
                'project_id' => $this->projectId,
                'code' => $this->code,
                'request' => array(
                    'user_id' => 1,
                ),
            ));
            static::assertEquals($this->expectedCouponData, $actualCouponData);
        } catch (UnprocessableEntityException $e) {
            if ('You have used too much of coupons. Try again later' === $e->getApiErrorMessage()) {
                static::markTestSkipped($e->getApiErrorMessage());
            } else {
                throw $e;
            }
        }
    }
}