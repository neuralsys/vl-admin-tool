<?php

namespace Vuongdq\VLAdminTool\Common;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Commands\BaseCommand;

class GeneratorConfig
{
    /* Namespace variables */
    public $nsApp;
    public $nsRepository;
    public $nsModel;
    public $nsDataTables;
    public $nsModelExtend;

    public $nsApiController;
    public $nsApiRequest;

    public $nsRequest;
    public $nsRequestBase;
    public $nsController;
    public $nsBaseController;

    public $nsApiTests;
    public $nsRepositoryTests;
    public $nsTestTraits;
    public $nsTests;

    /* Path variables */
    public $pathRepository;
    public $pathModel;
    public $pathDataTables;
    public $pathFactory;
    public $pathSeeder;
    public $pathDatabaseSeeder;
    public $pathViewProvider;

    public $pathApiController;
    public $pathApiRequest;
    public $pathApiRoutes;
    public $pathApiTests;

    public $pathController;
    public $pathRequest;
    public $pathRoutes;
    public $pathViews;
    public $modelJsPath;

    /* Models Names */
    public $mName;
    public $mPlural;
    public $mCamel;
    public $mCamelPlural;
    public $mSnake;
    public $mSnakePlural;
    public $mDashed;
    public $mDashedPlural;
    public $mSlash;
    public $mSlashPlural;
    public $mHuman;
    public $mHumanPlural;

    public $connection = '';

    /* Generator Options */
    public $options;

    /* Prefixes */
    public $prefixes;

    /** @var CommandData */
    private $commandData;

    /* Command Options */
    public $availableOptions;

    public $tableName;

    /** @var string */
    protected $primaryName;

    /* Generator AddOns */
    public $addOns;

    public function init(CommandData &$commandData, $options = null)
    {
        $this->commandData = &$commandData;

        if (!empty($options)) {
            $this->availableOptions = $options;
        } else {
            $this->availableOptions = $this->getAvailableOptions();
        }

        $this->prepareAddOns();
        $this->prepareOptions();
        $this->prepareModelNames();
        $this->preparePrefixes();
        $this->loadPaths();
        $this->prepareTableName();
        $this->preparePrimaryName();
        $this->loadNamespaces();
        $this->loadDynamicVariables();
    }

    public function loadNamespaces()
    {
        $prefix = $this->prefixes['ns'];

        if (!empty($prefix)) {
            $prefix = '\\'.$prefix;
        }

        $this->nsApp = $this->commandData->commandObj->getLaravel()->getNamespace();
        $this->nsApp = substr($this->nsApp, 0, strlen($this->nsApp) - 1);
        $this->nsRepository = config('vl_admin_tool.namespace.repository', 'App\Repositories').$prefix;
        $this->nsModel = config('vl_admin_tool.namespace.model', 'App\Models').$prefix;
        if (config('vl_admin_tool.ignore_model_prefix', false)) {
            $this->nsModel = config('vl_admin_tool.namespace.model', 'App\Models');
        }
        $this->nsDataTables = config('vl_admin_tool.namespace.datatables', 'App\DataTables').$prefix;
        $this->nsModelExtend = config(
            'vl_admin_tool.model_extend_class',
            'Illuminate\Database\Eloquent\Model'
        );

        $this->nsApiController = config(
            'vl_admin_tool.namespace.api_controller',
            'App\Http\Controllers\API'
        ).$prefix;
        $this->nsApiRequest = config('vl_admin_tool.namespace.api_request', 'App\Http\Requests\API').$prefix;

        $this->nsRequest = config('vl_admin_tool.namespace.request', 'App\Http\Requests').$prefix;
        $this->nsRequestBase = config('vl_admin_tool.namespace.request', 'App\Http\Requests');
        $this->nsBaseController = config('vl_admin_tool.namespace.controller', 'App\Http\Controllers');
        $this->nsController = config('vl_admin_tool.namespace.controller', 'App\Http\Controllers').$prefix;

        $this->nsApiTests = config('vl_admin_tool.namespace.api_test', 'Tests\APIs');
        $this->nsRepositoryTests = config('vl_admin_tool.namespace.repository_test', 'Tests\Repositories');
        $this->nsTests = config('vl_admin_tool.namespace.tests', 'Tests');
    }

