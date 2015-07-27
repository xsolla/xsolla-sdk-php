<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\API\PaymentUI\TokenRequest;

/**
 * @group api
 */
class CreatePaymentUITokenTest extends AbstractAPITest
{
    public function testCreateCommonPaymentUIToken()
    {
        $token = $this->xsollaClient->createCommonPaymentUIToken($_SERVER['PROJECT_ID'], 'USER_ID');
        static::assertInternalType('string', $token);
    }

    public function testCreatePaymentUITokenFromRequest()
    {
        $tokenRequest = new TokenRequest($_SERVER['PROJECT_ID'], 'USER_ID');
        $tokenRequest->setUserEmail('email@example.com')
            ->setCustomParameters(array('a' => 1, 'b' => 2))
            ->setCurrency('USD')
            ->setExternalPaymentId(12345)
            ->setSandboxMode(true)
            ->setUserName('USER_NAME');
        $token = $this->xsollaClient->createPaymentUITokenFromRequest($tokenRequest);
        static::assertInternalType('string', $token);
    }

    public function testCreatePaymentUIToken()
    {
        $requestJsonFileName = __DIR__.'/../../resources/token.json';
        $tokenPayload = file_get_contents($requestJsonFileName);
        if (false === $tokenPayload) {
            static::fail('Could not read token request from tests/resources/token.json');
        }
        $request = json_decode($tokenPayload, true);
        $tokenResponse = $this->xsollaClient->CreatePaymentUIToken(array('request' => $request));
        static::assertArrayHasKey('token', $tokenResponse);
        static::assertInternalType('string', $tokenResponse['token']);
    }
}
