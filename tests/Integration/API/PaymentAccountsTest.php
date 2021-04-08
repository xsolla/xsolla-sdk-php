<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PaymentAccountsTest extends AbstractAPITest
{
    public function testListPaymentAccounts()
    {
        $response = static::$xsollaClient->ListPaymentAccounts([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ]);
        static::assertIsArray($response);
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
