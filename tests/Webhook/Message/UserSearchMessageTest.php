<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Message\UserSearchMessage;

/**
 * @group unit
 */
class UserSearchMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testUserPublicId()
    {
        $request = array(
            'user' => array(
                'public_id' => '1234567',
            ),
            'notification_type' => 'user_search',
        );
        $message = new UserSearchMessage($request);
        static::assertSame($request['user'], $message->getUser());
        static::assertSame(null, $message->getUserId());
        static::assertSame($request['user']['public_id'], $message->getUserPublicId());
    }
}
