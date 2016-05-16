<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ProjectSettingsTest extends AbstractAPITest
{
    protected static $createdProjectId;

    protected $project;

    public function setUp()
    {
        parent::setUp();
        $this->project = array(
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
    }

    public function testCreateProject()
    {
        $response = $this->xsollaClient->CreateProject(
            array(
                'merchant_id' => $this->merchantId,
                'request' => $this->project,
            )
        );
        static::assertArrayHasKey('id', $response);
        static::$createdProjectId = $response['id'];
    }

    /**
     * @depends testCreateProject
     */
    public function testGetProject()
    {
        $response = $this->xsollaClient->GetProject(
            array(
                'project_id' => static::$createdProjectId,
            )
        );
        static::assertInternalType('array', $response);
    }

    /**
     * @depends testCreateProject
     */
    public function testUpdateProject()
    {
        $this->xsollaClient->UpdateProject(
            array(
                'project_id' => static::$createdProjectId,
                'request' => $this->project,
            )
        );
    }

    public function testListProjects()
    {
        $response = $this->xsollaClient->ListProjects(
            array(
                'merchant_id' => $this->merchantId,
            )
        );
        static::assertInternalType('array', $response);
    }
}
