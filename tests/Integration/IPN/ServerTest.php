<?php

namespace Xsolla\SDK\Tests\Integration\IPN;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Process\Process;
use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Version;

/**
 * @group ipn
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
        $process = new Process('php -S localhost:8000', __DIR__ . '/../../resources');
        $process->start();
        sleep(1);
        $signature = sha1($request.ServerMock::PROJECT_SECRET_KEY);
        $headers = null;
        if ($testHeaders) {
           $headers = $testHeaders;
        } else {
            $headers = array('Authorization' => 'Signature '.$signature);
        }
        $request = $this->guzzleClient->post('/ipn_server.php?test_case='.$testCase, $headers, $request);
        try {
            $response = $request->send();
        } catch (BadResponseException $e) {
            $process->stop();
            $response = $e->getResponse();
        }
        static::assertEquals($expectedResponseContent, $response->getBody(true));
        static::assertEquals($expectedStatusCode, $response->getStatusCode());
        static::assertArrayHasKey('x-xsolla-sdk', $response->getHeaders());
        static::assertEquals(Version::getVersion(), $response->getHeader('x-xsolla-sdk'));
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
                        'code' => 'INVALID_PARAMETER',
                        'message' => 'notification_type field not found in request',
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
                        'code' => 'INVALID_PARAMETER',
                        'message' => 'Unknown notification_type: unknown',
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
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Signature provided, but not matched',
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
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Authorization header not found',
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
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Signature not found in Authorization header',
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
                        'code' => 'INVALID_PARAMETER',
                        'message' => 'Unable to parse request body into JSON: 4',
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
                        'code' => 'INVALID_CLIENT_IP',
                        'message' => '',
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
                        'code' => 'SERVER_ERROR',
                        'message' => '',
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
                        'code' => 'CLIENT_ERROR',
                        'message' => '',
                    )
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_client_error',
                'testHeaders' => null,
            ),
        );
    }


}