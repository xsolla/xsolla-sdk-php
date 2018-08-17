<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ProjectSettingsTest extends AbstractAPITest
{
    protected $projectSettings = array(
        'descriptor' => 'demo',
        'name' => array(
            'en' => 'Demo Project for Universal Protocol',
        ),
        'url' => 'http://xsolla.com',
        'description' => array(),
        'payment_url' => 'https://mygame.com/sample.universal.php',
        'key' => 'KEY',
        'return_url' => 'http://mygame.com/return.php',
        'user_billing_enabled' => true,
        'show_user_in_paystation' => true,
        'locale_list' => array(
            'en',
        ),
        'components' => array(
            'virtual_currency' => array(
                'enabled' => true,
                'custom_name' => array(
                    'en' => 'Virtual currency custom name',
                ),
            ),
            'items' => array(
                'enabled' => true,
                'custom_name' => array(
                    'en' => 'Items custom name',
                ),
            ),
            'simple_checkout' => array(
                'enabled' => true,
                'custom_name' => array(
                    'en' => 'Simple checkout custom name',
                ),
            ),
            'subscriptions' => array(
                'enabled' => true,
                'custom_name' => array(
                    'en' => 'Subscriptions custom name',
                ),
            ),
        ),
        'send_json_to_paystation' => false,
        'is_external_id_required' => false,
        'ipn_enabled' => true,
    );

    public function testCreateProject()
    {
        static::markTestIncomplete('Delete project API method not implemented yet. We should not create new projects infinitely.');
    }

    public function testGetProject()
    {
        $response = static::$xsollaClient->GetProject(
            array(
                'project_id' => static::$projectId,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testUpdateProject()
    {
        static::$xsollaClient->UpdateProject(
            array(
                'project_id' => static::$projectId,
                'request' => $this->projectSettings,
            )
        );
    }

    public function testListProjects()
    {
        $response = static::$xsollaClient->ListProjects();
        static::assertInternalType('array', $response);
    }
}
