<?php

namespace Vuongdq\VLAdminTool\Commands\Publish;

use Vuongdq\VLAdminTool\Utils\FileUtil;
use Symfony\Component\Console\Input\InputOption;

class GeneratorPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes & init api routes, base controller, base test cases traits.';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing...');
        $this->copyView();
        $this->updateRoutes();
        $this->publishHomeController();

        $this->publishTestCases();
        $this->publishTraits();
        $this->publishBaseController();
        $this->publishBaseRepository();
        $this->publishLocaleFiles();
        $this->info('Publish successfully!');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $apiVersion = config('vl_admin_tool.api_version', 'v1');
        $apiPrefix = config('vl_admin_tool.api_prefix', 'api');
        $traitNameSpace = config('vl_admin_tool.namespace.traits', 'App\Traits');

        $templateData = str_replace('$API_VERSION$', $apiVersion, $templateData);
        $templateData = str_replace('$API_PREFIX$', $apiPrefix, $templateData);
        $templateData = str_replace('$JSON_RESPONSE_TRAIT_NAMESPACE$', $traitNameSpace, $templateData);

        $appNamespace = $this->getLaravel()->getNamespace();
        $appNamespace = substr($appNamespace, 0, strlen($appNamespace) - 1);
        $templateData = str_replace('$NAMESPACE_APP$', $appNamespace, $templateData);

        return $templateData;
    }

    private function publishTestCases()
    {
        $testsPath = config('vl_admin_tool.path.tests', base_path('tests/'));
        $testsNameSpace = config('vl_admin_tool.namespace.tests', 'Tests');
        $createdAtField = config('vl_admin_tool.timestamps.created_at', 'created_at');
        $updatedAtField = config('vl_admin_tool.timestamps.updated_at', 'updated_at');

        $templateData = get_template('test.api_test_trait', 'vl-admin-tool');

        $templateData = str_replace('$NAMESPACE_TESTS$', $testsNameSpace, $templateData);
        $templateData = str_replace('$TIMESTAMPS$', "['$createdAtField', '$updatedAtField']", $templateData);

        $fileName = 'ApiTestTrait.php';

        if (file_exists($testsPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($testsPath, $fileName, $templateData);
        $this->info('ApiTestTrait created');

        $testAPIsPath = config('vl_admin_tool.path.api_test', base_path('tests/APIs/'));
        if (!file_exists($testAPIsPath)) {
            FileUtil::createDirectoryIfNotExist($testAPIsPath);
            $this->info('APIs Tests directory created');
        }

        $testRepositoriesPath = config('vl_admin_tool.path.repository_test', base_path('tests/Repositories/'));
        if (!file_exists($testRepositoriesPath)) {
            FileUtil::createDirectoryIfNotExist($testRepositoriesPath);
            $this->info('Repositories Tests directory created');
        }
    }

    private function publishBaseController()
    {
        $templateData = get_template('api_base_controller', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = app_path('Http/Controllers/');

        $fileName = 'ApiBaseController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('ApiBaseController created');

        $templateData = get_template('base_controller', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = app_path('Http/Controllers/');

        $fileName = 'Controller.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('Controller created');
    }

    private function publishBaseRepository()
    {
        $templateData = get_template('base_repository', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $repositoryPath = app_path('Repositories/');

        FileUtil::createDirectoryIfNotExist($repositoryPath);

        $fileName = 'BaseRepository.php';

        if (file_exists($repositoryPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($repositoryPath, $fileName, $templateData);

        $this->info('BaseRepository created');
    }

    private function publishLocaleFiles()
    {
        $localesDir = __DIR__ . '/../../../locale/';

        $this->publishDirectory($localesDir, resource_path('lang'), 'lang', true);

        $this->comment('Locale files published');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['localized', null, InputOption::VALUE_NONE, 'Localize files.'],
            ['force', null, InputOption::VALUE_NONE, 'Force update'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    private function publishTraits() {
        $templateData = get_template('traits.json_response_trait', 'vl-admin-tool');
        $traitNameSpace = config('vl_admin_tool.namespace.traits', 'App\Traits');

        $templateData = str_replace('$NAMESPACE$', $traitNameSpace, $templateData);

        $fileName = 'JsonResponse.php';
        $traitPath = config('vl_admin_tool.path.trait', app_path('Traits/'));
        if (file_exists($traitPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($traitPath, $fileName, $templateData);
        $this->info('JsonResponseTrait created');
    }

    private function copyView()
    {
        $viewsPath = config('vl_admin_tool.path.views', resource_path('views/'));
        $templateType = config('vl_admin_tool.templates', 'adminlte-templates');

        $this->createDirectories($viewsPath);

        $files = $this->getLocaleViews();

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path($stub, $templateType);
            $destinationFile = $viewsPath.$blade;
            $this->publishFile($sourceFile, $destinationFile, $blade);
        }
    }

    private function createDirectories($viewsPath)
    {
        FileUtil::createDirectoryIfNotExist($viewsPath.'layouts');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth');

        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/passwords');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/emails');
    }

    private function getLocaleViews()
    {
        return [
            'layouts/app'        => 'layouts/app.blade.php',
            'layouts/sidebar'    => 'layouts/sidebar.blade.php',
            'layouts/datatables_css'    => 'layouts/datatables_css.blade.php',
            'layouts/datatables_js'     => 'layouts/datatables_js.blade.php',
            'layouts/menu'              => 'layouts/menu.blade.php',
            'layouts/home'              => 'home.blade.php',
            'auth/login'         => 'auth/login.blade.php',
            'auth/register'      => 'auth/register.blade.php',
            'auth/email'         => 'auth/passwords/email.blade.php',
            'auth/reset'         => 'auth/passwords/reset.blade.php',
            'emails/password'    => 'auth/emails/password.blade.php',
        ];
    }

    private function updateRoutes()
    {
        $path = config('vl_admin_tool.path.routes', base_path('routes/web.php'));

        $prompt = 'Existing routes web.php file detected. Should we add standard auth routes? (y|N) :';
        if (file_exists($path) && !$this->confirmOverwrite($path, $prompt)) {
            return;
        }

        $routeContents = file_get_contents($path);

        $routesTemplate = get_template('routes.auth', 'vl-admin-tool');

        $routeContents .= "\n\n".$routesTemplate;

        file_put_contents($path, $routeContents);
        $this->comment("\nRoutes added");
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'vl-admin-tool');

        $templateData = $this->fillHomeControllerTemplate($templateData);

        $controllerPath = config('vl_admin_tool.path.controller', app_path('Http/Controllers/'));

        $fileName = 'HomeController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('HomeController created');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillHomeControllerTemplate($templateData)
    {
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('vl_admin_tool.namespace.controller'),
            $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('vl_admin_tool.namespace.request'),
            $templateData
        );

        return $templateData;
    }
}
