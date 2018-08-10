<?php

namespace Xsolla\SDK\Tests\Integration\Webhook;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Tests\Helper\DebugHelper;
use Xsolla\SDK\Version;

/**
 * @group webhook-php-server
 */
class ServerTest extends TestCase
{
    const PROJECT_SECRET_KEY = 'PROJECT_SECRET_KEY';

    /**
     * @var Process
     */
    protected static $process;

    /**
     * @var Client
     */
    protected static $httpClient;

    public static function setUpBeforeClass()
    {
        self::setUpPhpServer();
        self::setUpHttpClient();
    }

    private static function setUpPhpServer()
    {
        self::$process = new Process('php -S [::1]:8999', __DIR__.'/../../Resources/Scripts');
        self::$process->setTimeout(1);
        self::$process->start();
        usleep(100000);
    }

    private static function setUpHttpClient()
    {
        self::$httpClient = new Client('http://[::1]:8999');
        if (DebugHelper::isDebug()) {
            DebugHelper::addDebugOptionsToHttpClient(self::$httpClient);
        }
    }

    public static function tearDownAfterClass()
    {
        self::$process->stop(0);
    }

    /**
     * @dataProvider cbProvider
     */
    public function testResponse(
        $expectedStatusCode,
        $expectedResponseContent,
        $request,
        $testCase,
        $testHeaders
    ) {
        $signature = sha1($request.self::PROJECT_SECRET_KEY);
        if ($testHeaders) {
            $headers = $testHeaders;
        } else {
            $headers = ['Authorization' => 'Signature '.$signature];
        }
        $request = self::$httpClient->post('/webhook_server.php?test_case='.$testCase, $headers, $request);
        try {
            $response = $request->send();
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }
        static::assertSame($expectedResponseContent, $response->getBody(true));
        static::assertSame($expectedStatusCode, $response->getStatusCode());
        static::assertArrayHasKey('x-xsolla-sdk', $response->getHeaders());
        static::assertSame(Version::getVersion(), (string) $response->getHeader('x-xsolla-sdk'));
        static::assertArrayHasKey('content-type', $response->getHeaders());
        if (Response::HTTP_NO_CONTENT === $response->getStatusCode()) {
            static::assertStringStartsWith('text/plain', (string) $response->getHeader('content-type'));
        } else {
            static::assertStringStartsWith('application/json', (string) $response->getHeader('content-type'));
        }
    }

