<?php

return [
    'api' => [
        'enabled' => env('L5_SWAGGER_API_ENABLED', true),
        'prefix' => env('L5_SWAGGER_API_PREFIX', 'api'),
        'middleware' => [
            'api',
        ],
    ],

    'docs' => [
        'enabled' => env('L5_SWAGGER_DOCS_ENABLED', true),
        'prefix' => env('L5_SWAGGER_DOCS_PREFIX', 'api/docs'),
        'middleware' => [
            'web',
        ],
    ],

    'swagger' => [
        'enabled' => env('L5_SWAGGER_SWAGGER_ENABLED', true),
        'prefix' => env('L5_SWAGGER_SWAGGER_PREFIX', 'api/docs'),
        'middleware' => [
            'web',
        ],
    ],

    'paths' => [
        'docs' => storage_path('api-docs'),
        'docs_json' => storage_path('api-docs/swagger.json'),
        'annotations' => base_path('app/Http/Controllers'),
    ],

    'defaults' => [
        'title' => env('L5_SWAGGER_TITLE', 'API Documentation'),
        'description' => env('L5_SWAGGER_DESCRIPTION', 'API documentation for the application.'),
        'version' => env('L5_SWAGGER_VERSION', '1.0.0'),
    ],

    'routes' => [
        'api' => [
            'enabled' => true,
            'prefix' => 'api',
            'middleware' => ['api'],
        ],
        'docs' => [
            'enabled' => true,
            'prefix' => 'api/docs',
            'middleware' => ['web'],
        ],
        'swagger' => [
            'enabled' => true,
            'prefix' => 'api/docs',
            'middleware' => ['web'],
        ],
    ],

    'generate' => [
        'path' => storage_path('api-docs'),
        'json_file' => 'swagger.json',
        'name' => 'swagger',
        'merge' => true,
    ],
];
