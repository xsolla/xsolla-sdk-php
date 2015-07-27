<?php

namespace Xsolla\SDK\Tests\Integration\Webhook;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Process\Process;
use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Version;

/**
 * @group webhook
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    public function setUp()
    {
        $this->guzzleClient = new Client('http://localhost:8000');
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
        $process = new Process('php -S localhost:8000', __DIR__.'/../../resources');
        $process->start();
        sleep(1);
        $signature = sha1($request.ServerMock::PROJECT_SECRET_KEY);
        $headers = null;
        if ($testHeaders) {
            $headers = $testHeaders;
        } else {
            $headers = array('Authorization' => 'Signature '.$signature);
        }
        $request = $this->guzzleClient->post('/webhook_server.php?test_case='.$testCase, $headers, $request);
        try {
            $response = $request->send();
        } catch (BadResponseException $e) {
            $process->stop();
            $response = $e->getResponse();
        }
        static::assertSame($expectedResponseContent, $response->getBody(true));
        static::assertSame($expectedStatusCode, $response->getStatusCode());
        static::assertArrayHasKey('x-xsolla-sdk', $response->getHeaders());
        static::assertSame(Version::getVersion(), (string) $response->getHeader('x-xsolla-sdk'));
        static::assertArrayHasKey('content-type', $response->getHeaders());
        if (204 === $response->getStatusCode()) {
            static::assertSame('text/plain;charset=UTF-8', (string) $response->getHeader('content-type'));
        } else {
            static::assertSame('application/json', (string) $response->getHeader('content-type'));
        }
    }

    public function cbProvider()
    {
        return array(
            array(
                'expectedStatusCode' => 204,
                'expectedResponseContent' => '',
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'success',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'notification_type key not found in Xsolla webhook request',
                        ),
                    )
                ),
                'request' => '{"foo": "bar"}',
                'testCase' => 'empty_request',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'Unknown notification_type in Xsolla webhook request: unknown',
                        ),
                    )
                ),
                'request' => '{"notification_type": "unknown"}',
                'testCase' => 'unknown_notification_type',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_SIGNATURE',
                            'message' => 'Invalid Signature. Signature provided in "Authorization" header (78143a5ac4b892a68ce8b0b8b49e26667db0fa00) does not match with expected',
                        ),
                    )
                ),
                'request' => null,
                'testCase' => 'invalid_signature',
                'testHeaders' => array('Authorization' => 'Signature 78143a5ac4b892a68ce8b0b8b49e26667db0fa00'),
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_SIGNATURE',
                            'message' => '"Authorization" header not found in Xsolla webhook request',
                        ),
                    )
                ),
                'request' => null,
                'testCase' => 'authorization_header_not_found',
                'testHeaders' => array('foo' => 'bar'),
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_SIGNATURE',
                            'message' => 'Signature not found in "Authorization" header from Xsolla webhook request: INVALID_FORMAT',
                        ),
                    )
                ),
                'request' => null,
                'testCase' => 'invalid_signature_format',
                'testHeaders' => array('Authorization' => 'INVALID_FORMAT'),
            ),
            array(
                'expectedStatusCode' => 422,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_PARAMETER',
                            'message' => 'Unable to parse Xsolla webhook request into JSON: Syntax error.',
                        ),
                    )
                ),
                'request' => 'INVALID_REQUEST_CONTENT',
                'testCase' => 'invalid_request_content',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'INVALID_CLIENT_IP',
                            'message' => 'Xsolla trusted subnets (159.255.220.240/28, 185.30.20.16/29, 185.30.21.0/24, 185.30.21.16/29) doesn\'t contain client IP address (127.0.0.1). If you use reverse proxy, you should set correct client IPv4 to WebhookRequest. If you are in development environment, you can set $authenticateClientIp = false in $webhookServer->start();',
                        ),
                    )
                ),
                'request' => null,
                'testCase' => 'invalid_ip',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 500,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'SERVER_ERROR',
                            'message' => 'callback_server_error',
                        ),
                    )
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_server_error',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 400,
                'expectedResponseContent' => XsollaClient::jsonEncode(
                    array(
                        'error' => array(
                            'code' => 'CLIENT_ERROR',
                            'message' => 'callback_client_error',
                        ),
                    )
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_client_error',
                'testHeaders' => null,
            ),
        );
    }
}