    public function loadPaths()
    {
        $prefix = $this->prefixes['path'];

        if (!empty($prefix)) {
            $prefix .= '/';
        }

        $viewPrefix = $this->prefixes['view'];

        if (!empty($viewPrefix)) {
            $viewPrefix .= '/';
        }

        $this->pathRepository = config(
            'vl_admin_tool.path.repository',
            app_path('Repositories/')
        ).$prefix;

        $this->pathModel = config('vl_admin_tool.path.model', app_path('Models/')).$prefix;
        if (config('vl_admin_tool.ignore_model_prefix', false)) {
            $this->pathModel = config('vl_admin_tool.path.model', app_path('Models/'));
        }

        $this->pathDataTables = config('vl_admin_tool.path.datatables', app_path('DataTables/')).$prefix;

        $this->pathApiController = config(
            'vl_admin_tool.path.api_controller',
            app_path('Http/Controllers/API/')
        ).$prefix;

        $this->pathApiRequest = config(
            'vl_admin_tool.path.api_request',
            app_path('Http/Requests/API/')
        ).$prefix;

        $this->pathApiRoutes = config('vl_admin_tool.path.api_routes', base_path('routes/api.php'));

        $this->pathApiTests = config('vl_admin_tool.path.api_test', base_path('tests/APIs/'));

        $this->pathController = config(
            'vl_admin_tool.path.controller',
            app_path('Http/Controllers/')
        ).$prefix;

        $this->pathRequest = config('vl_admin_tool.path.request', app_path('Http/Requests/')).$prefix;

        $this->pathRoutes = config('vl_admin_tool.path.routes', base_path('routes/web.php'));
        $this->pathFactory = config('vl_admin_tool.path.factory', database_path('factories/'));

        $this->pathViews = config(
            'vl_admin_tool.path.views',
            resource_path('views/')
        ).$viewPrefix.$this->mSnakePlural.'/';

        $this->pathSeeder = config('vl_admin_tool.path.seeder', database_path('seeds/'));
        $this->pathDatabaseSeeder = config('vl_admin_tool.path.database_seeder', database_path('seeds/DatabaseSeeder.php'));
        $this->pathViewProvider = config(
            'vl_admin_tool.path.view_provider',
            app_path('Providers/ViewServiceProvider.php')
        );

        $this->modelJsPath = config(
            'vl_admin_tool.path.modelsJs',
            resource_path('assets/js/models/')
        );
    }

    public function loadDynamicVariables()
    {
        $this->commandData->addDynamicVariable('$NAMESPACE_APP$', $this->nsApp);
        $this->commandData->addDynamicVariable('$NAMESPACE_REPOSITORY$', $this->nsRepository);
        $this->commandData->addDynamicVariable('$NAMESPACE_MODEL$', $this->nsModel);
        $this->commandData->addDynamicVariable('$NAMESPACE_DATATABLES$', $this->nsDataTables);
        $this->commandData->addDynamicVariable('$NAMESPACE_MODEL_EXTEND$', $this->nsModelExtend);

        $this->commandData->addDynamicVariable('$NAMESPACE_API_CONTROLLER$', $this->nsApiController);
        $this->commandData->addDynamicVariable('$NAMESPACE_API_REQUEST$', $this->nsApiRequest);

        $this->commandData->addDynamicVariable('$NAMESPACE_BASE_CONTROLLER$', $this->nsBaseController);
        $this->commandData->addDynamicVariable('$NAMESPACE_CONTROLLER$', $this->nsController);
        $this->commandData->addDynamicVariable('$NAMESPACE_REQUEST$', $this->nsRequest);
        $this->commandData->addDynamicVariable('$NAMESPACE_REQUEST_BASE$', $this->nsRequestBase);

        $this->commandData->addDynamicVariable('$NAMESPACE_API_TESTS$', $this->nsApiTests);
        $this->commandData->addDynamicVariable('$NAMESPACE_REPOSITORIES_TESTS$', $this->nsRepositoryTests);
        $this->commandData->addDynamicVariable('$NAMESPACE_TESTS$', $this->nsTests);

        $this->commandData->addDynamicVariable('$TABLE_NAME$', $this->tableName);
        $this->commandData->addDynamicVariable('$TABLE_NAME_TITLE$', Str::studly($this->tableName));
        $this->commandData->addDynamicVariable('$PRIMARY_KEY_NAME$', $this->primaryName);

        $this->commandData->addDynamicVariable('$MODEL_NAME$', $this->mName);
        $this->commandData->addDynamicVariable('$MODEL_NAME_CAMEL$', $this->mCamel);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL$', $this->mPlural);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL_CAMEL$', $this->mCamelPlural);
        $this->commandData->addDynamicVariable('$MODEL_NAME_SNAKE$', $this->mSnake);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL_SNAKE$', $this->mSnakePlural);
        $this->commandData->addDynamicVariable('$MODEL_NAME_DASHED$', $this->mDashed);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL_DASHED$', $this->mDashedPlural);
        $this->commandData->addDynamicVariable('$MODEL_NAME_SLASH$', $this->mSlash);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL_SLASH$', $this->mSlashPlural);
        $this->commandData->addDynamicVariable('$MODEL_NAME_HUMAN$', $this->mHuman);
        $this->commandData->addDynamicVariable('$MODEL_NAME_PLURAL_HUMAN$', $this->mHumanPlural);
        $this->commandData->addDynamicVariable('$FILES$', '');

