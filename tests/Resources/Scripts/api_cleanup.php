<?php

// $ MERCHANT_ID=1 API_KEY=secret php tests/Resources/Scripts/api_cleanup.php

require __DIR__.'/../../../vendor/autoload.php';

$xsollaClient = \Xsolla\SDK\API\XsollaClient::factory(array(
    'merchant_id' => getenv('MERCHANT_ID'),
    'api_key' => getenv('API_KEY'),
));

echo 'ListPromotions...'.PHP_EOL;
$promotions = $xsollaClient->ListPromotions();
foreach ($promotions as $promotion) {
    echo 'DeletePromotion '.$promotion['id'].PHP_EOL;
    $xsollaClient->DeletePromotion(array('promotion_id' => $promotion['id']));
}

echo 'ListProjects...'.PHP_EOL;
$projects = $xsollaClient->ListProjects();
$projectsIds = array();
foreach ($projects as $project) {
    $projectsIds[] = $project['id'];
}

foreach ($projectsIds as $projectId) {
    echo 'ListVirtualItems '.$projectId.PHP_EOL;
    $projectVirtualItems = $xsollaClient->ListVirtualItems(array(
        'project_id' => $projectId,
    ));
    foreach ($projectVirtualItems as $virtualItem) {
        echo 'DeleteVirtualItem '.$virtualItem['id'].PHP_EOL;
        $xsollaClient->DeleteVirtualItem(array(
            'project_id' => $projectId,
            'item_id' => $virtualItem['id'],
        ));
    }

    echo 'ListVirtualItemsGroups '.$projectId.PHP_EOL;
    $projectVirtualItemsGroups = $xsollaClient->ListVirtualItemsGroups(array(
        'project_id' => $projectId,
    ));
    foreach ($projectVirtualItemsGroups as $virtualItemGroup) {
        echo 'DeleteVirtualItemsGroup '.$virtualItemGroup['id'].PHP_EOL;
        $xsollaClient->DeleteVirtualItemsGroup(array(
            'project_id' => $projectId,
            'group_id' => $virtualItemGroup['id'],
        ));
    }

    echo 'ListUserAttributes '.$projectId.PHP_EOL;
    $attributes = $xsollaClient->ListUserAttributes(array(
        'project_id' => $projectId,
    ));
    foreach ($attributes as $attribute) {
        echo 'DeleteUserAttribute '.$attribute['id'].PHP_EOL;
        $xsollaClient->DeleteUserAttribute(array(
            'project_id' => $projectId,
            'user_attribute_id' => $attribute['id'],
        ));
    }

    echo 'ListSubscriptionPlans '.$projectId.PHP_EOL;
    $plans = $xsollaClient->ListSubscriptionPlans(array(
        'project_id' => $projectId,
    ));
    foreach ($plans as $plan) {
        echo 'DeleteSubscriptionPlan '.$plan['id'].PHP_EOL;
        $xsollaClient->DeleteSubscriptionPlan(array(
            'project_id' => $projectId,
            'plan_id' => $plan['id'],
        ));
    }

    echo 'ListSubscriptionProducts '.$projectId.PHP_EOL;
    $products = $xsollaClient->ListSubscriptionProducts(array(
        'project_id' => $projectId,
    ));
    foreach ($products as $product) {
        echo 'DeleteSubscriptionProduct '.$product['id'].PHP_EOL;
        $xsollaClient->DeleteSubscriptionProduct(array(
            'project_id' => $projectId,
            'product_id' => $product['id'],
        ));
    }
}
