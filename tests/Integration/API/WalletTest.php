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
        $response = static::$xsollaClient->GetWalletUser([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
        ]);
        static::assertIsArray($response);
    }

    public function testUpdateWalletUser()
    {
        static::$xsollaClient->UpdateWalletUser([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => [
                'enabled' => true,
            ],
        ]);
        static::assertTrue(true);
    }

    public function testListWalletUsers()
    {
        $response = static::$xsollaClient->ListWalletUsers([
            'project_id' => static::$projectId,
            'limit' => 1,
            'offset' => 0,
        ]);
        static::assertIsArray($response);
    }

    public function testListWalletUsersWithParams()
    {
        $response = static::$xsollaClient->ListWalletUsers([
            'project_id' => static::$projectId,
            'limit' => 1,
            'offset' => 0,
            'user_requisites' => static::$userId,
        ]);
        static::assertIsArray($response);
    }

    public function testListWalletUserOperations()
    {
        $response = static::$xsollaClient->ListWalletUserOperations([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'datetime_from' => '2015-01-01T00:00:00Z',
            'datetime_to' => '2016-01-01T00:00:00Z',
        ]);
        static::assertIsArray($response);
    }

    public function testListWalletUserOperationsWithParams()
    {
        $response = static::$xsollaClient->ListWalletUserOperations([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'datetime_from' => '2015-01-01T00:00:00Z',
            'datetime_to' => '2016-01-01T00:00:00Z',
            'transaction_type' => 'payment',
        ]);
        static::assertIsArray($response);
    }

    public function testRechargeWalletUserBalance()
    {
        $response = static::$xsollaClient->RechargeWalletUserBalance([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => [
                'amount' => 10,
                'comment' => 'Comment',
            ],
        ]);
        static::assertArrayHasKey('amount', $response);
    }

    public function testAddVirtualItemToWalletUser()
    {
        static::$virtualItemSku = uniqid('virtual_item_', false);
        $virtualItemTemplate = $this->generateVirtualItemTemplate(static::$virtualItemSku);
        $virtualItem = static::$xsollaClient->CreateVirtualItem([
            'project_id' => static::$projectId,
            'request' => $virtualItemTemplate,
        ]);
        static::$virtualItemId = $virtualItem['item_id'];

        static::$xsollaClient->AddVirtualItemToWalletUser([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => [
                'virtual_items' => [
                    [
                        'virtual_item' => [
                            'sku' => static::$virtualItemSku,
                        ],
                        'amount' => 2,
                    ],
                ],
            ],
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testAddVirtualItemToWalletUser
     */
    public function testListWalletUserVirtualItems()
    {
        $response = static::$xsollaClient->ListWalletUserVirtualItems([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'limit' => 1,
            'offset' => 0,
        ]);
        static::assertIsArray($response);
    }

    /**
     * @depends testAddVirtualItemToWalletUser
     */
    public function testDeleteVirtualItemFromWalletUser()
    {
        static::$xsollaClient->DeleteVirtualItemFromWalletUser([
            'project_id' => static::$projectId,
            'user_id' => static::$userId,
            'request' => [
                'virtual_items' => [
                    [
                        'virtual_item' => [
                            'sku' => static::$virtualItemSku,
                        ],
                        'amount' => 2,
                    ],
                ],
            ],
        ]);
        static::$xsollaClient->DeleteVirtualItem([
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ]);
        static::assertTrue(true);
    }
}