        $connectionText = '';
        if ($connection = $this->getOption('connection')) {
            $this->connection = $connection;
            $connectionText = infy_tab(4).'public $connection = "'.$connection.'";';
        }
        $this->commandData->addDynamicVariable('$CONNECTION$', $connectionText);

        if (!empty($this->prefixes['route'])) {
            $this->commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', $this->prefixes['route'].'.');
            $this->commandData->addDynamicVariable('$ROUTE_PREFIX$', str_replace('.', '/', $this->prefixes['route']).'/');
            $this->commandData->addDynamicVariable('$RAW_ROUTE_PREFIX$', $this->prefixes['route']);
        } else {
            $this->commandData->addDynamicVariable('$ROUTE_PREFIX$', '');
            $this->commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', '');
        }

        if (!empty($this->prefixes['ns'])) {
            $this->commandData->addDynamicVariable('$PATH_PREFIX$', $this->prefixes['ns'].'\\');
        } else {
            $this->commandData->addDynamicVariable('$PATH_PREFIX$', '');
        }

        if (!empty($this->prefixes['view'])) {
            $this->commandData->addDynamicVariable('$VIEW_PREFIX$', str_replace('/', '.', $this->prefixes['view']).'.');
        } else {
            $this->commandData->addDynamicVariable('$VIEW_PREFIX$', '');
        }

        if (!empty($this->prefixes['public'])) {
            $this->commandData->addDynamicVariable('$PUBLIC_PREFIX$', $this->prefixes['public']);
        } else {
            $this->commandData->addDynamicVariable('$PUBLIC_PREFIX$', '');
        }

        if (!empty($this->prefixes['ns_view'])) {
            $this->commandData->addDynamicVariable('$NS_VIEW_PREFIX$', $this->prefixes['ns_view']);
        } else {
            $this->commandData->addDynamicVariable('$NS_VIEW_PREFIX$', '');
        }

        if (!empty($this->prefixes['ns_locale'])) {
            $this->commandData->addDynamicVariable('$NS_LOCALE_PREFIX$', $this->prefixes['ns_locale']);
        } else {
            $this->commandData->addDynamicVariable('$NS_LOCALE_PREFIX$', '');
        }

        $this->commandData->addDynamicVariable(
            '$API_PREFIX$',
            config('vl_admin_tool.api_prefix', 'api')
        );

