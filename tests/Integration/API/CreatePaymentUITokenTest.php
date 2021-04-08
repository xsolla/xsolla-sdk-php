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
        $token = static::$xsollaClient->createCommonPaymentUIToken(static::$projectId, static::$userId, true);
        static::assertIsString($token);
    }

    public function testCreatePaymentUITokenFromRequest()
    {
        $tokenRequest = new TokenRequest(static::$projectId, static::$userId);
        $tokenRequest->setUserEmail('email@example.com')
            ->setCustomParameters(['a' => 1, 'b' => 2])
            ->setCurrency('USD')
            ->setSandboxMode(true)
            ->setUserName('USER_NAME')
            ->setPurchase(1.5, 'EUR');
        $token = static::$xsollaClient->createPaymentUITokenFromRequest($tokenRequest);
        static::assertIsString($token);
    }

    public function testCreatePaymentUIToken()
    {
        $requestJsonFileName = __DIR__.'/../../Resources/Fixtures/token.json';
        $tokenPayload = file_get_contents($requestJsonFileName);
        if (false === $tokenPayload) {
            static::fail('Could not read token request from tests/resources/token.json');
        }
        $request = json_decode($tokenPayload, true);
        $request['settings']['project_id'] = static::$projectId;
        $request['user']['id']['value'] = static::$userId;
        $tokenResponse = static::$xsollaClient->CreatePaymentUIToken(['request' => $request]);
        static::assertArrayHasKey('token', $tokenResponse);
        static::assertIsString($tokenResponse['token']);
    }
}
