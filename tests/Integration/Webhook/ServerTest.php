<?php

namespace Xsolla\SDK\Tests\Integration\Webhook;

use Guzzle\Common\Event;
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
        $this->guzzleClient = new Client('http://[::1]:8999');
        global $argv;
        if (in_array('--debug', $argv, true)) {
            $echoCb = function (Event $event) {
                echo (string) $event['request'].PHP_EOL;
                echo (string) $event['response'].PHP_EOL;
            };
            $this->guzzleClient->getEventDispatcher()->addListener('request.complete', $echoCb);
            $this->guzzleClient->getEventDispatcher()->addListener('request.exception', $echoCb);
        }
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
        $process = new Process('php -S [::1]:8999', __DIR__.'/../../resources');
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
            static::assertStringStartsWith('text/plain', (string) $response->getHeader('content-type'));
        } else {
            static::assertStringStartsWith('application/json', (string) $response->getHeader('content-type'));
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
                            'message' => '"Authorization" header not found in Xsolla webhook request. Please check troubleshooting section in README.md https://github.com/xsolla/xsolla-sdk-php#troubleshooting',
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
                            'message' => 'Client IP address (::1) not found in allowed IP addresses whitelist (159.255.220.240/28, 185.30.20.16/29, 185.30.21.0/24, 185.30.21.16/29). Please check troubleshooting section in README.md https://github.com/xsolla/xsolla-sdk-php#troubleshooting',
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
