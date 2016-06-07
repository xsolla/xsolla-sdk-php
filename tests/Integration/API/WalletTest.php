<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class WalletTest extends AbstractAPITest
{
    protected static $virtualItemId;
    protected static $virtualItemSku;

    public function testCreateWalletUser()
    {
        static::markTestIncomplete('Delete user API method not implemented yet. We should not create new users infinitely.');
    }

    public function testGetWalletUser()
    {
        $response = static::$xsollaClient->GetWalletUser(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testUpdateWalletUser()
    {
        static::$xsollaClient->UpdateWalletUser(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => array(
                'enabled' => true,
            ),
        ));
    }

    public function testListWalletUsers()
    {
        $response = static::$xsollaClient->ListWalletUsers(array(
            'project_id' => static::$projectId,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListWalletUserOperations()
    {
        $response = static::$xsollaClient->ListWalletUserOperations(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'datetime_from' => '2015-01-01T00:00:00 UTC',
            'datetime_to' => '2016-01-01T00:00:00 UTC',
        ));
        static::assertInternalType('array', $response);
    }

    public function testRechargeWalletUserBalance()
    {
        $response = static::$xsollaClient->RechargeWalletUserBalance(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => array(
                'amount' => 10,
                'comment' => 'Comment',
            ),
        ));
        static::assertArrayHasKey('amount', $response);
    }

    public function testAddVirtualItemToWalletUser()
    {
        static::$virtualItemSku = uniqid('virtual_item_', false);
        $virtualItemTemplate = $this->generateVirtualItemTemplate(static::$virtualItemSku);
        $virtualItem = static::$xsollaClient->CreateVirtualItem(array(
            'project_id' => static::$projectId,
            'request' => $virtualItemTemplate,
        ));
        static::$virtualItemId = $virtualItem['item_id'];

        static::$xsollaClient->AddVirtualItemToWalletUser(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => array(
                'virtual_items' => array(
                    array(
                        'virtual_item' => array(
                            'sku' => static::$virtualItemSku,
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
        $response = static::$xsollaClient->ListWalletUserVirtualItems(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testAddVirtualItemToWalletUser
     */
    public function testDeleteVirtualItemFromWalletUser()
    {
        static::$xsollaClient->DeleteVirtualItemFromWalletUser(array(
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => array(
                'virtual_items' => array(
                    array(
                        'virtual_item' => array(
                            'sku' => static::$virtualItemSku,
                        ),
                        'amount' => 2,
                    ),
                ),
            ),
        ));
        static::$xsollaClient->DeleteVirtualItem(array(
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ));
    }
}
