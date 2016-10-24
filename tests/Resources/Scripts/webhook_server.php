<?php

ini_set('date.timezone', 'UTC');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
ini_set('error_reporting', -1);

require __DIR__.'/../../../vendor/autoload.php';

use Xsolla\SDK\Exception\Webhook\ClientErrorException;
use Xsolla\SDK\Exception\Webhook\InvalidAmountException;
use Xsolla\SDK\Exception\Webhook\InvalidInvoiceException;
use Xsolla\SDK\Exception\Webhook\InvalidUserException;
use Xsolla\SDK\Exception\Webhook\ServerErrorException;
use Xsolla\SDK\Tests\Integration\Webhook\ServerTest;
use Xsolla\SDK\Webhook\Response\PinCodeResponse;
use Xsolla\SDK\Webhook\Response\UserResponse;
use Xsolla\SDK\Webhook\User;
use Xsolla\SDK\Webhook\WebhookServer;

$testCase = $_GET['test_case'];
switch ($testCase) {
    case 'callback_client_error':
        $callback = function () {
            throw new ClientErrorException('callback_client_error');
        };
        break;
    case 'callback_server_error':
        $callback = function () {
            throw new ServerErrorException('callback_server_error');
        };
        break;
    case 'callback_exception':
        $callback = function () {
            throw new \Exception('callback_exception');
        };
        break;
    case 'callback_invalid_user_exception':
        $callback = function () {
            throw new InvalidUserException('callback_invalid_user_exception');
        };
        break;
    case 'callback_invalid_amount_exception':
        $callback = function () {
            throw new InvalidAmountException('callback_invalid_amount_exception');
        };
        break;
    case 'callback_invalid_invoice_exception':
        $callback = function () {
            throw new InvalidInvoiceException('callback_invalid_invoice_exception');
        };
        break;
    case 'get_pincode_success':
        $callback = function () {
            return new PinCodeResponse('CODE');
        };
        break;
    case 'get_pincode_invalid':
        $callback = function () {
            return new PinCodeResponse(null);
        };
        break;
    case 'user_search_invalid':
        $callback = function () {
            $user = new User();

            return new UserResponse($user);
        };
        break;
    case 'user_search_success':
        $callback = function () {
            $user = new User();
            $user->setId('USER_ID');
            $user->setEmail('user@example.com');
            $user->setName('User Name');
            $user->setPhone('123456789');
            $user->setPublicId('PUBLIC_ID');

            return new UserResponse($user);
        };
        break;
    default:
        $callback = function () {
        };
}
$server = WebhookServer::create($callback, ServerTest::PROJECT_SECRET_KEY);
$isAuthenticateClientIp = 'invalid_ip' === $testCase;
$server->start(null, $isAuthenticateClientIp);