        $this->commandData->addDynamicVariable(
            '$API_VERSION$',
            config('vl_admin_tool.api_version', 'v1')
        );
    }

    public function prepareTableName()
    {
        $this->tableName = $this->commandData->modelObject->getAttribute('table_name');
    }

    public function preparePrimaryName()
    {
        $this->primaryName = 'id';
    }

    public function prepareModelNames()
    {
        $this->mName = $this->commandData->modelName;
        $this->mPlural = $this->commandData->modelObject->plural;
        $this->mCamel = Str::camel($this->mName);
        $this->mCamelPlural = Str::camel($this->mPlural);
        $this->mSnake = Str::snake($this->mName);
        $this->mSnakePlural = Str::snake($this->mPlural);
        $this->mDashed = str_replace('_', '-', Str::snake($this->mSnake));
        $this->mDashedPlural = str_replace('_', '-', Str::snake($this->mSnakePlural));
        $this->mSlash = str_replace('_', '/', Str::snake($this->mSnake));
        $this->mSlashPlural = str_replace('_', '/', Str::snake($this->mSnakePlural));
        $this->mHuman = Str::title(str_replace('_', ' ', Str::snake($this->mSnake)));
        $this->mHumanPlural = Str::title(str_replace('_', ' ', Str::snake($this->mSnakePlural)));
    }

    public function getPrefixKeysFromConfig() {
        return array_keys(config('vl-admin-tool.prefixes', []));
    }

    public function prepareOptions()
    {
        foreach ($this->availableOptions as $option) {
            $this->options[$option] = $this->commandData->commandObj->option($option);
        }
        # add prefix options
        $prefixKeys = $this->getPrefixKeysFromConfig();
        foreach ($prefixKeys as $prefixKey) {
            $option = 'prefix_'.$prefixKey;
            $this->options[$option] = $this->commandData->commandObj->option($option);
        }

        # Todo: Remove
        $this->commandData->getTemplatesManager()->setUseLocale(true);

        $this->options['softDelete'] = $this->commandData->modelObject->use_soft_delete;

        if (isset($this->options['skip'])) {
            $this->options['skip'] = explode(",", $this->options['skip']);
        }
    }

    public function preparePrefixes()
    {
        # init prefix from config
        $this->prefixes['route'] = explode('/', config('vl_admin_tool.prefixes.route', ''));
        $this->prefixes['path'] = explode('/', config('vl_admin_tool.prefixes.path', ''));
        $this->prefixes['view'] = explode('.', config('vl_admin_tool.prefixes.view', ''));
        $this->prefixes['public'] = explode('/', config('vl_admin_tool.prefixes.public', ''));
        $this->prefixes['ns_view'] = explode('/', config('vl_admin_tool.prefixes.ns_view', ''));
        $this->prefixes['ns_locale'] = explode('/', config('vl_admin_tool.prefixes.ns_locale', ''));

        # update prefix with CLI if exist
        $prefixKeys = $this->getPrefixKeysFromConfig();
        foreach ($prefixKeys as $prefixKey) {
            $option = 'prefix_'.$prefixKey;
            if ($this->getOption($option))
                $this->prefixes[$prefixKey] = explode('/', $this->getOption($option));

            $this->prefixes[$prefixKey] = array_diff($this->prefixes[$prefixKey], ['']);
        }

        # build route prefix
        $routePrefix = '';

        foreach ($this->prefixes['route'] as $singlePrefix) {
            $routePrefix .= Str::camel($singlePrefix).'.';
        }

        if (!empty($routePrefix)) {
            $routePrefix = substr($routePrefix, 0, strlen($routePrefix) - 1);
        }

        $this->prefixes['route'] = $routePrefix;

        # build ns prefix
        $nsPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $nsPrefix .= Str::title($singlePrefix).'\\';
        }

        if (!empty($nsPrefix)) {
            $nsPrefix = substr($nsPrefix, 0, strlen($nsPrefix) - 1);
        }

        $this->prefixes['ns'] = $nsPrefix;

        # build path prefix
        $pathPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $pathPrefix .= Str::title($singlePrefix).'/';
        }

        if (!empty($pathPrefix)) {
            $pathPrefix = substr($pathPrefix, 0, strlen($pathPrefix) - 1);
        }

        $this->prefixes['path'] = $pathPrefix;

        # build view prefix
        $viewPrefix = '';

        foreach ($this->prefixes['view'] as $singlePrefix) {
            $viewPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($viewPrefix)) {
            $viewPrefix = substr($viewPrefix, 0, strlen($viewPrefix) - 1);
        }

        $this->prefixes['view'] = $viewPrefix;

        # build public prefix
        $publicPrefix = '';

        foreach ($this->prefixes['public'] as $singlePrefix) {
            $publicPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($publicPrefix)) {
            $publicPrefix = substr($publicPrefix, 0, strlen($publicPrefix) - 1);
        }

        $this->prefixes['public'] = $publicPrefix;

        # build ns view prefix
        $nsViewPrefix = '';
        foreach ($this->prefixes['ns_view'] as $singlePrefix) {
            $nsViewPrefix .= $singlePrefix;
        }

        $this->prefixes['ns_view'] = $nsViewPrefix;

        # build ns locale prefix
        $nsLocalePrefix = '';
        foreach ($this->prefixes['ns_locale'] as $singlePrefix) {
            $nsLocalePrefix .= $singlePrefix;
        }

        $this->prefixes['ns_locale'] = $nsLocalePrefix;
    }

    public function overrideOptionsFromJsonFile($jsonData)
    {
        $options = $this->availableOptions;

        foreach ($options as $option) {
            if (isset($jsonData['options'][$option])) {
                $this->setOption($option, $jsonData['options'][$option]);
            }
        }

        // prepare prefixes than reload namespaces, paths and dynamic variables
        if (!empty($this->getOption('prefix'))) {
            $this->preparePrefixes();
            $this->loadPaths();
            $this->loadNamespaces($this->commandData);
            $this->loadDynamicVariables($this->commandData);
        }

        $addOns = ['swagger', 'tests'];

        foreach ($addOns as $addOn) {
            if (isset($jsonData['addOns'][$addOn])) {
                $this->addOns[$addOn] = $jsonData['addOns'][$addOn];
            }
        }
    }

    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }

        return false;
    }

    public function getAddOn($addOn)
    {
        if (isset($this->addOns[$addOn])) {
            return $this->addOns[$addOn];
        }

        return false;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function prepareAddOns()
    {
        $this->addOns['swagger'] = config('vl_admin_tool.add_on.swagger', false);
        $this->addOns['tests'] = config('vl_admin_tool.add_on.tests', false);
        $this->addOns['menu.enabled'] = config('vl_admin_tool.add_on.menu.enabled', false);
        $this->addOns['menu.menu_file'] = config('vl_admin_tool.add_on.menu.menu_file', 'layouts.menu');
    }

    private function getAvailableOptions() {
        $options = (new BaseCommand())->getOptions();
        $res = [];
        foreach ($options as $option)
            $res[] = $option[0];
        return $res;
    }
}
