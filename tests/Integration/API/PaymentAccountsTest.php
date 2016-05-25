<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PaymentAccountsTest extends AbstractAPITest
{
    protected static $userId;

    public function setUp()
    {
        parent::setUp();
        if (!static::$userId) {
            static::$userId = 'Game User';
        }
    }

    public function testListPaymentAccounts()
    {
        $response = $this->xsollaClient->ListPaymentAccounts(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testChargePaymentAccount()
    {
        static::markTestIncomplete('TODO: 404');
    }

    public function testDeletePaymentAccount()
    {
        static::markTestIncomplete('TODO: 404');
    }
}
