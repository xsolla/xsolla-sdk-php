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
        $this->userAttribute = array(
            'key' => uniqid('user_attribute_', false),
            'name' => array(
                'en' => 'name',
            ),
            'type' => 'string',
        );
    }

    public function testCreateUserAttribute()
    {
        $response = static::$xsollaClient->CreateUserAttribute(array(
            'project_id' => static::$projectId,
            'request' => $this->userAttribute,
        ));
        static::assertArrayHasKey('id', $response);
        static::$attributeId = (int) $response['id'];
    }

    /**
     * @depends testCreateUserAttribute
     */
    public function testGetUserAttribute()
    {
        $response = static::$xsollaClient->GetUserAttribute(array(
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetUserAttribute
     */
    public function testUpdateUserAttribute()
    {
        static::$xsollaClient->UpdateUserAttribute(array(
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
            'request' => $this->userAttribute,
        ));
    }

    /**
     * @depends testUpdateUserAttribute
     */
    public function testListUserAttributes()
    {
        $response = static::$xsollaClient->ListUserAttributes(array(
            'project_id' => static::$projectId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListUserAttributes
     */
    public function testDeleteUserAttribute()
    {
        static::$xsollaClient->DeleteUserAttribute(array(
            'project_id' => static::$projectId,
            'user_attribute_id' => static::$attributeId,
        ));
    }
}
