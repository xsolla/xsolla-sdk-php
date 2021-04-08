<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class VirtualItemsTest extends AbstractAPITest
{
    protected static $virtualItemSku;

    protected static $virtualItemId;

    protected static $virtualItemsGroupId;

    protected static $virtualItem;

    protected $virtualItemsGroup = [
        'name' => [
            'en' => 'Virtual Item Group',
        ],
        'description' => [
            'en' => 'Virtual Item Group Description',
        ],
        'enabled' => true,
    ];

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$virtualItemSku) {
            static::$virtualItemSku = uniqid('virtual_item_', false);
            static::$virtualItem = $this->generateVirtualItemTemplate(static::$virtualItemSku);
        }
    }

    public function testListVirtualItemsGroups()
    {
        $response = static::$xsollaClient->ListVirtualItemsGroups([
            'project_id' => static::$projectId,
        ]);
        static::assertIsArray($response);
    }

    public function testListVirtualItems()
    {
        $response = static::$xsollaClient->ListVirtualItems([
            'project_id' => static::$projectId,
        ]);
        static::assertIsArray($response);
    }

    public function testListVirtualItemsWithParams()
    {
        $response = static::$xsollaClient->ListVirtualItems([
            'project_id' => static::$projectId,
            'offset' => 0,
            'limit' => 100,
            'has_price' => 'virtual_currency',
        ]);
        static::assertIsArray($response);
    }

    public function testCreateVirtualItemsGroup()
    {
        $response = static::$xsollaClient->CreateVirtualItemsGroup([
            'project_id' => static::$projectId,
            'request' => $this->virtualItemsGroup,
        ]);
        static::assertArrayHasKey('group_id', $response);
        static::$virtualItemsGroupId = $response['group_id'];
        static::$virtualItem['groups'] = [static::$virtualItemsGroupId];
    }

    /**
     * @depends testCreateVirtualItemsGroup
     */
    public function testGetVirtualItemsGroup()
    {
        $response = static::$xsollaClient->GetVirtualItemsGroup([
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
        ]);
        static::assertIsArray($response);
    }

    /**
     * @depends testGetVirtualItemsGroup
     */
    public function testUpdateVirtualItemsGroup()
    {
        static::$xsollaClient->UpdateVirtualItemsGroup([
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
            'request' => $this->virtualItemsGroup,
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testCreateVirtualItem()
    {
        $response = static::$xsollaClient->CreateVirtualItem([
            'project_id' => static::$projectId,
            'request' => static::$virtualItem,
        ]);
        static::assertArrayHasKey('item_id', $response);
        static::$virtualItemId = $response['item_id'];
    }

    /**
     * @depends testCreateVirtualItem
     */
    public function testGetVirtualItem()
    {
        $response = static::$xsollaClient->GetVirtualItem([
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ]);
        static::assertIsArray($response);
    }

    /**
     * @depends testGetVirtualItem
     */
    public function testUpdateVirtualItem()
    {
        static::$xsollaClient->UpdateVirtualItem([
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
            'request' => static::$virtualItem,
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testUpdateVirtualItemOrderInGroup()
    {
        static::$xsollaClient->UpdateVirtualItemOrderInGroup([
            'project_id' => static::$projectId,
            'request' => [
                'group_id' => static::$virtualItemsGroupId,
                'virtual_items' => [static::$virtualItemSku],
            ],
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testUpdateVirtualItemOrderInGroup
     */
    public function testDeleteVirtualItem()
    {
        static::$xsollaClient->DeleteVirtualItem([
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testDeleteVirtualItem
     */
    public function testDeleteVirtualItemsGroup()
    {
        static::$xsollaClient->DeleteVirtualItemsGroup([
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
        ]);
        static::assertTrue(true);
    }
}
