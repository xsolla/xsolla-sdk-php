<?php

namespace Xsolla\SDK\Tests\Integration\IPN;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Process\Process;
use Xsolla\SDK\Tests\Integration\IPN\Mocks\ServerMock;
use Xsolla\SDK\Version;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    public function setUp()
    {
        $this->guzzleClient = new Client('http://localhost:8000');
        $this->guzzleClient->setDefaultOption('debug', true);
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
        $process = new Process('php -S localhost:8000', __DIR__.'/Mocks');
        $process->start();
        $signature = sha1($request.ServerMock::PROJECT_SECRET_KEY);
        $headers = null;
        if ($testHeaders) {
           $headers = $testHeaders;
        } else {
            $headers = array('Authorization' => 'Signature '.$signature);
        }
        $request = $this->guzzleClient->post('/server.php?test_case='.$testCase, $headers, $request);
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
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_PARAMETER',
                        'message' => 'notification_type field not found in request',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => null,
                'testCase' => 'empty_request',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Signature provided, but not matched',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => null,
                'testCase' => 'invalid_signature',
                'testHeaders' => array('Authorization' => 'Signature 78143a5ac4b892a68ce8b0b8b49e26667db0fa00'),
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Authorization header not found',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => null,
                'testCase' => 'authorization_header_not_found',
                'testHeaders' => array('foo' => 'bar'),
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_SIGNATURE',
                        'message' => 'Signature not found in Authorization header',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => null,
                'testCase' => 'invalid_signature_format',
                'testHeaders' => array('Authorization' => 'INVALID_FORMAT'),
            ),
            array(
                'expectedStatusCode' => 422,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_PARAMETER',
                        'message' => 'Unable to parse request body into JSON: 4',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => 'INVALID_REQUEST_CONTENT',
                'testCase' => 'invalid_request_content',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 401,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'INVALID_CLIENT_IP',
                        'message' => '',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => null,
                'testCase' => 'invalid_ip',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 500,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'SERVER_ERROR',
                        'message' => '',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_server_error',
                'testHeaders' => null,
            ),
            array(
                'expectedStatusCode' => 400,
                'expectedResponseContent' => json_encode(
                    array(
                        'code' => 'CLIENT_ERROR',
                        'message' => '',
                    ),
                    JSON_PRETTY_PRINT
                ),
                'request' => '{"notification_type": "payment"}',
                'testCase' => 'callback_client_error',
                'testHeaders' => null,
            ),
        );
    }


}