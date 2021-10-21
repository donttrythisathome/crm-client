<?php

return [
    'default' => env('DEFAULT_CRM_DRIVER', 'baz'),
    'drivers' => [
        'baz' => [
            'endpoint' => env('BAZ_CRM_ENDPOINT', 'https://jsonplaceholder.typicode.com/posts'),
            'api_token' => env('BAZ_CRM_ACCESS_TOKEN', '')
        ]
    ]
];