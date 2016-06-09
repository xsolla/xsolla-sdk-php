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

    protected $virtualItemsGroup = array(
        'name' => array(
            'en' => 'Virtual Item Group',
        ),
        'description' => array(
            'en' => 'Virtual Item Group Description',
        ),
        'enabled' => true,
    );

    public function setUp()
    {
        parent::setUp();
        if (!static::$virtualItemSku) {
            static::$virtualItemSku = uniqid('virtual_item_', false);
            static::$virtualItem = $this->generateVirtualItemTemplate(static::$virtualItemSku);
        }
    }

    public function testListVirtualItemsGroups()
    {
        $response = static::$xsollaClient->ListVirtualItemsGroups(array(
            'project_id' => static::$projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListVirtualItems()
    {
        $response = static::$xsollaClient->ListVirtualItems(array(
            'project_id' => static::$projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testCreateVirtualItemsGroup()
    {
        $response = static::$xsollaClient->CreateVirtualItemsGroup(array(
            'project_id' => static::$projectId,
            'request' => $this->virtualItemsGroup,
        ));
        static::assertArrayHasKey('group_id', $response);
        static::$virtualItemsGroupId = $response['group_id'];
        static::$virtualItem['groups'] = array(static::$virtualItemsGroupId);
    }

    /**
     * @depends testCreateVirtualItemsGroup
     */
    public function testGetVirtualItemsGroup()
    {
        $response = static::$xsollaClient->GetVirtualItemsGroup(array(
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetVirtualItemsGroup
     */
    public function testUpdateVirtualItemsGroup()
    {
        static::$xsollaClient->UpdateVirtualItemsGroup(array(
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
            'request' => $this->virtualItemsGroup,
        ));
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testCreateVirtualItem()
    {
        $response = static::$xsollaClient->CreateVirtualItem(array(
            'project_id' => static::$projectId,
            'request' => static::$virtualItem,
        ));
        static::assertArrayHasKey('item_id', $response);
        static::$virtualItemId = $response['item_id'];
    }

    /**
     * @depends testCreateVirtualItem
     */
    public function testGetVirtualItem()
    {
        $response = static::$xsollaClient->GetVirtualItem(array(
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetVirtualItem
     */
    public function testUpdateVirtualItem()
    {
        static::$xsollaClient->UpdateVirtualItem(array(
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
            'request' => static::$virtualItem,
        ));
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testUpdateVirtualItemOrderInGroup()
    {
        static::$xsollaClient->UpdateVirtualItemOrderInGroup(array(
            'project_id' => static::$projectId,
            'request' => array(
                'group_id' => static::$virtualItemsGroupId,
                'virtual_items' => array(static::$virtualItemSku),
            ),
        ));
    }

    /**
     * @depends testUpdateVirtualItemOrderInGroup
     */
    public function testDeleteVirtualItem()
    {
        static::$xsollaClient->DeleteVirtualItem(array(
            'project_id' => static::$projectId,
            'item_id' => static::$virtualItemId,
        ));
    }

    /**
     * @depends testDeleteVirtualItem
     */
    public function testDeleteVirtualItemsGroup()
    {
        static::$xsollaClient->DeleteVirtualItemsGroup(array(
            'project_id' => static::$projectId,
            'group_id' => static::$virtualItemsGroupId,
        ));
    }
}
