<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class VirtualCurrencyTest extends AbstractAPITest
{
    public function testUpdateProjectVirtualCurrencySettings()
    {
        static::$xsollaClient->UpdateProjectVirtualCurrencySettings([
            'request' => [
                'vc_name' => [
                    'en' => 'name',
                ],
                'base' => [
                    'USD' => 0.9,
                ],
                'min' => 0.01,
                'max' => 100.2,
                'default_currency' => 'USD',
            ],
            'project_id' => static::$projectId,
        ]);
        static::assertTrue(true);
    }

    public function testGetProjectVirtualCurrencySettings()
    {
        $response = static::$xsollaClient->GetProjectVirtualCurrencySettings(['project_id' => static::$projectId]);
        static::assertIsArray($response);
    }
}
