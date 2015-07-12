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
                    'type' => 'integer',
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
                    'type' => 'integer',
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
                    'type' => 'integer',
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
        // Subscriptions

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
);