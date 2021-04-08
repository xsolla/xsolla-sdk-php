<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class UserAttributesTest extends AbstractAPITest
{
    protected static $attributeId;

    protected $userAttribute;

    public function setUp(): void
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
        static::assertIsArray($response);
    }

    /**
     * @depends testGetUserAttribute
     */
    public function testUpdateUserAttribute()
    {
        static::$xsollaClient->UpdateUserAttribute([
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
            'request' => $this->userAttribute,
        ]);
        static::assertTrue(true);
    }

    /**
     * @depends testUpdateUserAttribute
     */
    public function testListUserAttributes()
    {
        $response = static::$xsollaClient->ListUserAttributes([
            'project_id' => static::$projectId,
        ]);
        static::assertIsArray($response);
    }

    /**
     * @depends testListUserAttributes
     */
    public function testDeleteUserAttribute()
    {
        static::$xsollaClient->DeleteUserAttribute([
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
        ]);
        static::assertTrue(true);
    }
}
