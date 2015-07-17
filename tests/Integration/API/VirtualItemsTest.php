<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class VirtualItemsTest extends AbstractAPITest
{
    protected static $virtualItemId;

    protected static $virtualItemsGroupId;

    protected $virtualItem;

    protected $virtualItemsGroup;

    public function setUp()
    {
        parent::setUp();
        $this->virtualItem = array(
            'sku' => uniqid('virtual_item_'),
            'name' => array(
                'en' => 'Virtual Item'
            ),
            'description' => array(
                'en' => 'Virtual Item Description'
            ),
            'prices' => array(
                'USD' => 1,
            ),
            'default_currency' => 'USD',
            'enabled' => true,
            'disposable' => false,
            'item_type' => 'Consumable',
        );
        $this->virtualItemsGroup = array(
            'name' => array(
                'en' => 'Virtual Item Group'
            ),
            'description' => array(
                'en' => 'Virtual Item Group Description'
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
        $response = $this->xsollaClient->ListVirtualItems(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testCreateVirtualItem()
    {
        $response = $this->xsollaClient->CreateVirtualItem(array(
            'project_id' => $this->projectId,
            'request' => $this->virtualItem
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
        $response = $this->xsollaClient->CreateVirtualItem(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId,
            'request' => $this->virtualItem,
        ));
        static::assertArrayHasKey('item_id', $response);
    }

    /**
     * @depends testUpdateVirtualItem
     */
    public function testUpdateVirtualItemImage()
    {
        $url = $this->xsollaClient->UpdateVirtualItemImage(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId,
            'request' => array(
                'data' => 'iVBORw0KGgoAAAANSUhEUgAAACoAAAAoCAQAAAAiAqDbAAABl0lEQVR4Ae3VsUtVYRjA4VeUa4pRbVENBUoQlEFF\/0CiSEVbwYVoKLBwaYmChiiQmlqagqChOxeCQ0gX27K2xmpKscEhcrlxb54niAOHkvvdzh2c7vlNh+\/wDC+c94tteQwZEHkjQrphi6ri77Z+VDevIoRRK65Lk3VkJtLoPfjDHraKzJG25Ig6qOlPoxXzYNE6Nl1NkMvgRU4m0IJlU1W0rV8NLNvVGQ0nZOCjYZFknxZsGj1qHUBdmu3zLGeHUuh4PsvLajqzB3wGD0UKvYaWqnxmVh1MkF\/Anc4znXFePjOPjYq2nfQDt0UaLdtpN0V5tHQ9tIcW7bGza2jQGVdMGPwXfeJRl+SUb4A1kwrUMb80jXX1XzUB0HSqOFoCC8qjb\/DdpB2mbOB1fuAigOmSZJ8W7udvc\/iZ34q+4q33+KRSCh2QKdbfXbRCCA\/AWZfALVGqD1gxJvIb+F0IhzQAwIa9pdBzILMmA9MhvAQA8FyU6oYGoGFGhHB8S+OiZPvNmjNrX2+h\/Ce6G1zwCks9tIduO\/obgMsmlpJdCMsAAAAASUVORK5CYII="'
            ),
        ));
        static::assertInternalType('string', filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));
    }

    /**
     * @depends testUpdateVirtualItemImage
     */
    public function testDeleteVirtualItemImage()
    {
        $this->xsollaClient->DeleteVirtualItemImage(array(
            'project_id' => $this->projectId,
            'item_id' => static::$virtualItemId
        ));
    }

    /**
     * @depends testDeleteVirtualItemImage
     */
    public function testCreateVirtualItemsGroup()
    {
        $response = $this->xsollaClient->CreateVirtualItemsGroup(array(
            'project_id' => $this->projectId,
            'request' => $this->virtualItemsGroup
        ));
        static::assertArrayHasKey('group_id', $response);
        static::$virtualItemsGroupId = $response['group_id'];
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
            'request' => $this->virtualItemsGroup
        ));
    }

    /**
     * @depends testUpdateVirtualItemsGroup
     */
    public function testAddVirtualItemToGroup()
    {
        return;//TODO
        $response = $this->xsollaClient->AddVirtualItemToGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
            'item_id' => static::$virtualItemId,
            'request' => array(
                'order' => 1,
            ),
        ));
        static::assertEquals(array(), $response);
    }

    /**
     * @depends testAddVirtualItemToGroup
     */
    public function testUpdateVirtualItemsInGroup()
    {
        return;//TODO
        $response = $this->xsollaClient->UpdateVirtualItemsInGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
            'request' => array('items' => array(self::$virtualItemId)),
        ));
        static::assertEquals(array(), $response);
    }

    /**
     * @depends testUpdateVirtualItemsInGroup
     */
    public function testUpdateVirtualItemOrderInGroup()
    {
        return;//TODO
        $response = $this->xsollaClient->UpdateVirtualItemOrderInGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
            'item_id' => static::$virtualItemId,
            'request' => array(
                'order' => 1,
            ),
        ));
        static::assertEquals(array(), $response);
    }

    /**
     * @depends testUpdateVirtualItemOrderInGroup
     */
    public function testDeleteVirtualItemFromGroup()
    {
        return;//TODO
        $response = $this->xsollaClient->DeleteVirtualItemFromGroup(array(
            'project_id' => $this->projectId,
            'group_id' => static::$virtualItemsGroupId,
            'item_id' => static::$virtualItemId,
        ));
        static::assertEquals(array(), $response);
    }

    /**
     * @depends testDeleteVirtualItemFromGroup
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