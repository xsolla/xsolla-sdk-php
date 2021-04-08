<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ProjectSettingsTest extends AbstractAPITest
{
    protected $projectSettings = [
        'descriptor' => 'demo',
        'name' => [
            'en' => 'Demo Project for Universal Protocol',
        ],
        'url' => 'http://xsolla.com',
        'description' => [],
        'payment_url' => 'https://mygame.com/sample.universal.php',
        'key' => 'KEY',
        'return_url' => 'http://mygame.com/return.php',
        'user_billing_enabled' => true,
        'show_user_in_paystation' => true,
        'locale_list' => [
            'en',
        ],
        'components' => [
            'virtual_currency' => [
                'enabled' => true,
                'custom_name' => [
                    'en' => 'Virtual currency custom name',
                ],
            ],
            'items' => [
                'enabled' => true,
                'custom_name' => [
                    'en' => 'Items custom name',
                ],
            ],
            'simple_checkout' => [
                'enabled' => true,
                'custom_name' => [
                    'en' => 'Simple checkout custom name',
                ],
            ],
            'subscriptions' => [
                'enabled' => true,
                'custom_name' => [
                    'en' => 'Subscriptions custom name',
                ],
            ],
        ],
        'send_json_to_paystation' => false,
        'is_external_id_required' => false,
        'ipn_enabled' => true,
    ];

    public function testCreateProject()
    {
        static::markTestIncomplete('Delete project API method not implemented yet. We should not create new projects infinitely.');
    }

    public function testGetProject()
    {
        $response = static::$xsollaClient->GetProject(
            [
                'project_id' => static::$projectId,
            ]
        );
        static::assertIsArray($response);
    }

    public function testUpdateProject()
    {
        static::$xsollaClient->UpdateProject(
            [
                'project_id' => static::$projectId,
                'request' => $this->projectSettings,
            ]
        );
        static::assertTrue(true);
    }

    public function testListProjects()
    {
        $response = static::$xsollaClient->ListProjects();
        static::assertIsArray($response);
    }
}
