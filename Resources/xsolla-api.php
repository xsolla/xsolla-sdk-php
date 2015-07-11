<?php

return array(
    'name' => 'Xsolla API',
    'apiVersion' => '2015-07-12',
    'description' => 'TODO',
    'baseUrl' => 'https://api.xsolla.com',
    'operations' => array(
        'CreatePaymentUIToken' => array(
            'httpMethod' => 'POST',
            'uri' => '/merchant/merchants/{merchant_id}/token',
            'summary' => 'TODO',
            'parameters' => array(
                'merchant_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'static' => true,
                    'required' => true,
                ),
                'token_settings' => array(
                    'location' => 'body',
                    'type' => 'array',
                    'required' => true,
                ),
            ),
        ),
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
        'SetProjectVirtualCurrencySettings' => array(
            'httpMethod' => 'PUT',
            'uri' => '/merchant/projects/{project_id}/virtual_currency',
            'summary' => 'Update project virtual currency settings',
            'parameters' => array(
                'project_id' => array(
                    'location' => 'uri',
                    'type' => 'integer',
                    'required' => true,
                ),
                'virtual_currency_settings' => array(
                    'location' => 'json',
                    'type' => 'array',
                    'required' => true,
                ),
            ),
        ),
    ),
);