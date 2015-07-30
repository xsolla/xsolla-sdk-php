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
                'comment' => 'Comment',
            ),
        ));
        static::assertArrayHasKey('amount', $response);
    }

    /**
     * @depends testCreateWalletUser
     */
    public function testAddVirtualItemToWalletUser()
    {
        $this->xsollaClient->AddVirtualItemToWalletUser(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'request' => array(
                'virtual_items' => array(
                    array(
                        'virtual_item' => array(
                            'sku' => '1468', // https://merchant.xsolla.com/22174/projects/15861/items/15435
                        ),
                        'amount' => 2,
                    ),
                ),
            ),
        ));
    }

    /**
     * @depends testAddVirtualItemToWalletUser
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

    /**
     * @depends testListWalletUserVirtualItems
     */
    public function testDeleteVirtualItemFromWalletUser()
    {
        $this->xsollaClient->DeleteVirtualItemFromWalletUser(array(
            'project_id' => $this->projectId,
            'user_id' => static::$userId,
            'request' => array(
                'virtual_items' => array(
                    array(
                        'virtual_item' => array(
                            'sku' => '1468',
                        ),
                        'amount' => 2,
                    ),
                ),
            ),
        ));
    }
}
