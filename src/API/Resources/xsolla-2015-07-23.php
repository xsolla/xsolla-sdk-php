<?php

return array(
    'name' => 'Xsolla API',
    'apiVersion' => '2015-07-23',
    'description' => '',
    'baseUrl' => 'https://api.xsolla.com',
    'operations' => array(
        // Payment UI
        'CreatePaymentUIToken' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/merchants/{merchant_id}/token',
            'summary' => 'Create payment UI token',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Subscriptions
        'CreateSubscriptionPlan' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans',
            'summary' => 'Create a recurrent plan',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'UpdateSubscriptionPlan' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans/{plan_id}',
            'summary' => 'Update a recurrent plan',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'plan_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteSubscriptionPlan' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans/{plan_id}/delete',
            'summary' => 'Delete a recurrent plan',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'plan_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'DisableSubscriptionPlan' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans/{plan_id}',
            'summary' => 'Disable a recurrent plan',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'plan_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'EnableSubscriptionPlan' => array(
            'httpMethod' => 'PATCH',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans/{plan_id}',
            'summary' => 'Enable a recurrent plan',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'plan_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListSubscriptionPlans' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/subscriptions/plans',
            'summary' => 'List all recurrent plans',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'CreateSubscriptionProduct' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/subscriptions/products',
            'summary' => 'Create a product',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'UpdateSubscriptionProduct' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/subscriptions/products/{product_id}',
            'summary' => 'Update a product',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'product_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteSubscriptionProduct' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/subscriptions/products/{product_id}',
            'summary' => 'Delete a product',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'product_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'ListSubscriptionProducts' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/subscriptions/products',
            'summary' => 'List all recurrent products',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
            ),
        ),
        'UpdateSubscription' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/subscriptions/{subscription_id}',
            'summary' => 'Update a recurrent subscription. It\'s available to update the status of subscription (active or canceled) and to postpone the date of the next charge for current subscription.',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'subscription_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'ListSubscriptions' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/subscriptions',
            'summary' => 'List all recurrent subscriptions',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'status' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'datetime_from' => array(//TODO DATETIME
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
        ),
        'ListUserSubscriptionPayments' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/subscriptions/payments',
            'summary' => 'List all recurrent payments by user',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'status' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'subscription_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
            ),
        ),
        'ListSubscriptionPayments' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/subscriptions/payments',
            'summary' => 'List all recurrent payments',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'status' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'subscription_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
            ),
        ),
        'ListSubscriptionCurrencies' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/subscriptions/currencies',
            'summary' => 'List all recurrent currencies',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        //User attributes
        'ListUserAttributes' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/user_attributes',
            'summary' => 'Get list of user attributes',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'GetUserAttribute' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/user_attributes/{user_attribute_id}',
            'summary' => 'Show a user attribute',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_attribute_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'CreateUserAttribute' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/user_attributes',
            'summary' => 'Create user attribute',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'UpdateUserAttribute' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/user_attributes/{user_attribute_id}',
            'summary' => 'Update user attribute',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_attribute_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteUserAttribute' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/user_attributes/{user_attribute_id}',
            'summary' => 'Delete a user attribute',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_attribute_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        // Virtual Items
        'CreateVirtualItem' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items',
            'summary' => 'Create a virtual item',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetVirtualItem' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items/{item_id}',
            'summary' => 'Get a virtual item',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateVirtualItem' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items/{item_id}',
            'summary' => 'Update a virtual item',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteVirtualItem' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items/{item_id}',
            'summary' => 'Delete a virtual item',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListVirtualItems' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items',
            'summary' => 'List a virtual items',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateVirtualItemImage' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items/{item_id}/image',
            'summary' => 'Upload an image for virtual item',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteVirtualItemImage' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/virtual_items/items/{item_id}/image',
            'summary' => 'Change a virtual item image to default',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'CreateVirtualItemsGroup' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups',
            'summary' => 'Create a virtual items group',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetVirtualItemsGroup' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}',
            'summary' => 'Get a virtual items group',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateVirtualItemsGroup' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}',
            'summary' => 'Update a virtual items group',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteVirtualItemsGroup' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}',
            'summary' => 'Delete a virtual items group',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListVirtualItemsGroups' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups',
            'summary' => 'List all virtual items groups',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateVirtualItemOrderInGroup' => array(
            'httpMethod' => 'PUT',
            'uri' => 'https://api.xsolla.com/merchant/projects/{project_id}/virtual_items/sort',
            'summary' => 'Update items order in group',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Virtual Currency
        'GetProjectVirtualCurrencySettings' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/virtual_currency',
            'summary' => 'Get project virtual currency settings',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateProjectVirtualCurrencySettings' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_currency',
            'summary' => 'Update project virtual currency settings',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Wallet
        'CreateWalletUser' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/users',
            'summary' => 'Create a new user',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetWalletUser' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}',
            'summary' => 'Retrieve a user data',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'UpdateWalletUser' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}',
            'summary' => 'Update user\'s information',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'ListWalletUsers' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users',
            'summary' => 'List all users',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'email' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'phone' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListWalletUserOperations' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/transactions',
            'summary' => 'List all operations',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'RechargeWalletUserBalance' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/recharge',
            'summary' => 'Change a balance',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'ListWalletUserVirtualItems' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/virtual_items',
            'summary' => 'Get user\'s virtual items',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'AddVirtualItemToWalletUser' => array(
            'httpMethod' => 'POST ',
            'uri' => 'https://api.xsolla.com/merchant/projects/{project_id}/users/{user_id}/virtual_items/add',
            'summary' => 'Add the virtual items to the user\'s account',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'DeleteVirtualItemFromWalletUser' => array(
            'httpMethod' => 'POST ',
            'uri' => 'https://api.xsolla.com/merchant/projects/{project_id}/users/{user_id}/virtual_items/remove',
            'summary' => 'Delete the virtual items from the user\'s account',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'user_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Coupons
        'GetCoupon' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/coupons/{code}',
            'summary' => 'Get information about coupon by code',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'code' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'RedeemCoupon' => array(
            'httpMethod' => 'POST ',
            'uri' => '/merchant/projects/{project_id}/coupons/{code}/redeem',
            'summary' => 'Redeem coupon by code',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'code' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Promotions
        'CreatePromotion' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/merchants/{merchant_id}/promotions',
            'summary' => 'Create a new promotion',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetPromotion' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}',
            'summary' => 'Get a promotion',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdatePromotion' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}',
            'summary' => 'Update a promotion. If the promotion is read-only (read_only = true), you are not allowed to change "project_id" parameter.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'ReviewPromotion' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/review',
            'summary' => 'Check the promotion, if it is ready for activation. This method returns the list of errors (if they exist).',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'TogglePromotion' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/toggle',
            'summary' => 'Toggle the promotion. Change the status of promotion from enabled to disabled and vice versa.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'DeletePromotion' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}',
            'summary' => 'Delete a promotion. Only disabled promotion is allowed to delete (enabled = false).',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListPromotions' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions',
            'summary' => 'List all promotions',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
            ),
        ),
        'GetPromotionSubject' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/subject',
            'summary' => 'Get the subject of the promotion',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'SetPromotionSubject' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/subject',
            'summary' => 'Set the subject of the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the subject. The subject can take the following values: "purchase", or "items", or "packages".',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetPromotionPaymentSystems' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/payment_systems',
            'summary' => 'Get the payment systems of the promotion. If the payment systems list is empty, the promotion will be valid for all payment systems.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'SetPromotionPaymentSystems' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/payment_systems',
            'summary' => 'Set the payment systems of the promotion. If the payment systems list is empty, the promotion will be applied for all payment systems. If the promotion is read-only (read_only = true), you are not allowed to call this command.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetPromotionPeriods' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/periods',
            'summary' => 'Get the periods of the promotion',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'SetPromotionPeriods' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/periods',
            'summary' => 'Set the periods of the promotion. If the promotion is read-only (read_only = true), you are not allowed to edit existing periods, add new periods only.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        'GetPromotionRewards' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/rewards',
            'summary' => 'Get the rewards of the promotion',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'SetPromotionRewards' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/promotions/{promotion_id}/rewards',
            'summary' => 'Set the rewards to the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the rewards.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'promotion_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Events
        'ListEvents' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/events/messages',
            'summary' => 'List all events from Xsolla Event System',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
            ),
        ),
        // Reports
        'SearchPaymentsRegistry' => array(
            'httpMethod' => 'GET',
            'uri' => 'https://api.xsolla.com/merchant/merchants/{merchant_id}/reports/transactions/search.{format}',
            'summary' => 'Get a transaction list based on specific search parameters. JSON, CSV or XML will be returned in response from the API.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'format' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'project_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'show_dry_run' => array(
                    'location' => 'query',
                    'type' => 'boolean',
                    'required' => false,
                ),
                'transaction_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'phone' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'user_id' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'user_name' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'user_custom' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'email' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'external_id' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'type' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'ListPaymentsRegistry' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/reports/transactions/registry.{format}',
            'summary' => 'Get information about all transactions for specified data range/transfer/report in different data formats. JSON, CSV or XML will be returned in response from the API.',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'format' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ),
                'project_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'show_dry_run' => array(
                    'location' => 'query',
                    'type' => 'boolean',
                    'required' => false,
                ),
                'transfer_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'report_id' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => false,
                ),
                'merchant_of_records' => array(
                    'location' => 'query',
                    'type' => 'boolean',
                    'required' => false,
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'offset' => array(
                    'location' => 'query',
                    'type' => 'integer',
                    'required' => true,
                ),
                'in_transfer_currency' => array(
                    'location' => 'query',
                    'type' => 'boolean',
                    'required' => true,
                ),
                'show_total' => array(
                    'location' => 'query',
                    'type' => 'boolean',
                    'required' => true,
                ),
            ),
        ),
        'ListTransfersRegistry' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/reports/transfers',
            'summary' => 'List all transfers',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
        ),
        'ListReportsRegistry' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/reports',
            'summary' => 'Get a list of finance reports for specified data range',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'datetime_from' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'datetime_to' => array(
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
        ),
        'CreateRefundRequest' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/merchants/{merchant_id}/reports/transactions/{transaction_id}/refund',
            'summary' => 'Send a refund request. Money will be returned to user',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'transaction_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        '\Xsolla\SDK\API\XsollaClient::jsonEncode',
                    ),
                ),
            ),
        ),
        // Support
        'ListSupportTickets' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/support/tickets',
            'summary' => 'List all tickets',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
            ),
        ),
        'ListSupportTicketComments' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/merchants/{merchant_id}/support/tickets/{ticket_id}/comments',
            'summary' => 'List all comments',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'ticket_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
    ),
);
