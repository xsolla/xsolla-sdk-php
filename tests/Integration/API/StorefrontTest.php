<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class StorefrontTest extends AbstractAPITest
{
    const LANGUAGE = 'en';
    const CURRENCY = 'USD';

    public function testGetStorefrontVirtualCurrency()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualCurrency(
            [
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            ]
        );
        static::assertIsArray($response);
    }

    public function testGetStorefrontVirtualGroups()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualGroups(
            [
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            ]
        );
        static::assertIsArray($response);
    }

    public function testGetStorefrontVirtualItems()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualItems(
            [
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
                'group_id' => 7,
            ]
        );
        static::assertIsArray($response);
    }

    public function testGetStorefrontSubscriptions()
    {
        $response = static::$xsollaClient->GetStorefrontSubscriptions(
            [
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            ]
        );
        static::assertIsArray($response);
    }

    public function testGetStorefrontBonus()
    {
        $response = static::$xsollaClient->GetStorefrontBonus(
            [
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            ]
        );
        static::assertIsArray($response);
    }
}
