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
            'key' => uniqid('user_attribute_'),
            'name' => array(
                'en' => 'name',
            ),
            'type' => 'string',
        );
    }

    public function testCreateUserAttribute()
    {
        $response = $this->xsollaClient->CreateUserAttribute(array(
            'project_id' => $this->projectId,
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
        $response = $this->xsollaClient->GetUserAttribute(array(
            'project_id' => $this->projectId,
            'user_attribute_id' => static::$attributeId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testGetUserAttribute
     */
    public function testUpdateUserAttribute()
    {
        $this->xsollaClient->UpdateUserAttribute(array(
            'project_id' => $this->projectId,
            'user_attribute_id' => static::$attributeId,
            'request' => $this->userAttribute,
        ));
    }

    /**
     * @depends testUpdateUserAttribute
     */
    public function testListUserAttributes()
    {
        $response = $this->xsollaClient->ListUserAttributes(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testListUserAttributes
     */
    public function testDeleteUserAttribute()
    {
        $this->xsollaClient->DeleteUserAttribute(array(
            'project_id' => $this->projectId,
            'user_attribute_id' => static::$attributeId,
        ));
    }
}
