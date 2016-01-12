<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class GameDeliveryTest extends AbstractAPITest
{
    private static $gameDeliveryEntityId;

    private static $gameDeliveryEntitySku;

    private $gameDeliveryEntityTemplate;

    public function setUp()
    {
        parent::setUp();
        $this->gameDeliveryEntityTemplate = array(
            'sku' => uniqid('sdk-test', true),
            'name' => array(
                'en' => 'sdk-test name-en',
            ),
            'description' => array(
                'en' => 'sdk-test description-en',
            ),
            'system_requirements' => 'sdk-test system_requirements',
            'default_currency' => 'USD',
            'drm' => array(
                array(
                    'id' => 1,
                    'platforms' => array(
                        array(
                            'id' => 1,
                        ),
                    ),
                ),
            ),
        );
    }

    public function testListGameDeliveryDrmPlatforms()
    {
        $response = $this->xsollaClient->ListGameDeliveryDrmPlatforms();
        static::assertArrayHasKey('platforms', $response);
        static::assertArrayHasKey('drm', $response);
    }

    public function testCreateGameDeliveryEntity()
    {
        $response = $this->xsollaClient->CreateGameDeliveryEntity(array(
            'project_id' => $this->projectId,
            'request' => $this->gameDeliveryEntityTemplate,
        ));
        static::assertArrayHasKey('id', $response);
        static::$gameDeliveryEntityId = $response['id'];
        static::$gameDeliveryEntitySku = $this->gameDeliveryEntityTemplate['sku'];
    }

    /**
     * @depends testCreateGameDeliveryEntity
     */
    public function testListGameDeliveryEntities()
    {
        $response = $this->xsollaClient->ListGameDeliveryEntities(array(
            'project_id' => $this->projectId,
        ));
        static::assertInternalType('array', $response);
        static::assertArrayHasKey('id', current($response));
    }

    /**
     * @depends testCreateGameDeliveryEntity
     */
    public function testGetGameDeliveryEntity()
    {
        $response = $this->xsollaClient->GetGameDeliveryEntity(array(
            'project_id' => $this->projectId,
            'game_delivery_id' => self::$gameDeliveryEntityId,
        ));
        static::assertSame(self::$gameDeliveryEntityId, $response['id']);
        static::assertSame(self::$gameDeliveryEntitySku, $response['sku']);
    }

    /**
     * @depends testCreateGameDeliveryEntity
     */
    public function testUpdateGameDeliveryEntity()
    {
        $this->xsollaClient->UpdateGameDeliveryEntity(array(
            'project_id' => $this->projectId,
            'game_delivery_id' => self::$gameDeliveryEntityId,
            'request' => $this->gameDeliveryEntityTemplate,
        ));
    }
}
