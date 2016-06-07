<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class GameDeliveryTest extends AbstractAPITest
{
    /**
     * @var int
     */
    protected static $gameDeliveryEntityId;

    private $gameDeliveryEntityTemplate = array(
        'sku' => 'sdk-test',
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

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::$gameDeliveryEntityId = (int) getenv('GAME_DELIVERY_ENTITY_ID');
    }

    public function testListGameDeliveryDrmPlatforms()
    {
        $response = static::$xsollaClient->ListGameDeliveryDrmPlatforms();
        static::assertArrayHasKey('platforms', $response);
        static::assertArrayHasKey('drm', $response);
    }

    public function testCreateGameDeliveryEntity()
    {
        static::markTestIncomplete('Delete game delivery entity API method not implemented yet. We should not create new entities infinitely.');
    }

    public function testListGameDeliveryEntities()
    {
        $response = static::$xsollaClient->ListGameDeliveryEntities(array(
            'project_id' => static::$projectId,
        ));
        static::assertInternalType('array', $response);
        static::assertArrayHasKey('id', current($response));
    }

    public function testGetGameDeliveryEntity()
    {
        $response = static::$xsollaClient->GetGameDeliveryEntity(array(
            'project_id' => static::$projectId,
            'game_delivery_id' => static::$gameDeliveryEntityId,
        ));
        static::assertSame(static::$gameDeliveryEntityId, $response['id']);
    }

    public function testUpdateGameDeliveryEntity()
    {
        static::$xsollaClient->UpdateGameDeliveryEntity(array(
            'project_id' => static::$projectId,
            'game_delivery_id' => static::$gameDeliveryEntityId,
            'request' => $this->gameDeliveryEntityTemplate,
        ));
    }
}
