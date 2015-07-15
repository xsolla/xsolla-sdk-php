<?php

namespace Xsolla\SDK\Tests\Integration\IPN\Mocks;

use Xsolla\SDK\Exception\IPN\ClientErrorException;
use Xsolla\SDK\Exception\IPN\ServerErrorException;
use Xsolla\SDK\IPN\IPNServer;
use Xsolla\SDK\IPN\Message\Message;

class ServerMock 
{
    const PROJECT_SECRET_KEY = 'PROJECT_SECRET_KEY';

    public function run($testCase)
    {
        switch ($testCase) {
            case 'callback_client_error':
                $callback = function (Message $message) {
                    throw new ClientErrorException();
                };
                break;
            case 'callback_server_error':
                $callback = function (Message $message) {
                    throw new ServerErrorException();
                };
                break;
            default:
                $callback = function (Message $message) {

                };
        }
        $server = IPNServer::create($callback, static::PROJECT_SECRET_KEY);
        $server->start(null, 'invalid_ip' == $testCase);
    }
}