<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class UserAttributesTest extends AbstractAPITest
{
    protected static $attributeId;

    protected $userAttribute;

    public function setUp()
    {
        parent::setUp();
        $this->userAttribute = [
            'key' => uniqid('user_attribute_', false),
            'name' => [
                'en' => 'name',
            ],
            'type' => 'string',
        ];
    }

    public function testCreateUserAttribute()
    {
        $response = static::$xsollaClient->CreateUserAttribute([
            'project_id' => static::$projectId,
            'request' => $this->userAttribute,
        ]);
        static::assertArrayHasKey('id', $response);
        static::$attributeId = (int) $response['id'];
    }

    /**
     * @depends testCreateUserAttribute
     */
    public function testGetUserAttribute()
    {
        $response = static::$xsollaClient->GetUserAttribute([
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetUserAttribute
     */
    public function testUpdateUserAttribute()
    {
        $response = static::$xsollaClient->UpdateUserAttribute([
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
            'request' => $this->userAttribute,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }

    /**
     * @depends testUpdateUserAttribute
     */
    public function testListUserAttributes()
    {
        $response = static::$xsollaClient->ListUserAttributes([
            'project_id' => static::$projectId,
        ]);
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListUserAttributes
     */
    public function testDeleteUserAttribute()
    {
        $response = static::$xsollaClient->DeleteUserAttribute([
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
        ]);
        static::assertSame(204, $response->getStatusCode());
    }
}
