<?php

namespace Xsolla\SDK\Tests\Integration\API;

class UserAttributesTest extends AbstractAPITest
{
    public function testCreateUserAttribute()
    {
        static::markTestSkipped();
    }

    public function testGetUserAttribute()
    {
        static::markTestSkipped();
    }

    public function testUpdateUserAttribute()
    {
        static::markTestSkipped();
    }

    public function testListUserAttributes()
    {
        $response = $this->xsollaClient->ListUserAttributes(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    public function testDeleteUserAttribute()
    {
        static::markTestSkipped();
    }
}