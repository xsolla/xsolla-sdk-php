<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class WalletTest extends AbstractAPITest
{
    protected static $userId;

    public function setUp()
    {
        parent::setUp();
        if (!static::$userId) {
            static::$userId = uniqid('wallet_user_');
        }
    }

    public function testCreateWalletUser()
    {
        $this->xsollaClient->CreateWalletUser(array(
            'project_id' => $this->projectId,
            'request' => array('user_id' => static::$userId),
        ));
    }

    /**
     * @depends testCreateWalletUser
     */
    public function testGetWalletUser()
    {
        $response = $this->xsollaClient->GetWalletUser(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetWalletUser
     */
    public function testUpdateWalletUser()
    {
        $this->xsollaClient->UpdateWalletUser(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'request' => array(
                'user_id' => static::$userId,//TODO
                'enabled' => true,
            ),
        ));
    }

    public function testListWalletUsers()
    {
        $response = $this->xsollaClient->ListWalletUsers(array(
            'project_id' => $this->projectId,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testUpdateWalletUser
     */
    public function testListWalletUserOperations()
    {
        $response = $this->xsollaClient->ListWalletUserOperations(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'datetime_from' => '2015-01-01T00:00:00 UTC',
            'datetime_to' => '2016-01-01T00:00:00 UTC',
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListWalletUserOperations
     */
    public function testRechargeWalletUserBalance()
    {
        $response = $this->xsollaClient->RechargeWalletUserBalance(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'request' => array(
                'amount' => 10,
                'comment' => 'Comment'
            ),
        ));
        static::assertArrayHasKey('amount', $response);
    }


    /**
     * @depends testRechargeWalletUserBalance
     */
    public function testWithdrawWalletUserBalance()
    {
        static::markTestSkipped();
        return; // TODO
        $response = $this->xsollaClient->WithdrawWalletUserBalance(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'request' => array(
                'amount' => 10,
                'comment' => 'Comment'
            ),
        ));
        static::assertArrayHasKey('amount', $response);
    }

    /**
     * @depends testCreateWalletUser
     */
    public function testListWalletUserVirtualItems()
    {
        $response = $this->xsollaClient->ListWalletUserVirtualItems(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }
}