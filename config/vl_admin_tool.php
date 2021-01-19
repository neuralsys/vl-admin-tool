<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration'         => database_path('migrations/'),

        'model'             => app_path('Models/'),

        'models_locale_files' => base_path('resources/lang/en/models/'),

        'trait'             => app_path('Traits/'),

        'datatables'        => app_path('DataTables/'),

        'repository'        => app_path('Repositories/'),

        'routes'            => base_path('routes/web.php'),

        'api_routes'        => base_path('routes/api.php'),

        'request'           => app_path('Requests/'),

        'api_request'       => app_path('Requests/API/'),

        'controller'        => app_path('Http/Controllers/'),

        'api_controller'    => app_path('Http/Controllers/API/'),

        'repository_test'   => base_path('tests/Repositories/'),

        'api_test'          => base_path('tests/APIs/'),

        'tests'             => base_path('tests/'),

        'views'             => resource_path('views/'),

        'schema_files'      => resource_path('model_schemas/'),

        'templates_dir'     => resource_path('vl-admin-tool/templates/'),

        'seeder'            => database_path('Seeds/'),

        'database_seeder'   => database_path('Seeds/DatabaseSeeder.php'),

        'factory'           => database_path('factories/'),

        'view_provider'     => app_path('Providers/ViewServiceProvider.php'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [

        'model'             => 'App\Models',

        'datatables'        => 'App\DataTables',

        'repository'        => 'App\Repositories',

        'controller'        => 'App\Controllers',

        'api_controller'    => 'App\Http\Controllers\API',

        'request'           => 'App\Requests',

        'api_request'       => 'App\Requests\API',

        'repository_test'   => 'Tests\Repositories',

        'api_test'          => 'Tests\APIs',

        'tests'             => 'Tests',

        'traits'            => 'App\Traits'
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'templates'         => 'adminlte-templates',

    /*
    |--------------------------------------------------------------------------
    | Models extend class
    |--------------------------------------------------------------------------
    |
    */

    'model_extend_class' => 'Eloquent',

    /*
    |--------------------------------------------------------------------------
    | API routes prefix & version
    |--------------------------------------------------------------------------
    |
    */

    'api_prefix'  => 'api',

    'api_version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [
        'softDelete' => true,

        'save_schema_file' => true,

        'tables_searchable_default' => false,

        'excluded_fields' => ['id'], // Array of columns that doesn't required while creating module
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefixes
    |--------------------------------------------------------------------------
    |
    */

    'prefixes' => [

        'route' => '',  // using admin will create route('admin.?.index') type routes

        'path' => '',

        'view' => '',  // using backend will create return view('backend.?.index') type the backend views directory

        'public' => '',

        'ns_view' => '',

        'ns_locale' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Add-Ons
    |--------------------------------------------------------------------------
    |
    */

    'add_on' => [

        'swagger'       => false,

        'tests'         => true,

        'menu'          => [

            'enabled'       => true,

            'menu_file'     => 'layouts/menu.blade.php',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timestamp Fields
    |--------------------------------------------------------------------------
    |
    */

    'timestamps' => [

        'enabled'       => true,

        'created_at'    => 'created_at',

        'updated_at'    => 'updated_at',

        'deleted_at'    => 'deleted_at',
    ],

    /*
    |--------------------------------------------------------------------------
    | Save model files to `App/Models` when use `--prefix`. see #208
    |--------------------------------------------------------------------------
    |
    */
    'ignore_model_prefix' => false,

    /*
    |--------------------------------------------------------------------------
    | Specify custom doctrine mappings as per your need
    |--------------------------------------------------------------------------
    |
    */
    'from_table' => [
        'doctrine_mappings' => [],
    ],

    'admin_middleware' => [
        'admin.user'
    ],

    'admin_id' => 1,
];
