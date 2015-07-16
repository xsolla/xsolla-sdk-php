<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class VirtualItemsTest extends AbstractAPITest
{
    public function testCreateVirtualItem()
    {
        static::markTestSkipped();
    }

    public function testGetVirtualItem()
    {
        static::markTestSkipped();
    }

    public function testUpdateVirtualItem()
    {
        static::markTestSkipped();
    }

    public function testDeleteVirtualItem()
    {
        static::markTestSkipped();
    }

    public function testListVirtualItems()
    {
        $response = $this->xsollaClient->ListVirtualItems(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testUpdateVirtualItemImage()
    {
        static::markTestSkipped();
    }

    public function testDeleteVirtualItemImage()
    {
        static::markTestSkipped();
    }

    public function testCreateVirtualItemsGroup()
    {
        static::markTestSkipped();
    }

    public function testGetVirtualItemsGroup()
    {
        static::markTestSkipped();
    }

    public function testUpdateVirtualItemsGroup()
    {
        static::markTestSkipped();
    }

    public function testDeleteVirtualItemsGroup()
    {
        static::markTestSkipped();
    }

    public function testListVirtualItemsGroups()
    {
        $response = $this->xsollaClient->ListVirtualItemsGroups(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testAddVirtualItemToGroup()
    {
        static::markTestSkipped();
    }

    public function testDeleteVirtualItemFromGroup()
    {
        static::markTestSkipped();
    }

    public function testUpdateVirtualItemsInGroup()
    {
        static::markTestSkipped();
    }

    public function testUpdateVirtualItemOrderInGroup()
    {
        static::markTestSkipped();
    }
}