    public function cbProvider()
    {
        return [
            // notifications
            'notification_type:payment success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'payment_success',
                'testHeaders' => null,
            ],
            'notification_type:user_validation success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "user_validation"}',
                'testCase' => 'user_validation_success',
                'testHeaders' => null,
            ],
            'notification_type:refund success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "refund"}',
                'testCase' => 'refund_success',
                'testHeaders' => null,
            ],
            'notification_type:create_subscription success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "create_subscription"}',
                'testCase' => 'create_subscription_success',
                'testHeaders' => null,
            ],
            'notification_type:cancel_subscription success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "cancel_subscription"}',
                'testCase' => 'cancel_subscription_success',
                'testHeaders' => null,
            ],
            'notification_type:update_subscription success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "update_subscription"}',
                'testCase' => 'update_subscription_success',
                'testHeaders' => null,
            ],
            'notification_type:user_balance_operation success' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "user_balance_operation"}',
                'testCase' => 'user_balance_operation_success',
                'testHeaders' => null,
            ],
            //common errors
            'notification_type not sent' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'notification_type key not found in Xsolla webhook request',
                        ],
                    ]
                ),
                'request' => '{"foo": "bar"}',
                'testCase' => 'empty_request',
                'testHeaders' => null,
            ],
            'Unknown notification_type sent' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'Unknown notification_type in Xsolla webhook request: unknown',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "unknown"}',
                'testCase' => 'unknown_notification_type',
                'testHeaders' => null,
            ],
            'Invalid signature' => [
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_SIGNATURE',
                            'message' => 'Invalid Signature. Signature provided in "Authorization" header (78143a5ac4b892a68ce8b0b8b49e26667db0fa00) does not match with expected',
                        ],
                    ]
                ),
                'request' => null,
                'testCase' => 'invalid_signature',
                'testHeaders' => ['Authorization' => 'Signature 78143a5ac4b892a68ce8b0b8b49e26667db0fa00'],
            ],
            'Authorization header not sent' => [
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_SIGNATURE',
                            'message' => '"Authorization" header not found in Xsolla webhook request. Please check troubleshooting section in README.md https://github.com/xsolla/xsolla-sdk-php#troubleshooting',
                        ],
                    ]
                ),
                'request' => null,
                'testCase' => 'authorization_header_not_found',
                'testHeaders' => ['foo' => 'bar'],
            ],
            'Authorization header has invalid format' => [
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_SIGNATURE',
                            'message' => 'Signature not found in "Authorization" header from Xsolla webhook request: INVALID_FORMAT',
                        ],
                    ]
                ),
                'request' => null,
                'testCase' => 'invalid_signature_format',
                'testHeaders' => ['Authorization' => 'INVALID_FORMAT'],
            ],
            'Invalid JSON sent' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'Unable to parse Xsolla webhook request into JSON: Syntax error.',
                        ],
                    ]
                ),
                'request' => 'INVALID_REQUEST_CONTENT',
                'testCase' => 'invalid_request_content',
                'testHeaders' => null,
            ],
            'Request from unknown client ip address rejected' => [
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_CLIENT_IP',
                            'message' => 'Client IP address (::1) not found in allowed IP addresses whitelist (159.255.220.240/28, 185.30.20.16/29, 185.30.21.0/24, 185.30.21.16/29). Please check troubleshooting section in README.md https://github.com/xsolla/xsolla-sdk-php#troubleshooting',
                        ],
                    ]
                ),
                'request' => null,
                'testCase' => 'invalid_ip',
                'testHeaders' => null,
            ],
            // exceptions from callback
            'Callback throws ServerErrorException' => [
                'expectedStatusCode' => 500,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'SERVER_ERROR',
                            'message' => 'callback_server_error',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_server_error',
                'testHeaders' => null,
            ],
            'Callback throws ClientErrorException' => [
                'expectedStatusCode' => 400,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'CLIENT_ERROR',
                            'message' => 'callback_client_error',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_client_error',
                'testHeaders' => null,
            ],
            'Callback throws \Exception' => [
                'expectedStatusCode' => 500,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'FATAL_ERROR',
                            'message' => 'callback_exception',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_exception',
                'testHeaders' => null,
            ],
            'Callback throws InvalidUserException' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INVALID_USER',
                            'message' => 'callback_invalid_user_exception',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_invalid_user_exception',
                'testHeaders' => null,
            ],
            'Callback throws InvalidAmountException' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INCORRECT_AMOUNT',
                            'message' => 'callback_invalid_amount_exception',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_invalid_amount_exception',
                'testHeaders' => null,
            ],
            'Callback throws InvalidInvoiceException' => [
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'INCORRECT_INVOICE',
                            'message' => 'callback_invalid_invoice_exception',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_invalid_invoice_exception',
                'testHeaders' => null,
            ],
            // get_pincode
            'get_pincode with empty webhook response' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "get_pincode"}',
                'testCase' => 'get_pincode_empty',
                'testHeaders' => null,
            ],
            'get_pincode with webhook response' => [
                'expectedStatusCode' => 200,
                'expectedResponseContent' => '{
    "pin_code": "CODE"
}',
                'request' => '{"notification_type": "get_pincode"}',
                'testCase' => 'get_pincode_success',
                'testHeaders' => null,
            ],
            'get_pincode invalid pin code from callback' => [
                'expectedStatusCode' => 500,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'SERVER_ERROR',
                            'message' => 'Pin code should be non-empty string. NULL given',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "get_pincode"}',
                'testCase' => 'get_pincode_invalid',
                'testHeaders' => null,
            ],
            // user_search
            'user_search with empty webhook response' => [
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "user_search"}',
                'testCase' => 'user_search_empty',
                'testHeaders' => null,
            ],
            'user_search with webhook response' => [
                'expectedStatusCode' => 200,
                'expectedResponseContent' => '{
    "user": {
        "id": "USER_ID",
        "name": "User Name",
        "public_id": "PUBLIC_ID",
        "email": "user@example.com",
        "phone": "123456789"
    }
}',
                'request' => '{"notification_type": "user_search"}',
                'testCase' => 'user_search_success',
                'testHeaders' => null,
            ],
            'user_search invalid user id from callback' => [
                'expectedStatusCode' => 500,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    [
                        'error' => [
                            'code' => 'SERVER_ERROR',
                            'message' => 'User id should be non-empty string. NULL given',
                        ],
                    ]
                ),
                'request' => '{"notification_type": "user_search"}',
                'testCase' => 'user_search_invalid',
                'testHeaders' => null,
            ],
        ];
    }
}
