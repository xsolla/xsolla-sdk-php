<?php

namespace Xsolla\SDK\Tests\Integration\Webhook;

use Xsolla\SDK\Exception\Webhook\ClientErrorException;
use Xsolla\SDK\Exception\Webhook\ServerErrorException;
use Xsolla\SDK\Webhook\WebhookServer;
use Xsolla\SDK\Webhook\Message\Message;

class ServerMock
{
    const PROJECT_SECRET_KEY = 'PROJECT_SECRET_KEY';

    public function run($testCase)
    {
        switch ($testCase) {
            case 'callback_client_error':
                $callback = function (Message $message) {
                    throw new ClientErrorException('callback_client_error');
                };
                break;
            case 'callback_server_error':
                $callback = function (Message $message) {
                    throw new ServerErrorException('callback_server_error');
                };
                break;
            default:
                $callback = function (Message $message) {

                };
        }
        $server = WebhookServer::create($callback, static::PROJECT_SECRET_KEY);
        $server->start(null, 'invalid_ip' === $testCase);
    }
}
