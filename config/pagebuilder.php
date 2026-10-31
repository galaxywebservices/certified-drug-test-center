<?php

return [
    /*
     |--------------------------------------------------------------------------
     | General settings
     |--------------------------------------------------------------------------
     |
     | General settings for configuring the PageBuilder.
     |
     */
    'general' => [
        'base_url' => env('APP_URL'),
        'language' => 'en',
        'assets_url' => '/assets',
        'uploads_url' => '/uploads'
    ],

    /*
     |--------------------------------------------------------------------------
     | Storage settings
     |--------------------------------------------------------------------------
     |
     | Database and file storage settings.
     |
     */
    'storage' => [
        'use_database' => true,
        'database' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1') . ';port=' . env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'cdtc'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => 'pagebuilder__',
        ],
        'uploads_folder' => storage_path('app/pagebuilder/uploads')
    ],

    /*
     |--------------------------------------------------------------------------
     | Auth settings
     |--------------------------------------------------------------------------
     |
     | Uses our CustomAuth class integrated with Laravel authentication.
     |
     */
    'auth' => [
        'use_login' => true,
        'class' => App\PageBuilder\CustomAuth::class,
        'url' => '/admin/auth',
        'username' => 'admin',
        'password' => 'changethispassword'
    ],

    /*
     |--------------------------------------------------------------------------
     | WebsiteManager settings
     |--------------------------------------------------------------------------
     |
     | Disabled so Laravel handles the page lists and editing forms.
     |
     */
    'website_manager' => [
        'use_website_manager' => false,
        'class' => PHPageBuilder\Modules\WebsiteManager\WebsiteManager::class,
        'url' => '/admin/pagebuilder-manager'
    ],

    /*
     |--------------------------------------------------------------------------
     | Website settings
     |--------------------------------------------------------------------------
     |
     */
    'setting' => [
        'class' => PHPageBuilder\Setting::class
    ],

    /*
     |--------------------------------------------------------------------------
     | PageBuilder settings
     |--------------------------------------------------------------------------
     |
     | GrapesJS PageBuilder configuration.
     |
     */
    'pagebuilder' => [
        'class' => App\PageBuilder\CustomPageBuilder::class,
        'url' => '/admin/pagebuilder',
        'actions' => [
            'back' => '/admin/pages'
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Page settings
     |--------------------------------------------------------------------------
     |
     */
    'page' => [
        'class' => PHPageBuilder\Page::class,
        'table' => 'pages',
        'translation' => [
            'class' => PHPageBuilder\PageTranslation::class,
            'table' => 'page_translations',
            'foreign_key' => 'page_id',
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Cache settings
     |--------------------------------------------------------------------------
     |
     */
    'cache' => [
        'enabled' => false,
        'folder' => __DIR__ . '/cache',
        'class' => PHPageBuilder\Cache::class
    ],

    /*
     |--------------------------------------------------------------------------
     | Theme settings
     |--------------------------------------------------------------------------
     |
     | Active theme is 'ata' with modular blocks.
     |
     */
    'theme' => [
        'class' => PHPageBuilder\Theme::class,
        'folder' => base_path('themes'),
        'folder_url' => '/themes',
        'active_theme' => 'ata'
    ],

    /*
     |--------------------------------------------------------------------------
     | Routing settings
     |--------------------------------------------------------------------------
     |
     | Router is disabled so Laravel continues handling all application routes.
     |
     */
    'router' => [
        'class' => PHPageBuilder\Modules\Router\DatabasePageRouter::class,
        'use_router' => false
    ],

    /*
     |--------------------------------------------------------------------------
     | Class replacements
     |--------------------------------------------------------------------------
     |
     */
    'class_replacements' => [
        PHPageBuilder\Contracts\PageRepositoryContract::class => App\PageBuilder\CustomPageRepository::class
    ],
];
