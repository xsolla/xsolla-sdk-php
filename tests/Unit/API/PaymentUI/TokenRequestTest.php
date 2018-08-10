<?php

namespace Xsolla\SDK\Tests\Unit\API\PaymentUI;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\API\PaymentUI\TokenRequest;

/**
 * @group unit
 */
class TokenRequestTest extends TestCase
{
    public function testSetters()
    {
        $tokenRequest = new TokenRequest('PROJECT_ID', 'USER_ID');
        $actualRequest = $tokenRequest->setUserEmail('email@example.com')
            ->setCustomParameters(['a' => 1, 'b' => 2])
            ->setCurrency('USD')
            ->setExternalPaymentId(12345)
            ->setSandboxMode(true)
            ->setUserName('USER_NAME')
            ->setPurchase(1.5, 'EUR')
            ->toArray();

        $expectedRequest = [
            'user' => [
                'id' => ['value' => 'USER_ID'],
                'email' => ['value' => 'email@example.com'],
                'name' => ['value' => 'USER_NAME'],
            ],
            'settings' => [
                'project_id' => 'PROJECT_ID',
                'currency' => 'USD',
                'external_id' => 12345,
                'mode' => 'sandbox',
            ],
            'custom_parameters' => [
                'a' => 1,
                'b' => 2,
            ],
            'purchase' => [
                'checkout' => [
                    'amount' => 1.5,
                    'currency' => 'EUR',
                ],
            ],
        ];
        static::assertSame($expectedRequest, $actualRequest);
    }
}
