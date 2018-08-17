<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Response\UserResponse;
use Xsolla\SDK\Webhook\User;

/**
 * @group unit
 */
class UserSearchResponseTest extends TestCase
{
    public function testUserIdHasInvalidType()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('User id should be non-empty string. stdClass given');

        $user = new User();
        new UserResponse($user->setId(new \stdClass()));
    }

    public function testUserIdIsEmptyString()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('User id should be non-empty string. Empty string given');

        $user = new User();
        new UserResponse($user->setId(''));
    }

    public function testUserIdIsNull()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('User id should be non-empty string. NULL given');

        new UserResponse(new User());
    }

    public function testShortResponseFormat()
    {
        $user = new User();
        $response = new UserResponse($user->setId('user_id'));

        $this->assertJsonStringEqualsJsonString('{"user":{"id":"user_id"}}', $response->getSymfonyResponse()->getContent());
    }

    public function testFullResponseFormat()
    {
        $user = new User();
        $user->setId('user_id');
        $user->setEmail('user_email');
        $user->setPhone('user_phone');
        $user->setName('user_name');
        $user->setPublicId('user_public_id');

        $response = new UserResponse($user);

        $this->assertJsonStringEqualsJsonString(
            '{"user":{"id":"user_id","email":"user_email","phone":"user_phone","name":"user_name","public_id":"user_public_id"}}',
            $response->getSymfonyResponse()->getContent()
        );
    }
}
