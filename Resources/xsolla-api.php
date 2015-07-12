<?php

return array(
    'name' => 'Xsolla API',
    'apiVersion' => '2015-07-12',
    'description' => 'TODO',
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
                        'json_encode'
                    ),
                ),
            ),
        ),
        // Direct Payments
        'CreatePaymentAccount' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/payment_accounts',
            'summary' => 'A method for storing data from a user\'s credit card. It is available by agreement. For more detailed information, contact your account manager',
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
                        'json_encode'
                    ),
                ),
            ),
        ),
        'DeletePaymentAccount' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/payment_accounts/{type}/{account_id}',
            'summary' => 'Deleting a payment account',
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
                'type' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'account_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'ListPaymentAccounts' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/payment_accounts',
            'summary' => 'List all payment accounts of user',
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
        'MakePayment' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/payments/{type}/{account_id}',
            'summary' => 'Making a payment with a saved account',
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
                'type' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'account_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        'json_encode'
                    ),
                ),
            ),
        ),
        'MakeCreditCardPayment' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/payments/card',
            'summary' => 'Make an express payment with credit card',
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
                        'json_encode'
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
                        'json_encode'
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
                    'type' => 'string',
                    'required' => true,
                ),
                'request' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                    'filters' => array(
                        'json_encode'
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
                    'type' => 'string',
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
                    'type' => 'string',
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
                    'type' => 'string',
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
                'name' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
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
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'product_id' => array(
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'name' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'group_id' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'DeleteSubscriptionProduct' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/subscriptions/products/{product_id}/delete',
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
                        'json_encode'
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
        'ListSubscriptionPayments' => array(
            'httpMethod' => 'GET',
            'uri' => '/merchant/projects/{project_id}/users/{user_id}/subscriptions/payments',
            'summary' => 'List all recurrent payments',
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
                        'json_encode'
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
                        'json_encode'
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
                        'json_encode'
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
                        'json_encode'
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
                        'json_encode'
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
                        'json_encode'
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
                        'json_encode'
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
        'AddVirtualItemToGroup' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}/items/{item_id}',
            'summary' => 'Add an item to group',
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
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'order' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
        ),
        'DeleteVirtualItemFromGroup' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}/items/{item_id}',
            'summary' => 'Delete a virtual item from group',
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
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
            ),
        ),
        'UpdateVirtualItemsInGroup' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}/items',
            'summary' => 'Update a virtual items list in group',
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
                        'json_encode'
                    ),
                ),
            ),
        ),
        'UpdateVirtualItemOrderInGroup' => array(
            'httpMethod' => 'PATCH',
            'uri' => '/merchant/projects/{project_id}/virtual_items/groups/{group_id}/items/{item_id}',
            'summary' => 'Change items order order in group',
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
                'item_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'order' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
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
                    'json_encode'
                ),
            ),
        ),
    ),
    // Wallet
    'CreateWalletUser' => array(
        'httpMethod' => 'POST',
        'uri' => '/merchant/projects/{project_id}/users',
        'summary' => 'Create a new user.',
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
                    'json_encode'
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
                'type' => 'integer',
                'required' => true,
            ),
        ),
    ),
    'UpdateWalletUser' => array(
        'httpMethod' => 'PATCH',
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
                'type' => 'integer',
                'required' => true,
            ),
            'request' => array(
                'location' => 'body',
                'type' => 'array',
                'required' => true,
                'filters' => array(
                    'json_encode'
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
                'type' => 'integer',
                'required' => true,
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
    'RechargeWalletUserBalance' => array(
        'httpMethod' => 'POST',
        'uri' => '/merchant/projects/{project_id}/users/{user_id}/recharge',
        'summary' => 'Recharge a balance',
        'parameters' => array(
            'project_id' => array(
                'location' => 'uri',
                'type' => 'integer',
                'required' => true,
            ),
            'user_id' => array(
                'location' => 'uri',
                'type' => 'integer',
                'required' => true,
            ),
            'amount' => array(
                'location' => 'json',
                'type' => 'numeric',
                'required' => true,
            ),
            'comment' => array(
                'location' => 'json',
                'type' => 'string',
                'required' => true,
            ),
        ),
    ),
    'WithdrawWalletUserBalance' => array(
        'httpMethod' => 'POST',
        'uri' => '/merchant/projects/{project_id}/users/{user_id}/withdraw',
        'summary' => 'Withdraw user\'s balance',
        'parameters' => array(
            'project_id' => array(
                'location' => 'uri',
                'type' => 'integer',
                'required' => true,
            ),
            'user_id' => array(
                'location' => 'uri',
                'type' => 'integer',
                'required' => true,
            ),
            'amount' => array(
                'location' => 'json',
                'type' => 'numeric',
                'required' => true,
            ),
            'comment' => array(
                'location' => 'json',
                'type' => 'string',
                'required' => true,
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
                'type' => 'integer',
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
);