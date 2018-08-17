<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\UserSearchMessage;

/**
 * @group unit
 */
class UserSearchMessageTest extends TestCase
{
    public function testUserPublicId()
    {
        $request = [
            'user' => [
                'public_id' => '1234567',
            ],
            'notification_type' => 'user_search',
        ];
        $message = new UserSearchMessage($request);
        static::assertSame($request['user'], $message->getUser());
        static::assertNull($message->getUserId());
        static::assertSame($request['user']['public_id'], $message->getUserPublicId());
    }
}
