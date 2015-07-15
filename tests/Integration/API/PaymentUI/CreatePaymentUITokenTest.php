<?php

namespace Xsolla\SDK\Tests\Integration\API\PaymentUI;

use Herrera\Json\Json;
use Xsolla\SDK\API\PaymentUI\TokenRequest;
use Xsolla\SDK\API\XsollaClient;
use Guzzle\Http\Client;

class CreatePaymentUITokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XsollaClient
     */
    protected $xsollaClient;

    /**
     * @var Client
     */
    protected $guzzleClient;

    public function setUp()
    {
        $this->xsollaClient = XsollaClient::factory([
            'merchant_id' => $_SERVER['MERCHANT_ID'],
            'api_key' => $_SERVER['API_KEY']
        ]);
        $this->guzzleClient = new Client('https://secure.xsolla.com/');
    }

    protected function checkPaymentUI($token)
    {
        static::assertInternalType('string', $token);
        echo $token.PHP_EOL;
    }

    public function testCreateCommonPaymentUIToken()
    {
        $token = $this->xsollaClient->createCommonPaymentUIToken($_SERVER['PROJECT_ID'], 'USER_ID');
        $this->checkPaymentUI($token);
    }

    public function testCreatePaymentUITokenFromRequest()
    {
        $tokenRequest = new TokenRequest($_SERVER['PROJECT_ID'], 'USER_ID');
        $tokenRequest->setUserEmail('email@example.com')
            ->setCustomParameters(['a' => 1, 'b' => 2])
            ->setCurrency('USD')
            ->setExternalPaymentId(12345)
            ->setSandboxMode(true)
            ->setUserName('USER_NAME');
        $token = $this->xsollaClient->createPaymentUITokenFromRequest($tokenRequest);
        $this->checkPaymentUI($token);
    }

    public function testCreatePaymentUIToken()
    {
        $requestJsonFileName = __DIR__.'/../../../resources/token.json';
        $tokenPayload = file_get_contents($requestJsonFileName);
        if (false === $tokenPayload) {
            static::fail('Could not read token request from tests/resources/token.json');
        }
        $json = new Json();
        $request = $json->decode($tokenPayload, true);
        $tokenResponse = $this->xsollaClient->CreatePaymentUIToken(['request' => $request]);
        static::assertArrayHasKey('token', $tokenResponse);
        $this->checkPaymentUI($tokenResponse['token']);
    }
}