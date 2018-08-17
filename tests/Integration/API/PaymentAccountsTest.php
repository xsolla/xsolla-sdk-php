<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PaymentAccountsTest extends AbstractAPITest
{
    public function testListPaymentAccounts()
    {
        $response = static::$xsollaClient->ListPaymentAccounts(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testChargePaymentAccount()
    {
        static::markTestIncomplete('We haven\'t test payment account yet.');
    }

    public function testDeletePaymentAccount()
    {
        static::markTestIncomplete('We haven\'t test payment account yet.');
    }
}
