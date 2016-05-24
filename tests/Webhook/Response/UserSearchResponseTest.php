<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Response\UserResponse;
use Xsolla\SDK\Webhook\User;

/**
 * @group unit
 */
class UserSearchResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testUserIdHasInvalidType()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'User id should be non-empty string. stdClass given'
        );
        $user = new User();
        new UserResponse($user->setId(new \stdClass()));
    }

    public function testUserIdIsEmptyString()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'User id should be non-empty string. Empty string given'
        );
        $user = new User();
        new UserResponse($user->setId(''));
    }

    public function testUserIdIsNull()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'User id should be non-empty string. NULL given'
        );
        new UserResponse(new User());
    }

    public function testShortResponseFormat()
    {
        $user = new User();
        $response = new UserResponse($user->setId('user_id'));
        $this->assertJsonStringEqualsJsonString(
            '{"user":{"id":"user_id"}}',
            $response->getSymfonyResponse()->getContent()
        );
    }

    public function testFullResponseFormat()
    {
        $user = new User();
        $response = new UserResponse(
            $user->setId('user_id')
                ->setEmail('user_email')
                ->setPhone('user_phone')
                ->setName('user_name')
                ->setPublicId('user_public_id')
        );
        $this->assertJsonStringEqualsJsonString(
            '{"user":{"id":"user_id","email":"user_email","phone":"user_phone","name":"user_name","public_id":"user_public_id"}}',
            $response->getSymfonyResponse()->getContent()
        );
    }
}
