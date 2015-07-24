<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\Exception\API\UnprocessableEntityException;

/**
 * @group api
 */
class CouponsTest extends AbstractAPITest
{
    protected $code = '1wpb1igjBig0g';

    public function testGetCoupon()
    {
        $actualCouponData = $this->xsollaClient->GetCoupon(array(
            'project_id' => $this->projectId,
            'code' => $this->code,
        ));
        static::assertInternalType('array', $actualCouponData);
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
            static::assertInternalType('array', $actualCouponData);
        } catch (UnprocessableEntityException $e) {
            static::markTestSkipped($e->getApiErrorMessage());
        }
    }
}