<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Guzzle\Http\Exception\BadResponseException;
use Xsolla\SDK\Exception\API\XsollaAPIException;

/**
 * @group api
 */
class VirtualItemsTest extends AbstractAPITest
{
    protected static $virtualItemSku;

    protected static $virtualItemId;

    protected static $virtualItemsGroupId;

    protected static $virtualItem;

    protected $virtualItemsGroup;

    public function setUp()
    {
        parent::setUp();
        if (!static::$virtualItemSku) {
            static::$virtualItemSku = uniqid('virtual_item_');
            static::$virtualItem = array(
                'sku' => static::$virtualItemSku,
                'name' => array(
                    'en' => 'Virtual Item',
                ),
                'description' => array(
                    'en' => 'Virtual Item Description',
                ),
                'prices' => array(
                    'USD' => 1,
                ),
                'default_currency' => 'USD',
                'enabled' => true,
                'disposable' => false,
                'item_type' => 'Consumable',
            );
        }
        $this->virtualItemsGroup = array(
            'name' => array(
                'en' => 'Virtual Item Group',
            ),
            'description' => array(
                'en' => 'Virtual Item Group Description',
            ),
            'enabled' => true,
        );
    }

    public function testListVirtualItemsGroups()
    {
        $response = $this->xsollaClient->ListVirtualItemsGroups(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListVirtualItems()
    {
        try {
            $response = $this->xsollaClient->ListVirtualItems(array(
                'project_id' => $this->projectId,
            ));
            static::assertInternalType('array', $response);
        } catch (XsollaAPIException $e) {
            if ($e->getPrevious() instanceof BadResponseException and 500 == $e->getPrevious()->getResponse()->getStatusCode()) {
                static::markTestSkipped('TODO: random 500 responses in test merchant account');
            } else {
                throw $e;
            }
        }
    }

    public function testCreateVirtualItemsGroup()
    {
        $response = $this->xsollaClient->CreateVirtualItemsGroup(array(
            'project_id' => $this->projectId,
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
        $response = $this->xsollaClient->GetVirtualItemsGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetVirtualItemsGroup
     */
    public function testUpdateVirtualItemsGroup()
    {
        $this->xsollaClient->UpdateVirtualItemsGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
            'request' => $this->virtualItemsGroup,
        ));
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testCreateVirtualItem()
    {
        $response = $this->xsollaClient->CreateVirtualItem(array(
            'project_id' => $this->projectId,
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
        $response = $this->xsollaClient->GetVirtualItem(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetVirtualItem
     */
    public function testUpdateVirtualItem()
    {
        $this->xsollaClient->UpdateVirtualItem(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId,
            'request' => static::$virtualItem,
        ));
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testUpdateVirtualItemOrderInGroup()
    {
        $this->xsollaClient->UpdateVirtualItemOrderInGroup(array(
            'project_id' => $this->projectId,
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
        $this->xsollaClient->DeleteVirtualItem(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId,
        ));
    }

    /**
     * @depends testDeleteVirtualItem
     */
    public function testDeleteVirtualItemsGroup()
    {
        $this->xsollaClient->DeleteVirtualItemsGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
        ));
    }
}
